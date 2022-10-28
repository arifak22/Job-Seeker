<?php  

namespace App\Http\Controllers\Api;
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
use Str;
use Schema;
use Validator;
use Auth;
use JWTAuth;
use Pel;
use URL;
use Mail;
use Carbon;
use Sideveloper;
use App\Http\Controllers\MiddleController;
use Tymon\JWTAuth\JWTAuth as JWTAuthJWTAuth;

class OptionController extends MiddleController
{
    public function getIndex(){
        $search = $this->input('search');
        $id     = $this->input('id');
        $all    = $this->input('all');
        
        $option = $this->getOption($search, $all, $id, JWTAuth::user());
        if(count($option) > 0){
            $this->res['api_status']  = 1;
            $this->res['api_message'] = 'success';
            $this->res['auth']        = JWTAuth::user();
            $this->res['data']        = $option;
        }else{
            $this->res['api_message'] = 'Data Kosong';
        }
        
        #SUKSES
        return $this->api_output($this->res);
    }
}