<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class MasterController extends Controller
{
    // Register a new user
    public function apiRuningCheck()
    {
    	$laravel = 0;
    	$express = 1;
    	if ($laravel == 1) {
    		$msg = 'Laravel running successful';
    	} else {
    		$msg = 'Express running successful';
    	}
    	return response()->json([
            'success' => true,
            'is_laravel' => $laravel,
            'is_express' => $express,
            'baseurl' => 'http://127.0.0.1:8000/api/',
            'message' => $msg,
        ]);


    }
}