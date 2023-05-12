<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieListController extends Controller{
    public function movieListView(){
        $data=movie::all();
        return view('home',['movies'=>$data]);
    }
    public function movieView($name){
        $data=movie::where('name',$name)->get();
        //return $data[0];
        return view('movie',['movie'=>$name, 'available'=>$data[0]['subscription']]);
    }
}

