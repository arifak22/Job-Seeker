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

class MenuController extends MiddleController
{
    public function getLoker(){
        $search          = $this->input('search');
        $id_kecamatan    = $this->input('id_kecamatan');
        $id_kelurahaan   = $this->input('id_kelurahaan');
        $id_keahlian     = $this->input('id_keahlian');
        $id_bahasa       = $this->input('id_bahasa');
        $jenis_pekerjaan = $this->input('jenis_pekerjaan');
        $tipe            = $this->input('tipe');
        $source          = $this->input('source');

        #START QUERY LOKER
        $query  = DB::table('vloker')
        ->where('status_loker','POST')->where('tanggal_kadaluarsa', '>=', date('Y-m-d'));

        #TAMPIL TOTAL LOKER
        if($tipe == 'home'){
            #OUTPUT DATA
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            $res['data']        = $query->count();
            return $this->api_output($res);
        }
        
        if($search){
            $query->where(function($q) use ($search) {
                $q->where(DB::raw('lower(nama_perusahaan)'), 'like', "%$search%")
                  ->orWhere(DB::raw('lower(judul)'), 'like', "%$search%");
            });
        }

        if($id_kecamatan)
        $query->where('id_kecamatan', $id_kecamatan);

        if($id_kelurahaan)
        $query->where('id_kelurahaan', $id_kelurahaan);

        if($id_keahlian){
            $query->whereIn('id', function($q) use($id_keahlian)
            {
                $q->select('id_loker')
                    ->from('loker_multiple')
                    ->where('id_choice', $id_keahlian);
            });
        }

        if($id_bahasa){
            $query->whereIn('id', function($q) use($id_bahasa)
            {
                $q->select('id_loker')
                    ->from('loker_multiple')
                    ->where('id_choice', $id_bahasa);
            });
        }

        if($jenis_pekerjaan)
        $query->whereIn('id_jenis_pekerjaan', $jenis_pekerjaan);

        #TAMPIL TOTAL LOKER
        if($source == 'mobile'){
            #OUTPUT DATA
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            $res['data']        = $query->get();
            return $this->api_output($res);
        }

        #OUTPUT DATA
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $query->paginate(10);
        return $this->api_output($res);

    }

    public function getLokerDetil(){
        $id = $this->input('id', 'required');
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        $res['data']      = DB::table('vloker')->where('id', $id)->first();
        $resDeskripsi = DB::table('loker_deskripsi')->where('id_loker', $id)->get();
        $deskripsi = [];
        foreach($resDeskripsi as $key => $rd){
            $deskripsi[$key]['judul_deskripsi'] = $rd->judul_deskripsi;
            $deskripsi[$key]['detil'] = DB::table('loker_deskripsi_detil')->where('id_loker_deskripsi', $rd->id)->get();
        }
        $res['deskripsi'] = $deskripsi;

        $res['pelamar']   = DB::table('loker_pelamar')->where('id_loker', $id)->pluck('id_pelamar')->toArray();

        $res['keahlian'] = DB::table('vchoice_loker')->where('id_tipe',2)->where('id_loker', $id)->get();
        $res['bahasa']   = DB::table('vchoice_loker')->where('id_tipe',1)->where('id_loker', $id)->get();

        $res['profile'] = DB::table('vprofil_perusahaan')
            ->where('id_user', $res['data']->id_user)->first();

        #OUTPUT DATA
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        return $this->api_output($res);
    }

    public function getPerusahaan(){
        $source        = $this->input('source');
        $tipe          = $this->input('tipe');
        $id_kecamatan  = $this->input('id_kecamatan');
        $id_kelurahaan = $this->input('id_kelurahaan');
        $id_bidang     = $this->input('id_bidang');
        $search        = $this->input('search');

        #START QUERY LOKER
        $query  = DB::table('vprofil_perusahaan');
        if($search)
            $query->where(DB::raw('lower(nama)'), 'like', "%$search%");

        #TAMPIL TOTAL
        if($tipe == 'home'){
            #OUTPUT DATA
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            $res['data']        = $query->count();
            return $this->api_output($res);
        }
        

        if($id_kecamatan)
        $query->where('id_kecamatan', $id_kecamatan);

        if($id_kelurahaan)
        $query->where('id_kelurahaan', $id_kelurahaan);

        if($id_bidang)
        $query->whereIn('id_bidang', $id_bidang);

        #TAMPIL TOTAL LOKER
        if($source == 'mobile'){
            #OUTPUT DATA
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            $res['data']        = $query->get();
            return $this->api_output($res);
        }

        #OUTPUT DATA
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $query->paginate(10);
        return $this->api_output($res);
    }

    public function getPerusahaanDetil(){
        $id = $this->input('id', 'required');
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        $res['data']   =  DB::table('vprofil_perusahaan')->where('id', $id)->first();
        $res['job']    = DB::table('vloker')->where('id_user', $res['data']->id_user)
            ->where('status_loker', 'POST')
            ->where('tanggal_kadaluarsa', '>=', date('Y-m-d'))->get();
            
        #OUTPUT DATA
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        return $this->api_output($res);
    }

    public function getPencariKerja(){ 
        $id_kecamatan  = $this->input('id_kecamatan');
        $id_kelurahaan = $this->input('id_kelurahaan');
        $id_keahlian   = $this->input('id_keahlian');
        $id_bahasa     = $this->input('id_bahasa');
        $pendidikan    = $this->input('pendidikan');
        $tipe          = $this->input('tipe');
        $source        = $this->input('source');

        #START QUERY LOKER
        $query  = DB::table('vprofil_pencari_kerja');
        $search = $this->input('search');
        if($search){
            $query->where(DB::raw('lower(nama)'), 'like', "%$search%");
        }
        #TAMPIL TOTAL LOKER
        if($tipe == 'home'){
            #OUTPUT DATA
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            $res['data']        = $query->count();
            return $this->api_output($res);
        }

        if($id_kecamatan)
        $query->where('id_kecamatan', $id_kecamatan);

        if($id_kelurahaan)
        $query->where('id_kelurahaan', $id_kelurahaan);

        if($id_keahlian){
            $query->whereIn('id_profil', function($q) use($id_keahlian)
            {
                $q->select('id_profil')
                    ->from('profil_multiple')
                    ->where('id_choice', $id_keahlian);
            });
        }

        if($id_bahasa){
            $query->whereIn('id_profil', function($q) use($id_bahasa)
            {
                $q->select('id_profil')
                    ->from('profil_multiple')
                    ->where('id_choice', $id_bahasa);
            });
        }

        if($pendidikan)
        $query->whereIn('id_pendidikan', $pendidikan);
        #TAMPIL TOTAL LOKER
        if($source == 'mobile'){
            #OUTPUT DATA
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            $res['data']        = $query->get();
            return $this->api_output($res);
        }

        #OUTPUT DATA
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $query->paginate(10);
        return $this->api_output($res);
    }
    public function getPencariKerjaDetil(){
        $id = $this->input('id', 'required');
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        
        $res['data']   = DB::table('vprofil_pencari_kerja')->where('id_profil',$id)->first();

        $res['bahasa'] = DB::table('vchoice_pencari_kerja')->where('id_tipe','1')->where('id_profil',$id)->pluck('nama_choice')->implode(', ');
        $res['skill']  = DB::table('vchoice_pencari_kerja')->where('id_tipe','2')->where('id_profil',$id)->get();

        $res['pendidikan']  = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',1)->where('id_profil',$id)->get();
        $res['pengalaman']  = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',2)->where('id_profil',$id)->get();
        $res['sertifikasi'] = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',3)->where('id_profil',$id)->get();
        
        #OUTPUT DATA
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        return $this->api_output($res);
    }
}