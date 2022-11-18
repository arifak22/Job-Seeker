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

class MenuController extends MiddleController
{
    var $title = 'Menu';
    public function getIndex(){
        redirect('home');
    }

    public function getLoker(){
        $data['title']    = $this->title;
        $data['kecamatan_option'] = $this->getOption('kecamatan', true);
        $data['keahlian_option']  = $this->getOption('keahlian', true);
        $data['bahasa_option']    = $this->getOption('bahasa', true);

        $data['jenis_pekerjaan'] = DB::table('jenis_pekerjaan')->get();

        #START QUERY LOKER
        $query  = DB::table('vloker')->where('status_loker','POST')->where('tanggal_kadaluarsa', '>=', date('Y-m-d'));
        $search = $this->input('search');
        if($search){
            $query->where(function($q) use ($search) {
                $q->where(DB::raw('lower(nama_perusahaan)'), 'like', "%$search%")
                  ->orWhere(DB::raw('lower(judul)'), 'like', "%$search%");
            });
        }

        $id_kecamatan = $this->input('id_kecamatan');
        if($id_kecamatan)
        $query->where('id_kecamatan', $id_kecamatan);

        $id_kelurahaan = $this->input('id_kelurahaan');
        if($id_kelurahaan)
        $query->where('id_kelurahaan', $id_kelurahaan);

        $id_keahlian = $this->input('id_keahlian');
        if($id_keahlian){
            $query->whereIn('id', function($q) use($id_keahlian)
            {
                $q->select('id_loker')
                    ->from('loker_multiple')
                    ->where('id_choice', $id_keahlian);
            });
        }

        $id_bahasa = $this->input('id_bahasa');
        if($id_bahasa){
            $query->whereIn('id', function($q) use($id_bahasa)
            {
                $q->select('id_loker')
                    ->from('loker_multiple')
                    ->where('id_choice', $id_bahasa);
            });
        }

        $jenis_pekerjaan = $this->input('jenis_pekerjaan');
        if($jenis_pekerjaan)
        $query->whereIn('id_jenis_pekerjaan', $jenis_pekerjaan);

        $data['data'] =  $query->paginate(10);
        #END QUERY LOKER

        $data['parameter'] = $_GET;
        return Sideveloper::load('template', 'menu/loker', $data);
    }

    public function getLokerDetil(){
        $id = $this->input('id');
        $data['title']     = $this->title;
        $data['data']      = DB::table('vloker')->where('id', $id)->first();
        $data['deskripsi'] = DB::table('loker_deskripsi')->where('id_loker', $id)->get();
        $data['pelamar']   = DB::table('loker_pelamar')->where('id_loker', $id)->pluck('id_pelamar')->toArray();

        $data['keahlian'] = DB::table('vchoice_loker')->where('id_tipe',2)->where('id_loker', $id)->get();
        $data['bahasa']   = DB::table('vchoice_loker')->where('id_tipe',1)->where('id_loker', $id)->get();

        $data['profile'] = DB::table('vprofil_perusahaan')
            ->where('id_user', $data['data']->id_user)->first();
        return Sideveloper::load('template', 'menu/lokerdetil', $data);
    }

    public function getPerusahaan(){
        $data['title']    = $this->title;
        
        $data['kecamatan_option'] = $this->getOption('kecamatan', true);

        $data['bidang'] = DB::table('bidang')->get();

        #START QUERY LOKER
        $query  = DB::table('vprofil_perusahaan');
        $search = $this->input('search');
        if($search)
            $query->where(DB::raw('lower(nama)'), 'like', "%$search%");

        $id_kecamatan = $this->input('id_kecamatan');
        if($id_kecamatan)
        $query->where('id_kecamatan', $id_kecamatan);

        $id_kelurahaan = $this->input('id_kelurahaan');
        if($id_kelurahaan)
        $query->where('id_kelurahaan', $id_kelurahaan);

        $id_bidang = $this->input('id_bidang');
        if($id_bidang)
        $query->whereIn('id_bidang', $id_bidang);

        $data['data'] =  $query->paginate(10);
        #END QUERY LOKER

        $data['parameter'] = $_GET;
        return Sideveloper::load('template', 'menu/perusahaan', $data);
    }

    public function getPerusahaanDetil(){
        $id = $this->input('id');
        $data['title']    = $this->title;
        $data['data']   =  DB::table('vprofil_perusahaan')->where('id', $id)->first();
        $data['job']    = DB::table('vloker')->where('id_user', $data['data']->id_user)
            ->where('status_loker', 'POST')
            ->where('tanggal_kadaluarsa', '>=', date('Y-m-d'))->get();
        return Sideveloper::load('template', 'menu/perusahaandetil', $data);
    }

    public function getPencariKerja(){ 
        $data['title']    = $this->title;

        $data['kecamatan_option'] = $this->getOption('kecamatan', true);
        $data['keahlian_option']  = $this->getOption('keahlian', true);
        $data['bahasa_option']    = $this->getOption('bahasa', true);

        $data['pendidikan'] = DB::table('pendidikan')->get();

        #START QUERY LOKER
        $query  = DB::table('vprofil_pencari_kerja');
        $search = $this->input('search');
        if($search){
            $query->where(DB::raw('lower(nama)'), 'like', "%$search%");
        }

        $id_kecamatan = $this->input('id_kecamatan');
        if($id_kecamatan)
        $query->where('id_kecamatan', $id_kecamatan);

        $id_kelurahaan = $this->input('id_kelurahaan');
        if($id_kelurahaan)
        $query->where('id_kelurahaan', $id_kelurahaan);

        $id_keahlian = $this->input('id_keahlian');
        if($id_keahlian){
            $query->whereIn('id_profil', function($q) use($id_keahlian)
            {
                $q->select('id_profil')
                    ->from('profil_multiple')
                    ->where('id_choice', $id_keahlian);
            });
        }

        $id_bahasa = $this->input('id_bahasa');
        if($id_bahasa){
            $query->whereIn('id_profil', function($q) use($id_bahasa)
            {
                $q->select('id_profil')
                    ->from('profil_multiple')
                    ->where('id_choice', $id_bahasa);
            });
        }

        $pendidikan = $this->input('pendidikan');
        if($pendidikan)
        $query->whereIn('id_pendidikan', $pendidikan);

        $data['data'] =  $query->paginate(10);
        #END QUERY LOKER

        $data['parameter'] = $_GET;
        return Sideveloper::load('template', 'menu/pencarikerja', $data);
    }
    public function getPencarikerjaDetil(){
        $id = $this->input('id');
        $data['title']    = $this->title;
        
        $data['data']   = DB::table('vprofil_pencari_kerja')->where('id_profil',$id)->first();

        $data['bahasa'] = DB::table('vchoice_pencari_kerja')->where('id_tipe','1')->where('id_profil',$id)->pluck('nama_choice')->implode(', ');
        $data['skill']  = DB::table('vchoice_pencari_kerja')->where('id_tipe','2')->where('id_profil',$id)->get();

        $data['pendidikan']  = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',1)->where('id_profil',$id)->get();
        $data['pengalaman']  = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',2)->where('id_profil',$id)->get();
        $data['sertifikasi'] = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',3)->where('id_profil',$id)->get();
        return Sideveloper::load('template', 'menu/pencarikerjadetil', $data);
    }
    public function getBlog(){
        $data['title']    = $this->title;
        return Sideveloper::load('template', 'blank', $data);
    }
    public function getFaq(){
        $data['title']    = $this->title;
        return Sideveloper::load('template', 'blank', $data);
    }

    public function getDashboard(){
        $id_privilege = Auth::user()->id_privilege;
        if($id_privilege == 1){
            return redirect('pencari-kerja/home');
        }else if($id_privilege == 2){
            return redirect('perusahaan/home');
        }else if($id_privilege == 3){
            return redirect('admin/home');
        }

        return redirect('home');
    }
}