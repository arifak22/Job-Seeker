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

class PencarikerjaController extends MiddleController
{
    public function __construct()
    {
        #CHECK SESSION
    }
    /* ========== PROFIL START ============ */
    public function getProfil(){
        $data['data']   = DB::table('vprofil_pencari_kerja')->where('id_user', Auth::user()->id)->first();

        $data['bahasa'] = DB::table('vchoice_pencari_kerja')->where('id_tipe','1')->where('id_user', Auth::user()->id)->pluck('nama_choice')->implode(', ');
        $data['skill']  = DB::table('vchoice_pencari_kerja')->where('id_tipe','2')->where('id_user', Auth::user()->id)->get();

        $data['pendidikan']  = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',1)->where('id_user', Auth::user()->id)->get();
        $data['pengalaman']  = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',2)->where('id_user', Auth::user()->id)->get();
        $data['sertifikasi'] = DB::table('vchoice_pencari_kerja_big')->orderBy('tgl_end', 'desc')->where('id_tipe',3)->where('id_user', Auth::user()->id)->get();
        
        $res['data']        = $data;
        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        return $this->api_output($res);
    }
    
    public function postProfilUbah(){
        #VARIABLE PREPARE
        $id_user           = JWTAuth::user()->id;
        $id_profil         = DB::table('profil_pencari_kerja')->where('id_user', $id_user)->first()->id;
        $nama              = $this->input('nama', 'required|max:200'); #table users
        $tanggal_lahir     = $this->input('tanggal_lahir', 'required|date_format:Y-m-d');
        $pengalaman_kerja  = $this->input('pengalaman_kerja', 'required|max:200');
        $no_hp             = $this->input('no_hp', 'required|max:13');
        $jurusan           = $this->input('jurusan', 'required|max:200');
        $jenis_kelamin     = $this->input('jenis_kelamin', 'required|max:20');
        $status_pernikahan = $this->input('status_pernikahan', 'required|max:20');
        $id_pendidikan     = $this->input('id_pendidikan', 'required|exists:pendidikan,id');
        $id_kecamatan      = $this->input('id_kecamatan', 'required|exists:districts,id');
        $id_kelurahan      = $this->input('id_kelurahan', 'required|exists:villages,id');
        $deskripsi         = $this->input('deskripsi', 'required|max:2000');
        $alamat            = $this->input('alamat', 'required|max:2000');

        $id_keahlian = $this->input('id_keahlian');
        $id_bahasa   = $this->input('id_bahasa');
       
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        $config['allowed_type'] = 'png|jpg|jpeg';
        $config['max_size']     = '200';
        $config['required']     = false;
        $gambar = $this->uploadFile('gambar', 'pencarikerja/'.$id_user, 'foto-'.Str::random(5), $config);
        if(!$gambar['is_uploaded']){
            return $this->api_output($gambar['msg']);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{
            #KEAHLIAN
            DB::table('profil_multiple')->where('id_profil', $id_profil)->where('id_tipe', 2)->delete();
            foreach($id_keahlian as $key => $keahlian){
                $saveKeahlian[$key]['id_tipe']   = 2;
                $saveKeahlian[$key]['id_profil'] = $id_profil;
                $saveKeahlian[$key]['id_choice'] = $keahlian;
            }
            DB::table('profil_multiple')->insert($saveKeahlian);

            #BAHASA
            DB::table('profil_multiple')->where('id_profil', $id_profil)->where('id_tipe', 1)->delete();
            foreach($id_bahasa as $key => $bahasa){
                $saveBahasa[$key]['id_tipe']   = 1;
                $saveBahasa[$key]['id_profil'] = $id_profil;
                $saveBahasa[$key]['id_choice'] = $bahasa;
            }
            DB::table('profil_multiple')->insert($saveBahasa);

            #USER
            $updateUser['nama'] = $nama;
            if($gambar['filename'])
            $updateUser['foto'] = $gambar['filename'];
            DB::table('users')->where('id', $id_user)->update($updateUser);

            #PROFIL
            $updateProfil['tanggal_lahir']     = $tanggal_lahir;
            $updateProfil['pengalaman_kerja']  = $pengalaman_kerja;
            $updateProfil['no_hp']             = $no_hp;
            $updateProfil['jurusan']           = $jurusan;
            $updateProfil['jenis_kelamin']     = $jenis_kelamin;
            $updateProfil['status_pernikahan'] = $status_pernikahan;
            $updateProfil['id_pendidikan']     = $id_pendidikan;
            $updateProfil['id_kecamatan']      = $id_kecamatan;
            $updateProfil['id_kelurahan']      = $id_kelurahan;
            $updateProfil['deskripsi']         = $deskripsi;
            $updateProfil['alamat']            = $alamat;
            DB::table('profil_pencari_kerja')->where('id_user', $id_user)->update($updateProfil);

            #BERHASIL
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            #GAGAL 1
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E01)';
            $res['e']           = $e;
        }catch (PDOException $e) {
            #GAGAL 2
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E02)';
            $res['e']           = $e;
        }catch(Exception $e){
            #GAGAL 3
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E03)';
            $res['e']           = $e;
        }

        return $this->api_output($res);
    }

    public function postDetilAdd(){
        #VARIABLE PREPARE
        $id            = $this->input('id');
        $id_user       = JWTAuth::user()->id;
        $id_profil     = DB::table('profil_pencari_kerja')->where('id_user', $id_user)->first()->id;
        $tempat        = $this->input('tempat', 'required|max:200');
        $judul         = $this->input('judul', 'max:200');
        $detil         = $this->input('detil', 'max:2000');
        $tgl_start     = $this->input('tgl_start', 'required|date_format:Y-m-d');
        $tgl_end       = $this->input('tgl_end', 'required|date_format:Y-m-d');
        $id_pendidikan = $this->input('id_pendidikan', 'exists:pendidikan,id');
        $tipe          = $this->input('tipe', 'required');

        #CEK TANGGAL
        if($tgl_start > $tgl_end){
            $res['api_status']  = 0;
            $res['api_message'] = 'Tanggal yang dimasukan tidak sesuai.';
            return $this->api_output($res);
        }

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        #Start Transaksi
        DB::beginTransaction();
        try{

            $save['id_tipe']   = $tipe;
            $save['id_profil'] = $id_profil;
            $save['tempat']    = $tempat;
            $save['judul']     = $judul;
            $save['deskripsi'] = $detil;
            $save['tgl_start'] = $tgl_start;
            $save['tgl_end']   = $tgl_end;
            $save['id_level']  = $id_pendidikan;

            if($id)
            DB::table('profil_multiple_big')->where('id',$id)->where('id_profil',$id_profil)->update($save);
            else
            DB::table('profil_multiple_big')->insert($save);


            #BERHASIL
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            #GAGAL 1
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E01)';
            $res['e']           = $e;
        }catch (PDOException $e) {
            #GAGAL 2
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E02)';
            $res['e']           = $e;
        }catch(Exception $e){
            #GAGAL 3
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E03)';
            $res['e']           = $e;
        }

        return $this->api_output($res);

    }

    public function postDetilHapus(){
        #VARIABLE PREPARE
        $id            = $this->input('id');
        $id_user       = JWTAuth::user()->id;
        $id_profil     = DB::table('profil_pencari_kerja')->where('id_user', $id_user)->first()->id;
        $tipe          = $this->input('tipe', 'required');

        #Start Transaksi
        DB::beginTransaction();
        try{
            DB::table('profil_multiple_big')->where('id',$id)->where('id_profil',$id_profil)->where('id_tipe',$tipe)->delete();

            #BERHASIL
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            #GAGAL 1
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E01)';
            $res['e']           = $e;
        }catch (PDOException $e) {
            #GAGAL 2
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E02)';
            $res['e']           = $e;
        }catch(Exception $e){
            #GAGAL 3
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E03)';
            $res['e']           = $e;
        }

        return $this->api_output($res);

    }
    /* ========== PROFIL END ============ */


    /* ========== KARTU KUNING START ============ */
    public function postKartuKuningPengajuan(){
        #VARIABLE PREPARE
        $id_user         = JWTAuth::user()->id;
        $id_profil       = DB::table('profil_pencari_kerja')->where('id_user', $id_user)->first()->id;
        $no_ijazah       = $this->input('no_ijazah', 'required|max:100');
        $tgl_ijazah      = $this->input('tgl_ijazah', 'required|date_format:Y-m-d');
        $nik             = $this->input('nik', 'required|max:100');
        // $no_kk           = $this->input('no_kk', 'required|max:100');
        $verified_status = $this->input('verified_status', 'required|max:50');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #CEK LAST STATUS
        $lastStatus = DB::table('kartu_kuning')->where('id_user', $id_user)->first()->verified_status;
        $passStatus = ['DRAFT', 'KIRIM', 'TOLAK'];
        if(!in_array($lastStatus,$passStatus) && !empty($lastStatus)){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, terjadi kesalahan. silahkan refresh';
            return $this->api_output($res);
        }

        #CONFIG UPLOAD
        $config['allowed_type'] = 'png|jpg|jpeg';
        $config['max_size']     = '200';
        $config['required']     = false;

        #UPLOAD FILE
        $foto = $this->uploadFile('foto', 'pencarikerja/'.$id_user, 'pasfoto-'.Str::random(5), $config);
        if(!$foto['is_uploaded']){
            return $this->api_output($foto['msg']);
        }
        $ijazah = $this->uploadFile('ijazah', 'pencarikerja/'.$id_user, 'ijazah-'.Str::random(5), $config); #hapus ganti CV
        if(!$ijazah['is_uploaded']){
            return $this->api_output($ijazah['msg']);
        }
        $ktp = $this->uploadFile('ktp', 'pencarikerja/'.$id_user, 'ktp-'.Str::random(5), $config); 
        if(!$ktp['is_uploaded']){
            return $this->api_output($ktp['msg']);
        }
        $cv = $this->uploadFile('cv', 'pencarikerja/'.$id_user, 'cv-'.Str::random(5), $config); #HAPUS, GANTI DATA LAIN-LAIN
        if(!$cv['is_uploaded']){
            return $this->api_output($cv['msg']);
        }
        $lain = $this->uploadFile('lain', 'pencarikerja/'.$id_user, 'lain-'.Str::random(5), $config); #HAPUS, GANTI DATA LAIN-LAIN
        if(!$lain['is_uploaded']){
            return $this->api_output($lain['msg']);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

            #VARIABLE STRING
            $save['id_user']         = $id_user;
            $save['no_ijazah']       = $no_ijazah;
            $save['tgl_ijazah']      = $tgl_ijazah;
            $save['nik']             = $nik;
            // $save['no_kk']           = $no_kk;
            $save['verified_status'] = $verified_status;

            #VARIABLE FILE
            if($ijazah['filename'])
            $save['file_ijazah'] = $ijazah['filename'];
            if($ktp['filename'])
            $save['file_ktp'] = $ktp['filename'];
            if($cv['filename'])
            $save['file_cv'] = $cv['filename'];
            if($lain['filename'])
            $save['file_lain'] = $lain['filename'];
            if($foto['filename'])
            $save['pas_foto'] = $foto['filename'];

            #UPDATE
            DB::table('kartu_kuning')->where('id_user', $id_user)->update($save);

            #BERHASIL
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            #GAGAL 1
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E01)';
            $res['e']           = $e;
        }catch (PDOException $e) {
            #GAGAL 2
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E02)';
            $res['e']           = $e;
        }catch(Exception $e){
            #GAGAL 3
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E03)';
            $res['e']           = $e;
        }

        return $this->api_output($res);

    }
    /* ========== KARTU KUNING END ============ */

    /* ========== LAMAR START = kurang cek hanya pencari kerja =========== */
    public function postLamar(){
        $id      = $this->input('id', 'required');
        $id_user = JWTAuth::user()->id;
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        $check_exist = DB::table('loker_pelamar')->where('id_loker', $id)->where('id_pelamar', $id_user)->count();
        if($check_exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, anda sudah mengajukan lamaran kerja ini';
            return $this->api_output($res);
        }

        $status_kartu_kuning = DB::table('kartu_kuning')->where('id_user', $id_user)->where('verified_status', 'DONE')->count();
        if($status_kartu_kuning == 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Selesaikan Proses KARTU AK.1 (Kartu Kuning)';
            return $this->api_output($res);
        }
        
        #Start Transaksi
        DB::beginTransaction();
        try{

            $save['id_loker']        = $id;
            $save['id_pelamar']      = $id_user;
            $save['tanggal_melamar'] = date('Y-m-d');
            DB::table('loker_pelamar')->insert($save);

            #BERHASIL
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            #GAGAL 1
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E01)';
            $res['e']           = $e;
        }catch (PDOException $e) {
            #GAGAL 2
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E02)';
            $res['e']           = $e;
        }catch(Exception $e){
            #GAGAL 3
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E03)';
            $res['e']           = $e;
        }

        return $this->api_output($res);
        
    }

    public function getLamaran(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $query = DB::table('loker_pelamar')
            ->join('vloker', 'vloker.id','=','loker_pelamar.id_loker')
            ->select('loker_pelamar.id', 'judul', 'tanggal_melamar','kecamatan','kelurahan','id_loker')
            ->where('id_pelamar', JWTAuth::user()->id);
        // echo $query;
        if($datatable):
            return datatables()->of($query)->toJson();
        else:
            $data = $query->get();
            if($data){
                $res['api_status']  = 1;
                $res['api_message'] = 'success';
                $res['data']        = $data;
            }else{
                $res['api_status']  = 0;
                $res['api_message'] = 'Data Tidak ditemukan';
            }
            return $this->api_output($res);
        endif;
    }

    public function postLamaranHapus(){
        $id = $this->input('id');
        $id_user = JWTAuth::user()->id;

        #Start Transaksi
        DB::beginTransaction();
        try{

            $deleted = DB::table('loker_pelamar')->where('id', $id)->where('id_pelamar', $id_user)->delete();
            #BERHASIL
            $res['api_status']  = 1;
            $res['api_message'] = 'success';
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            #GAGAL 1
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E01)';
            $res['e']           = $e;
        }catch (PDOException $e) {
            #GAGAL 2
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E02)';
            $res['e']           = $e;
        }catch(Exception $e){
            #GAGAL 3
            DB::rollback();
            $res['api_status']  = 0;
            $res['api_message'] = 'Aplikasi Mengalami Masalah (Code: E03)';
            $res['e']           = $e;
        }

        return $this->api_output($res);
    }
    /* ========== LAMAR END ============ */
}