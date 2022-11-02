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
        $data['title']         = $this->title;
        $data['loker']         = DB::table('loker')->where('status_loker', 'POST')->count();
        $data['lamaran']       = DB::table('loker_pelamar')->count();
        $data['perusahaan']    = DB::table('users')->where('id_privilege', 2)->count();
        $data['pencari_kerja'] = DB::table('users')->where('id_privilege', 1)->count();
        return Sideveloper::load('dashboard', 'admin/index', $data);
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

    public function getMasterBidang(){
        $data['title'] = 'Master Bidang Usaha';
        return Sideveloper::load('dashboard', 'admin/master/bidang', $data);
    }

    public function getMasterBahasa(){
        $data['title'] = 'Master Bahasa';
        $data['name']  = 'Bahasa';
        $data['tipe']  = 1;
        return Sideveloper::load('dashboard', 'admin/master/choice', $data);
    }

    public function getMasterKeahlian(){
        $data['title'] = 'Master Keahlian';
        $data['name']  = 'Keahlian';
        $data['tipe']  = 2;
        return Sideveloper::load('dashboard', 'admin/master/choice', $data);
    }

    public function getMasterDomisili(){
        $data['title'] = 'Master Kecamatan';
        return Sideveloper::load('dashboard', 'admin/master/domisili', $data);
    }

    public function getMasterKelurahan(){
        $id              = $this->input('id');
        $data['kecamatan'] = DB::table('districts')->where('regency_id', 2101)->where('id', $id)->first();
        $data['title'] = 'Master Kelurahan';
        return Sideveloper::load('dashboard', 'admin/master/kelurahan', $data);
    }

    public function getMasterAdmin(){
        $data['title'] = 'Master Admin';
        $data['privilege_option'] = $this->getOption('privilege');
        return Sideveloper::load('dashboard', 'admin/master/admin', $data);
    }
    
}