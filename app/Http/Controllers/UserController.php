<?php

namespace App\Http\Controllers;
use Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session; 
use Illuminate\Http\Request;
use \Validator;
use App\Http\Controllers\MovieListController;
Use Exception;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function homeView()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(array $data)
    {
        return User::create([
            'name'=>$data['name'],
            'subscription'=>false,
            'email' => $data['email'],
            'phoneNo'=>$data['phoneNo'],
            'password' => Hash::make($data['password'])
          ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registration(Request $request)
    {
        // $validatorPassword = Validator::make($request->all(),
        //     [
        //         'password' => 'required|min:8',]
        // );
        // if ($validatorPassword->fails()) {
        //     return back()->withErrors(['message'=>'Password did not satisify the criteria']);
        // }
        // $validatorEmail = Validator::make($request->all(),
        //     [
        //         'email' => 'required|email',]
        // );
        // if ($validatorEmail->fails()) {
        //     return back()->withErrors(['message'=>'Email did not satisify the criteria']);
        // }
        // $validatorPhoneNo = Validator::make($request->all(),
        //     [
        //         'phoneNo' => 'required|min:10',]
        // );
        // if ($validatorEmail->fails()) {
        //     return back()->withErrors(['message'=>'PhoneNo did not satisify the criteria']);
        // }
        // try{
        //     $request->validate([
        //         'password' => 'required|min:8',
        //         'email' => 'required|email',
        //         'phoneNo' => 'required|min:10',

        //     ]);
        //     $data = $request->all();
        //     $check = $this->create($data);
        //     return view('login');
        // }
        // catch(Exception $e){
        //     return back()->with(['message'=>'PhoneNo&Email should be unique']);
        // }

        
            $request->validate([
                'password' => 'required|min:8|regex:/[0-9]{10}/|regex:/[a-z]/|regex:/[@$*&^%]/|regex:/[A-Z]/',
                'email' => 'required|email|unique:users',
                'phoneNo' => 'required|digits:10|unique:users',
    
            ]);
            $data = $request->all();
            $check = $this->create($data);
            return redirect()->intended(route('login'));
        
        
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phoneNo',
            'phoneNo' => 'required_without:email',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password','phoneNo');
        if ((Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) || (Auth::attempt(['phoneNo' => $credentials['phoneNo'], 'password' => $credentials['password']])) ) 
        {
            if(Auth::check())
            { 
                $user = Auth::user();
              //  $login = Session::where('user_id', Auth::id())->count();
              $login=DB::select('select count(user_id) from sessions where user_id = ?', [Auth::user()->id]);
              $login=$login[0]->{'count(user_id)'};      
              //$login = DB::table('sessions')->where('user_id', Auth::id())->count();
               // dd($login);
                    if ($login >= 2)
                    {
                        Auth::logout();    
                        session()->flash('logout', "You are Logged in on other devices");
                        return "<h1>Maximum device limited reached. Logged in from ".$login." devices .</h1>";
                        //return redirect()->intended(route('login'));
                    }
    
                
            }
            //$session = new Session();
            //$session->user_id = $user->id;
            // $session->session_id = session()->getId();
            // $session->ip_address = request()->ip();
            // $session->user_agent = request()->userAgent();
            // $session->last_activity = now();
            Session::put('user_id', Auth::id());
            Session::put('session_id', session()->getId());
            Session::put('ip_address', request()->ip());
            Session::put('user_agent', request()->userAgent());
            Session::put('last_activity', now());
            
            $data = Session::all();
            //return $data;
            return redirect()->intended(route('home'));
        }
        else{
            return view('registration');
        }
    }
    function logout(Request $request) {
        Auth::logout();
        return redirect()->intended(route('login'));
    }
    function loginView() {
        return view('login');
    }
    function registrationView() {
        return view('registration');
    }
    

    


}
