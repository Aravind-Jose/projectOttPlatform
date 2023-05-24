<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Mail\SignupMail;
class PaymentController extends Controller
{
    private $email,$phoneNo,$amount,$currency;
    public function paymentView(){
        $user = Auth::user()->id;
        $users=User::where('id',$user)->get();
        $email=$users[0]['email'];
        $phoneNo=$users[0]['phoneNo'];
        $amount=12;
        $currency='INR';
        $payment_token='';
        return view('payment',['email'=>$email,'phoneNo'=>$phoneNo,'amount'=>$amount,'currency'=>$currency,'payment_token'=>$payment_token]);
    }
    public function tokenGeneration(){
        $user = Auth::user()->id;
        $users=User::where('id',$user)->get();
        $email=$users[0]['email'];
        $phoneNo=$users[0]['phoneNo'];
        $amount=12;
        $currency='INR';
        // $e="{\"amount\":\"$amount\",\"currency\":\"$currency\",\"email_id\":\"$email\",\"contact_number\":\"$phoneNo\"}";
        // return $e;
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_CAINFO, dirname("C:\Program Files\php-8.2.5-nts-Win32-vs16-x64\cacert.pem")."/cacert.pem");
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://sandbox-icp-api.bankopen.co/api/payment_token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"amount\":\"$amount\",\"currency\":\"$currency\",\"email_id\":\"$email\",\"contact_number\":\"$phoneNo\"}",
        CURLOPT_HTTPHEADER => [
        "Authorization: Bearer ".env('API_ACCESS_TOKEN'),
        "accept: application/json",
        "content-type: application/json"
        ],
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $err = curl_error($curl);
        $payment_token=$response['id'];
        curl_close($curl);
        if ($err) {
        return $err;
        } else {
            //return $response['id'];
            // return redirect()->intended(route('paymentGateway',['payment_token'=>$response->id]));
       return view('payment',['email'=>$email,'phoneNo'=>$phoneNo,'amount'=>$amount,'currency'=>$currency,'payment_token'=>$payment_token]);
        }
    }
    public function sendMail() {
        try{
            //$data=movie::where('name',$name)->get();
        $currentDate = Carbon::now();
        $user = Auth::user()->id;
        $user=User::find($user);
        $user->subscriptionDate=$currentDate;
        $user->subscription=true;
        $user->save();
        $details = [
            'title' => 'Mail from ottplatform.com',
            'body' => 'congratulations '.$user->email.' you have successfully subscribed to our website.'
        ];
        
        \Mail::to($user->email)->send(new SignupMail($details));
        return redirect()->intended(route('home'));
        
        //dd("Email is Sent.");
        //return $user;
        //return view('movie',['movie'=>$name, 'available'=>$data[0]['subscription'],'user'=>$users[0]['subscription']]);
            }
            catch(Error $e){
                return redirect()->intended(route('login'));
            }
    }
    //  public function paymentGateway($id){
    //     return view('paymentGateway',['payment_token'=>$id]);
    //  }   
}
