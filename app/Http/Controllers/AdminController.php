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

class AdminController extends MiddleController
{
    var $title = 'Admin';

    public function getIndex(){
        return redirect('admin/home');
    }
    public function getHome(){
        $data['title']    = $this->title;
        return Sideveloper::load('dashboard', 'pencarikerja/index', $data);
    }

    public function getKartuKuningVerifikasi(){
        $data['title']    = $this->title;
        return Sideveloper::load('dashboard', 'admin/kartukuning', $data);
    }

    public function getKartuKuningDetail(){
        $data['title']         = $this->title;
        $id              = $this->input('id');
        $verified_status = $this->input('verified_status');

        $data['data']    = DB::table('kartu_kuning')
            ->select('kartu_kuning.*', 'users.nama')
            ->where('kartu_kuning.id', $id)
            ->where('verified_status', $verified_status)
            ->join('users','users.id','=','kartu_kuning.id_user')->first();
            
        if(empty($data['data']))
            return redirect('admin/kartu-kuning-verifikasi');

        return Sideveloper::load('dashboard', 'admin/kartukuningdetail', $data);
    }
    
}