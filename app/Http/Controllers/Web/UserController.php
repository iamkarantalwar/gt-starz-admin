<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Protected Repository
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Return All The Users
    public function index()
    {
        $users = $this->userRepository->all();
        return view('user.index')->with(['users' => $users]);
    }

    //Chnage The User Status
    public function changeApprovalStatus(User $user, bool $status)
    {
        $update = $this->userRepository->changeApprovalStatus($user, $status);
        if($update) {
            return redirect()->back()->with('success', 'User Approval Status Changed Successfully');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong. Try again later.');
        }
    }

}
