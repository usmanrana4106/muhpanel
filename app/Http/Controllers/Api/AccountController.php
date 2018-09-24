<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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



class AccountController extends Controller
{
    public function confirmPayment(Request $request)
    {
        //Driver UserId will be come
      // TotalPrice is the amount Customer Pay
      //tripTotal is the Trip Cost
      //vat is Vat of the Trip 
        $validation=Validator::make($request->all(), [
                                                            'driverId' => 'required',
                                                            'bookingId'=>'required',
                                                            'passengerId'=>'required',
                                                            'paymentMethod'=>'required',
                                                            'totalPrice'=>'required',
                                                            'tripTotal'=>'required',
                                                            'vat'=>'required',
                                                            'driverFullName'=>'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
            try
            {
               $DriverWallet=DriverWallet::where('driverId',$request->driverId)->first();
               $user=Users::select('deviceToken')->where('userId',$request->passengerId)->first();
               
               if (!empty($DriverWallet)) 
               {
                  $Account=Accounts::where('bookingId',$request->bookingId)->first();
                  if (empty($Account)) 
                  {
                    

                      //Connect it with DataBase 
                      $driverPercentage=85;
                      $totalPrice=round($request->tripTotal,2);
                      $vat=round($request->vat,2);
                      $totalPrice=$totalPrice-$vat;
                      $driverProfit=($totalPrice*$driverPercentage)/100;
                      $driverProfit=round($driverProfit,2);
                      $companyProfit=round($totalPrice-$driverProfit,2);
                    
                      $Input=[
                               'bookingId'=> $request->bookingId, 
                               'userId'=> $request->passengerId, 
                               'driverId'=> $request->driverId,
                               'totalAmount'=> $request->totalPrice, 
                               'companyProfit'=> $companyProfit, 
                               'driverPercentage'=> $driverPercentage,
                               'driverProfit'=> $driverProfit,
                               'vatTax'=> $vat,
                               'paymentStatus'=>'unpaid',
                               'paymentMethod'=>'cash',
                          ];
                      $remainAmount=0;
                      $PassengerWallet=PassengerWallet::where('userId',$request->passengerId)->first();
                      if($request->tripTotal == $request->totalPrice)
                      {
                        $Input['creditor']=0;
                        $PassengerWallet->totalPay +=round($request->totalPrice,2);
                        PassengerWallet::where('userId',$request->passengerId)->update(['totalPay'=>$PassengerWallet->totalPay]);
                      }
                      else
                      {
                          $amount=$request->totalPrice-$request->tripTotal;
                          $Input['creditor']=round($amount,2);
                          $remainAmount=round($amount,2);
                          $PassengerWallet->totalPay +=round($request->totalPrice,2);
                          $PassengerWallet->credit +=round($amount,2);
                          PassengerWallet::where('userId',$request->passengerId)->update(['totalPay'=>$PassengerWallet->totalPay,
                                                                                          'credit'=>$PassengerWallet->credit]);
                      }
                      $passenger=PassengerDetails::where('userId',$request->passengerId)->first();
                      
                    //Accounting Start 
                    $data=[
                              'bookingId'=>$request->bookingId,
                              'passengerId'=>$request->passengerId,
                              'fullName'=>$passenger->fullName,
                              'driverId'=>$request->driverId,
                              'driverfullName'=>$request->driverFullName
                          ];
                    
                    Ledger::saleentries($request->totalPrice,$request->tripTotal,$remainAmount,$vat,$data); 
                    Ledger::motentries($data);
                    if($request->paymentMethod=='cash')
                    {
                      Ledger::passengerdriverentries($request->totalPrice,$data);
                    }
                    Ledger::commissionentries($data['driverId'],$request->tripTotal,$vat,$data);
                    //Accounting Ends

                    $totalEarn = $DriverWallet->totalEarn + $driverProfit;
                    $currentCash = $DriverWallet->currCash+$request->totalPrice;
                    $currentEarn = $DriverWallet->currentEarn+$driverProfit;
                    $currVat = $DriverWallet->currVat + $vat;
                    $currCompanyProfit=$DriverWallet->currCompanyProfit + $companyProfit;
                    $currentpaymentLeft=$DriverWallet->currentpaymentLeft+$companyProfit+$vat;
                    $Account=Accounts::create($Input);
                    $Input2=[
                                  'totalEarn'=> $totalEarn,
                                  'currCash'=> $currentCash,
                                  'currentEarn'=> $currentEarn,
                                  'currCompanyProfit'=> $currCompanyProfit, 
                                  'currVat'=> $currVat,
                                  'currentpaymentLeft'=>$currentpaymentLeft
                              ];
                    if ($Input['creditor']!=0) 
                    {
                        $Input2['creditor']=$DriverWallet->creditor+$Input['creditor'];
                        $Input2['currentpaymentLeft']=$currentpaymentLeft+$Input['creditor'];
                    }
                    DriverWallet::where('driverId',$request->driverId)->update($Input2); 
                    
                    Drivers::where('userId',$request->driverId)->update(['driverStatus'=>'1']);
                    $notifyResponse=Notification::notify(array($user->deviceToken), 'Payment Confirms' , "your payent is been done", '1', 'PaymentConfirms');
                    $notifyResult=json_decode($notifyResponse);
                       if ($notifyResult->success==1) 
                       {
                            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                            return  response()->json(array('array'=>$array), 200);
                       }
                       elseif ($notifyResult->success==0) 
                       {
                            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                           $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                           return  response()->json(array('array'=>$array), 200);
                       }
                    $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                    return  response()->json(array('array'=>$array), 200);
                  }
                  else
                  {
                     $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Account is Already Created"];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                    return  response()->json(array('array'=>$array), 200);
                  }
               }
               else
               {
                   $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Driver Wallet is Not Existed"];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                    return  response()->json(array('array'=>$array), 200);
               } 
               
            }
            catch(QueryException $ex)
            {
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
                $data= array('ErrorDetail'=>$ErrorDetail);
                $array=array('Data' => $data,'Result'=>0);
                return  response()->json(array('SignUpResult'=>$array), 200); 
            }
        }
    }




    public function paymentThroughWallet()
    {
        //Driver UserId will be come.
        //TotalPrice is the amount Customer Pay.
        //tripTotal is the Trip Cost.
        //vat is Vat of the Trip.
        $validation=Validator::make($request->all(), [
                                                            'driverId' => 'required',
                                                            'bookingId'=>'required',
                                                            'passengerId'=>'required',
                                                            'paymentMethod'=>'required',
                                                            'tripTotal'=>'required',
                                                            'vat'=>'required',
                                                            'driverFullName'=>'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
           try
           {
              $DriverWallet=DriverWallet::where('driverId',$request->driverId)->first();
               $user=Users::select('deviceToken')->where('userId',$request->passengerId)->first();
               
               if (!empty($DriverWallet)) 
               {
                  $Account=Accounts::where('bookingId',$request->bookingId)->first();
                  if (empty($Account)) 
                  {
                      $tripTotal=round($request->totalPrice,2);

                      $driverPercentage=85;
                      $totalPrice=round($request->tripTotal,2);
                      $vat=round($request->vat,2);
                      $totalPrice=$totalPrice-$vat;
                      $driverProfit=($totalPrice*$driverPercentage)/100;
                      $driverProfit=round($driverProfit,2);
                      $companyProfit=round($totalPrice-$driverProfit,2);
                    
                      $Input=[
                               'bookingId'=> $request->bookingId, 
                               'userId'=> $request->passengerId, 
                               'driverId'=> $request->driverId,
                               'totalAmount'=> $request->totalPrice, 
                               'companyProfit'=> $companyProfit, 
                               'driverPercentage'=> $driverPercentage,
                               'driverProfit'=> $driverProfit,
                               'vatTax'=> $vat,
                               'paymentStatus'=>'unpaid',
                               'paymentMethod'=>'cash',
                            ];
                      $remainAmount=0;
                      $PassengerWallet=PassengerWallet::where('userId',$request->passengerId)->first();
                      if($PassengerWallet->credit >= $tripTotal)
                      {
                        $Input['creditor']=0;
                        $credit=$PassengerWallet->credit-$tripTotal;
                        $totalPay +=$tripTotal;
                        $updateWallet=[
                                        'totalPay'=>$totalPay,
                                        'credit'=>$credit
                                      ];
                        PassengerWallet::where('userId',$request->passengerId)->update($updateWallet);
                      }
                      
                  }
                  else
                  {
                     $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Account is Already Created"];
                     $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                     return  response()->json(array('array'=>$array), 200);
                  }
                }
           }
            catch(QueryException $ex)
            {
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
                $data= array('ErrorDetail'=>$ErrorDetail);
                $array=array('Data' => $data,'Result'=>0);
                return  response()->json(array('SignUpResult'=>$array), 200); 
            }
        }
    } 


}
