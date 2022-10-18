<?php  

namespace App\Http\Controllers;

use App;
use Cache;
use Config;
use Crypt;
use DB;
use File;
use Excel;
use Hash;
use Log;
use PDF;
use Request;
use Route;
use Session;
use Storage;
use Schema;
use Validator;
use Auth;
use Pel;
use URL;
use Mail;
use Carbon;
use Sideveloper;
use JWTAuth;

class AuthController extends MiddleController
{
    var $title = 'Auth';

    public function getLogout(){
        Auth::logout();
        return redirect()->intended('home');
    }

    public function getIndex(){
        return redirect()->intended('home');
    }

    public function getLogin(){
        return view('home/login');
    }

    public function getRegister(){
        return view('home/register');
    }

    public function getRegisterStatus(){
        $data['title']    = $this->title;
        return Sideveloper::load('template', 'home/register-status', $data);
    }

    public function postLogin(){
        $credentials = Request::only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->status < 1){
                Auth::logout();
                $res['api_status']  = 0;
                $res['api_message'] = 'User anda sudah dinonaktifkan';
                return response()->json($res);
            }
            // Authentication passed...
            $res['api_status']  = 1;
            $res['api_message'] = 'Berhasil Login';
            // $token = JWTAuth::attempt($credentials);
            $token = JWTAuth::customClaims(['device' => 'web'])->fromUser(Auth::user());
            Request::session()->put('menus', Sideveloper::getMenu(Auth::user()->id_privilege));
            Request::session()->put('access', Sideveloper::getAccess(Auth::user()->id_privilege));
            Request::session()->put('token', $token);

            $res['jwt_token']   = $token;
        }else{
            $res['api_status']  = 0;
            $res['api_message'] = 'Username & Password tidak sesuai. Coba Lagi.';
            $res['jwt_token']   = null;
        }
        return response()->json($res);
    }
}