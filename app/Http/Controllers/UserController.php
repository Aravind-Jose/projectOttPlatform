<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            'name'=>"sad",
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
        $validatorPassword = Validator::make($request->all(),
            [
                'password' => 'required|min:8',]
        );
        if ($validatorPassword->fails()) {
            return back()->withErrors(['message'=>'Password did not satisify the criteria']);
        }
        $validatorEmail = Validator::make($request->all(),
            [
                'email' => 'required|email',]
        );
        if ($validatorEmail->fails()) {
            return back()->withErrors(['message'=>'Email did not satisify the criteria']);
        }
        $validatorPhoneNo = Validator::make($request->all(),
            [
                'phoneNo' => 'required|min:10',]
        );
        if ($validatorEmail->fails()) {
            return back()->withErrors(['message'=>'PhoneNo did not satisify the criteria']);
        }
        $data = $request->all();
        $check = $this->create($data);
        return view('home');
        
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return view('home');
        }
        else{
            return view('registration');
        }
    }
    function loginView() {
        return view('login');
    }
    function registrationView() {
        return view('registration');
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
