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

class PerusahaanController extends MiddleController
{
    var $title = 'Perusahaan';

    public function getIndex(){
        return redirect('perusahaan/home');
    }
    public function getHome(){
        $data['title']    = $this->title;
        return Sideveloper::load('dashboard', 'perusahaan/index', $data);
    }
    public function getProfil(){
        $data['title']  = 'Profil';
        $data['data']   =  DB::table('vprofil_perusahaan')
            ->where('id_user', Auth::user()->id)->first();
        return Sideveloper::load('dashboard', 'perusahaan/profil', $data);
    }
    public function getProfilUbah(){
        $data['title']  = 'Profil';
        $data['data']   = DB::table('profil_perusahaan')->join('users','users.id','=','profil_perusahaan.id_user')->where('users.id', Auth::user()->id)->first();

        $kecamatan = DB::table('districts')->where('regency_id', 2101)->get();
        $data['kecamatan_option'] = Sideveloper::makeOption($kecamatan, 'id', 'name');

        $keahlian = DB::table('choice')->where('id_tipe', 2)->get();
        $data['keahlian_option'] = Sideveloper::makeOption($keahlian, 'id', 'nama');

        $bidang = DB::table('bidang')->get();
        $data['bidang_option'] = Sideveloper::makeOption($bidang, 'id', 'nama_bidang');

        $tahun = range(1970, date('Y'));
        $res = [];
        foreach($tahun as $key => $t){
            $res[$key]['value'] = $t;
            $res[$key]['name'] = $t;
        }
        $data['tahun_option'] = $res;
        return Sideveloper::load('dashboard', 'perusahaan/profil-ubah', $data);
    }

    public function getLokerPosting(){
        $data['title']  = 'Posting Loker';
        $jenis = DB::table('jenis_pekerjaan')->get();
        $data['jenis_option'] = Sideveloper::makeOption($jenis, 'id', 'nama');

        $kecamatan = DB::table('districts')->where('regency_id', 2101)->get();
        $data['kecamatan_option'] = Sideveloper::makeOption($kecamatan, 'id', 'name');

        $pendidikan = DB::table('pendidikan')->get();
        $data['pendidikan_option'] = Sideveloper::makeOption($pendidikan, 'id', 'nama');

        $keahlian = DB::table('choice')->where('id_tipe', 2)->get();
        $data['keahlian_option'] = Sideveloper::makeOption($keahlian, 'id', 'nama');

        $bahasa = DB::table('choice')->where('id_tipe', 1)->get();
        $data['bahasa_option'] = Sideveloper::makeOption($bahasa, 'id', 'nama');
        
        $id = $this->input('id');

        $data['profil_keahlian'] = DB::table('loker_multiple')->where('id_loker', $id)->where('id_tipe',2)->pluck('id_choice')->toArray();
        $data['profil_bahasa']   = DB::table('loker_multiple')->where('id_loker', $id)->where('id_tipe',1)->pluck('id_choice')->toArray();

        $data['data']            = DB::table('loker')->where('id', $id)->first();
        $data['deskripsi']       = DB::table('loker_deskripsi')->where('id_loker',$id)->get();
        $data['deskripsi_detil'] = DB::table('loker_deskripsi_detil')->where('id_loker',$id)->get();

        if($id)
            $data['i'] = count($data['deskripsi']);
        else
            $data['i'] = 1;
        return Sideveloper::load('dashboard', 'perusahaan/loker-posting', $data);
    }

    public function getLokerKelola(){
        $data['title']  = 'Kelola Loker';
        return Sideveloper::load('dashboard', 'perusahaan/lokerkelola', $data);
    }

    public function getLokerApplicant(){
        $id = $this->input('id');
        $data['title']  = 'Loker Applicant';
        $data['judul']            = DB::table('loker')->where('id', $id)->first()->judul;
        $data['data']   =   DB::table('loker_pelamar')
            ->join('vprofil_pencari_kerja', 'vprofil_pencari_kerja.id_user', '=', 'loker_pelamar.id_pelamar')
            ->where('id_loker', $id)->get();
        return Sideveloper::load('dashboard', 'perusahaan/lokerapplicant', $data);
    }
}