<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Validator;
use App\Model\Drivers;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\Bookings;
use App\Model\Notification;
use App\Model\DriverWallet;
use App\Model\Accounts;
use Carbon\Carbon;
use App\Model\Entries;
use App\Model\EntryItem;
use App\Model\Group;
use App\Model\Ledger;
use App\Model\PassengerWallet;
use App\Model\PaymentDetail;


class AccountController extends Controller
{
    public function getPayments($driverId)
    {
    	$driverWallet=DriverWallet::where('driverId',$driverId)->first();
    	$status=session()->get('status');
    	$msg=session()->get('message');
        return view('Pages.Drivers.getPayment',compact('driverWallet','status','msg'));
    }

    public function driverPayment(Request $request)
    {
    	$this->validate($request,[
    									'driverId'=>'required', 
                                        'totalEarn' => 'required',
                                        'totalPay' => 'required',
                                        'date'=>'required',
                                        'currCash'=>'required',
                                        'currentEarn'=>'required',
                                        'currCompanyProfit'=>'required',
                                        'currVat'=>'required',
                                        'creditor'=>'required',
                                        'currentpaymentLeft'=>'required',
                                        'collectAmount'=>'required',
                                   ]);

    	// if($request->currentpaymentLeft1 == $request->currentpaymentLeft)
    	// {
    		$currentpaymentLeft=$request->currentpaymentLeft-$request->collectAmount;
         
            Ledger::commit($request->driverId,$request->collectAmount,$request->paymentMethod);
    		$wallet=DriverWallet::where('driverId',$request->driverId)->first();
    		$wallet->totalPay +=$request->collectAmount;
    		$wallet->currCash =0;
    		$wallet->currentEarn=0;
    		$wallet->currCompanyProfit=0;
    		$wallet->currVat=0;
    		$wallet->creditor =0;
    		$wallet->currentpaymentLeft=$currentpaymentLeft;
    		DriverWallet::where('driverId',$request->driverId)->update($wallet->toArray());

    		$input=[  
    					'driverId'=>$request->driverId, 
    					'currCash'=>$request->currCash, 
    					'currEarn'=>$request->currentEarn, 
    					'currCompanyProfit'=>$request->currCompanyProfit,
    					'currVat'=>$request->currVat,
    					'creditor'=>$request->creditor,
    					'payAmount'=>$request->collectAmount,
    					'paidTo'=>2, 
    					'paymentMethod'=>$request->paymentMethod,
    					'currentpaymentLeft'=>$currentpaymentLeft,
    					'date'=>$request->date
    				];

    		PaymentDetail::create($input);
			session()->flash('status', 'success');
    		session()->flash('message', 'The Payment is Succesfully have been made !!!');
            return redirect()->route('Driver.getPayment',['driverId'=>$request->driverId]);


    	// }
    	// else
    	// {
    	// 	session()->flash('status', 'danger');
    	// 	session()->flash('message', 'There is a conflict in Current Payment Left');
     //        return redirect()->route('Driver.getPayment',['driverId'=>$request->driverId]);
    	// }
    }

    public function getAllReceiptRecordsofDriver($driverId)
    {
    	$details=PaymentDetail::where('driverId',$driverId)->get();
        return view('Pages.Drivers.paymentDetails',compact('details'));
    }
}
