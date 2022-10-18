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

class PencarikerjaController extends MiddleController
{
    var $title = 'Pencari Kerja';

    public function getIndex(){
        return redirect('pencari-kerja/home');
    }
    
    public function getHome(){
        $data['title']    = $this->title;
        return Sideveloper::load('dashboard', 'pencarikerja/index', $data);
    }

    public function getProfil(){
        #CONTROLLER WITH WEB SERVICE
        $http = $this->httpSelf('GET', url('api/pencari-kerja/profil'));
        $data = (array)$http->data;
        return Sideveloper::load('dashboard', 'pencarikerja/profil', $data);
    }

    public function getProfilUbah(){
        $id_profil  = DB::table('profil_pencari_kerja')->where('id_user', Auth::user()->id)->first()->id;
        $data['title']    = 'Profil - Ubah';
        $data['data']     = DB::table('vprofil_pencari_kerja')->where('id_user', Auth::user()->id)->first();
        $pendidikan = DB::table('pendidikan')->get();
        $data['pendidikan_option'] = Sideveloper::makeOption($pendidikan, 'id', 'nama');

        $kecamatan = DB::table('districts')->where('regency_id', 2101)->get();
        $data['kecamatan_option'] = Sideveloper::makeOption($kecamatan, 'id', 'name');

        $keahlian = DB::table('choice')->where('id_tipe', 2)->get();
        $data['keahlian_option'] = Sideveloper::makeOption($keahlian, 'id', 'nama');


        $bahasa = DB::table('choice')->where('id_tipe', 1)->get();
        $data['bahasa_option'] = Sideveloper::makeOption($bahasa, 'id', 'nama');

        $data['profil_keahlian'] = DB::table('profil_multiple')->where('id_profil', $id_profil)->where('id_tipe',2)->pluck('id_choice')->toArray();
        $data['profil_bahasa'] = DB::table('profil_multiple')->where('id_profil', $id_profil)->where('id_tipe',1)->pluck('id_choice')->toArray();
        return Sideveloper::load('dashboard', 'pencarikerja/profil-ubah', $data);
    }

    public function getModal(){
        $id   = $this->input('id');
        $tipe = $this->input('tipe');
        $id_user       = Auth::user()->id;
        $id_profil     = DB::table('profil_pencari_kerja')->where('id_user', $id_user)->first()->id;

        $data['title'] = DB::table('tipe_choice_big')->where('id', $tipe)->first()->nama;

        if($tipe == 1){
            $tempat = 'Nama Sekolah';
            $judul  = 'Jurusan';
        }else if($tipe == 2){
            $tempat = 'Nama Perusahaan';
            $judul  = 'Jabatan';
        }else if($tipe == 3){
            $tempat = 'Nama Penghargaan';
            $judul  = 'Sumber';
        }

        $data['tempat'] = $tempat;
        $data['judul']  = $judul;
        $data['tipe']  = $tipe;
        $pendidikan = DB::table('pendidikan')->get();
        $data['pendidikan_option'] = Sideveloper::makeOption($pendidikan, 'id', 'nama');

        if($id)
        $data['data'] = DB::table('profil_multiple_big')->where('id', $id)->where('id_profil', $id_profil)->first();
        return view('pencarikerja/modal', $data);
    }

    public function getKartuKuning(){
        $data['title']    = $this->title;
        $data['data']     = DB::table('kartu_kuning')->where('id_user', Auth::user()->id)->first();
        return Sideveloper::load('dashboard', 'pencarikerja/kartukuning', $data);
    }

    public function getLamaran(){
        $data['title']    = 'List Lamaran';
        return Sideveloper::load('dashboard', 'pencarikerja/lamaran', $data);
    }
}