<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\SignupMail;

class MovieListController extends Controller{
    public function movieListView(Request $request){
        $query=movie::query();
        $user = Auth::user()->id;
        $users=User::where('id',$user)->get();
        if($request->ajax()){
            $query=movie::query();
            // $data=$query->where('name','like','%'.$request->search.'%')
            //     ->orWhere('year','like','%'.$request->search.'%')
            //     ->orWhere('language','like','%'.$request->search.'%');
            if($request->language!="All"){
                //return $request->language;
                $data=$query->where('name','like','%'.$request->search.'%')
                ->Where('language','like','%'.$request->language.'%');
            }
            else{
                // if($request->search->isNotEmpty()){
                    $data=$query->where('name','like','%'.$request->search.'%');
                // }
                
            }
            $data=$data->get();
            return response()->json(['movies'=>$data,'user'=>$users[0]]);
        }
        else{
            $data=$query->get();
            return view('home',['movies'=>$data,'user'=>$users[0]]);}
    }
    public function movieView($name){
        try{
            $data=movie::where('name',$name)->get();
        $user = Auth::user()->id;
        $users=User::where('id',$user)->get();
        //return $user;
        return view('movie',['movie'=>$name, 'available'=>$data[0]['subscription'],'user'=>$users[0]['subscription']]);
            }
        catch(ErrorException $e){
            return redirect()->intended(route('login'));
        }

    }
    public function subscription() {
        try{
            //$data=movie::where('name',$name)->get();
        $user = Auth::user()->id;
        $users=User::where('id',$user)->get();
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => $users[0]['email'].' has subscribed to our service'
        ];
        \Mail::to('hello@g.com')->send(new SignupMail($details));
        dd("Email is Sent.");
        //return $user;
        //return view('movie',['movie'=>$name, 'available'=>$data[0]['subscription'],'user'=>$users[0]['subscription']]);
            }
            catch(ErrorException $e){
                return redirect()->intended(route('login'));
            }
    }
    public function paymentView(){
        return view('payment');
    }
}

