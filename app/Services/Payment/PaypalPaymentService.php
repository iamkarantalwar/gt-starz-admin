<?php namespace App\Services\Payment;

/** Paypal Details classes **/

use App\enums\PaymentMethod;
use App\Models\Order\Order;
use App\Models\Payment\PaypalPayment;
use App\Models\User;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\User\UserRepository;
use App\Services\OrderService;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use PayPal\Exception\PayPalConnectionException;
use Exception;
use Illuminate\Support\Facades\URL;

class PaypalPaymentService implements PaymentServiceInterface
{
    private $api_context, $orderService, $orderDetailRepository, $paypalPayment, $userRepository;

    public function __construct(OrderService $orderService,
                                OrderDetailRepository $orderDetailRepository,
                                PaypalPayment $paypalPayment,
                                UserRepository $userRepository)
    {
        $this->paypalPayment = $paypalPayment;
        $this->orderService = $orderService;
        $this->userRepository = $userRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $paypal_conf = \Config::get('paypal');
        $this->api_context = new ApiContext(new OAuthTokenCredential(
            'AeJK5Ei8CIzUk5QsHW5zYopHF858ceVO0z4mB_CICboBVB05R1UUfXzrN9iSYnHWIeynAOOvVJ2LWl1g',
            'EAFTtC8_n4rx8xY3SRHFf1pEhaJPpT_hbKWImoJ8tz8xs7HvmPw0cjzYaTZ6eLgNQUo-To-dOby_72vW'
        ));

        $this->api_context->setConfig(array(
            'mode' => env('PAYPAL_MODE','sandbox'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        ));
    }

    public function changePayerId(User $user, $papalId)
    {
        $update = $this->userRepository->update($user, [
            'paypal_id' => $papalId,
        ]);

        if($update) {
            return true;
        } else {
            return false;
        }
    }
    public function paymentProcess($request, Order $order)
    {
        $paymentCurrency = 'USD';
        $order = $this->orderService->getUserOrder($order->id);
        // $amountToBePaid = $order->total;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_list = new ItemList();
        $items_array = array();
        foreach($order->orderProducts as $product) {
            $item = new Item();
            $item->setName($product->product_name) /** item name **/
                ->setCurrency($paymentCurrency)
                ->setQuantity($product->quantity)
                ->setPrice($product->cost - $product->discount); /** unit price **/
            array_push($items_array, $item);
        }

        $item_list->setItems($items_array);

        $amount = new Amount();
        $amount->setCurrency($paymentCurrency)
               ->setTotal($order->total);

        $redirect_urls = new RedirectUrls();
        /** Specify return URL **/
        $redirect_urls->setReturnUrl(route('confirm.payment', ['method' => PaymentMethod::PAYPAL, 'order' => $order->id]))
                  ->setCancelUrl(route('confirm.payment', ['method' => PaymentMethod::PAYPAL, 'order' => $order->id]));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Order No. ' . $order->id );

        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        try {
             $response = $payment->create($this->api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
             return false;
        }

        return [
            'token' => $response->getToken()
        ];
    }

    public function createPayment($data, $order) {
        $data['order_id'] = $order->id;
        $create = $this->paypalPayment->updateOrCreate($data);
        if($create) {
            return true;
        } else {
            return false;
        }
    }

    public function confirmPayment($transactionId, $orderId) {

      /** Get the payment ID before session clear **/
      $payment_id = 'PAYID-L677RHA4V179686UF394123C';
      $payment = Payment::get($payment_id, $this->api_context);
      $execution = new PaymentExecution();
      $execution->setPayerId('BDULE727HDS38');
      /**Execute the payment **/
      $result = $payment->execute($execution, $this->api_context);
        return $result->getState();
      if ($result->getState() == 'approved') {
         session()->flash('success', 'Payment success');
         return Redirect::route('/');
      }
      session()->flash('error', 'Payment failed');
      return Redirect::route('/');
    }
}
