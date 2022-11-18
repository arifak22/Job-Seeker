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

class ServicesController extends MiddleController
{
    public function getVersion(){
        $version  = $this->input('version');
        $platform = $this->input('platform');

        $usedVersion = DB::table('mobile_setup')
            ->where('version', $version)
            ->where('platform', $platform)
            ->first();
        
        $latestVersion = DB::table('mobile_setup')
            ->where('platform', $platform)
            ->where('date_publish', '<', date('Y-m-d H:i:s'))
            ->orderBy('date_publish', 'desc')
            ->first();

        $isUpdate = $usedVersion->number_version  < $latestVersion->number_version;
        
        $res['api_status']     = 1;
        $res['api_message']    = 'success';

        $res['version']        = $latestVersion->version;
        $res['update']         = $isUpdate;
        $res['update_message'] = json_decode($latestVersion->keterangan);

        $res['app_version'] = $usedVersion->version;
        $res['experied']    = $usedVersion->experied;

        #SUKSES
        return $this->api_output($res);
    }
}