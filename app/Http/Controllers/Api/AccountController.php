<?php

namespace App\Http\Controllers\Api;

use App\Model\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Model\Drivers;
use App\Model\Users;
use App\Model\PassengerDetails;

use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;


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
            if ($request->totalPrice < $request->tripTotal)
            {
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Customer is Paying Less Amount then Trip Cost.."];
                $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                return  response()->json(array('array'=>$array), 200);
            }
            try
            {
               $DriverWallet=DriverWallet::where('driverId',$request->driverId)->first();
               $user=Users::select('deviceToken','deviceType')->where('userId',$request->passengerId)->first();
               
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
                        PassengerWallet::where('userId',$request->passengerId)->update(['totalPay'=>round($PassengerWallet->totalPay,2)]);
                      }
                      else
                      {
                          $amount=$request->totalPrice-$request->tripTotal;
                          $Input['creditor']=round($amount,2);
                          $remainAmount=round($amount,2);
                          $PassengerWallet->totalPay =$PassengerWallet->totalPay+round($request->totalPrice,2);
                          $PassengerWallet->credit =$PassengerWallet->credit+round($amount,2);
                          PassengerWallet::where('userId',$request->passengerId)->update(['totalPay'=>round($PassengerWallet->totalPay,2),
                                                                                          'credit'=>round($PassengerWallet->credit,2)]);
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



                      $currentCash=round($currentCash,2);
                      $currentpaymentLeft=round($currentpaymentLeft,2);
                      $totalEarn=round($totalEarn,2);
                      $currentEarn=round($currentEarn,2);
                      $currVat=round($currVat,2);
                      $currCompanyProfit=round($currCompanyProfit,2);

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
                        $Input2['creditor']=round($Input2['creditor'],2);
                        $Input2['currentpaymentLeft']=$currentpaymentLeft+$Input['creditor'];
                        $Input2['currentpaymentLeft']=round($Input2['currentpaymentLeft'],2);
                    }
                      if (!empty($request->companyId))
                      {
                          if ($request->companyId !=0)
                          {
                              $partnerCompany=Company::where('a_id',$request->companyId)->first();
                              $muhrahProfit=($companyProfit * $partnerCompany->muhrahPercentage)/100;
                              $muhrahProfit=round($muhrahProfit,2);

                              $credit=$partnerCompany->credit+$muhrahProfit;
                              $totalProfit=$partnerCompany->totalProfit+$muhrahProfit;
                              Company::where('a_id',$request->companyId)->update(['credit'=>$credit,'totalProfit'=>$totalProfit]);
                          }
                      }
                    DriverWallet::where('driverId',$request->driverId)->update($Input2); 
                    
                    Drivers::where('userId',$request->driverId)->update(['driverStatus'=>'1']);
                    BookingComplete::where('bookingId',$request->bookingId)->update(['totalPay'=>$request->totalPrice]);

                    if ($user->deviceType == 1) 
                    {
                          $notifyResponse=Notification::notify(array($user->deviceToken), 'Payment Confirms' , "your payent is been confirmed", '1', 'PaymentConfirms');
                          $notifyResult=json_decode($notifyResponse);
                           if ($notifyResult->success==1) 
                           {
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                return  response()->json(array('array'=>$array), 200);
                           }
                           elseif ($notifyResult->success==0) 
                           {
                              $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Notification is not send to passenger"];
                              $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                              return  response()->json(array('array'=>$array), 200);
                           }
                    }
                    else
                    {
                        $result=Notification::notifyiOS($user->deviceToken,'your payent is been confirmed','','PaymentConfirms');
                        if ($result==1) 
                        {
                            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$result);
                            return  response()->json(array('array'=>$array), 200);
                        }
                        else
                        {
                            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Notification is not send to passenger"];
                            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                            return  response()->json(array('array'=>$array), 200);
                        }
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
