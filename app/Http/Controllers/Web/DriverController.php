<?php

namespace App\Http\Controllers\Web;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\DriverRequest;
use App\Repositories\Driver\DriverRepositoryInterface;

class DriverController extends Controller
{
    //Protected Repository
    protected $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = $this->driverRepository->all();
        return view('driver.index')->with(['drivers' => $drivers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.add-edit')->with(['driver' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequest $request)
    {
        $driver = $this->driverRepository->create($request->all());
        if($driver) {
            return redirect()->back()->with('success', 'Driver added successfully.');
        } else {
            return redirect()->back()->with('dnger', 'Something went wrong. Try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        return view('driver.add-edit')->with(['driver' => $driver]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(DriverRequest $request, Driver $driver)
    {
        $update = $this->driverRepository->update($request->all(), $driver);
        if($update) {
            return redirect()->back()->with('success', 'Driver updated successfully.');
        } else {
            return redirect()->back()->with('success', 'Something went wrong. Try again later.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $driver = $this->driverRepository->delete($driver);
        if($driver) {
            return redirect()->back()->with('success', 'Driver deleted successfully.');
        } else {
            return redirect()->back()->with('success', 'Something went wrong. Try again later.');
        }
    }

     //Chnage The driver Status
     public function changeApprovalStatus(Driver $driver, bool $status)
     {
         $update = $this->driverRepository->changeApprovalStatus($driver, $status);
         if($update) {
             return redirect()->back()->with('success', 'Driver Approval Status Changed Successfully');
         } else {
             return redirect()->back()->with('danger', 'Something went wrong. Try again later.');
         }
     }

}
