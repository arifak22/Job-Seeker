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

class AdminController extends MiddleController
{
    public function getKartuKuningList(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $verified_status = $this->input('verified_status');
        $query = DB::table('vkartu_kuning as kartu_kuning')
            ->select('kartu_kuning.id', 'kartu_kuning.nik', 'users.nama', 'verified_status', 'kartu_kuning.status_text', 'status_color')
            ->orderBy('status_number', 'desc')
            ->join('users','users.id','=','kartu_kuning.id_user');

        if($verified_status)
            $query->where('verified_status', $verified_status);
            
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

    public function postKartuKuningVerifikasi(){
        #Prepare Variable
        $id               = $this->input('id', 'required');
        $verified_status  = $this->input('verified_status',  'required|max:50');
        $verified_catatan = $this->input('verified_catatan', 'max:255');
        $last             = DB::table('kartu_kuning')->where('id', $id)->first();
        $lastStatus       = $last->verified_status;
        $id_user          = $last->id_user;

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        
        #Jika Status Selesai
        if($verified_status == 'DONE'){
            #CONFIG UPLOAD
            $config['allowed_type'] = 'png|jpg|jpeg';
            $config['max_size']     = '200';
            $config['required']     = true;

            #UPLOAD FILE
            $file = $this->uploadFile('file_kartu_kuning', 'pencarikerja/'.$id_user, 'kartu_kuning-'.Str::random(5), $config);
            if(!$file['is_uploaded']){
                return $this->api_output($file['msg']);
            }
        }

        #Jika Status Tolak
        if($verified_status == 'TOLAK'){
            if(empty($verified_catatan)){
                $res['api_status']  = 0;
                $res['api_message'] = 'Maaf, Catatan Wajib Di isi';
                return $this->api_output($res);
            }
        }

         #Start Transaksi
         DB::beginTransaction();
         try{

            $save['verified_status']  = $verified_status;
            $save['verified_catatan'] = $verified_catatan;
            $save['verified_date']    = date('Y-m-d H:i:s');
            $save['verified_by']      = JWTAuth::user()->id;
            if($verified_status == 'DONE'){
                if($file['filename'])
                $save['file_kartu_kuning'] = $file['filename'];
            }

            #UPDATE
            DB::table('kartu_kuning')->where('id', $id)->update($save);

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

    #---------- MASTER BIDANG -----------#
    public function getMasterBidang(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $query = DB::table('bidang');
            
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

    public function postMasterBidangHapus(){
        $id = $this->input('id', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #USED FOREIGN KEY
        $used = DB::table('profil_perusahaan')->where('id_bidang', $id)->count();
        if($used > 0 ){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Bidang Usaha Sudah digunakan.';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

            DB::table('bidang')->where('id', $id)->delete();
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

    public function postMasterBidangPost(){
        $id          = $this->input('id');
        $nama_bidang = $this->input('nama_bidang', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        
        // \DB::enableQueryLog();
        $exist = DB::table('bidang')
            ->where(DB::raw('lower(nama_bidang)'), strtolower($nama_bidang));
        if($id)
        $exist->where('id', '<>', $id);

        $exist = $exist->count();
        // dd(\DB::getQueryLog());

        if($exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Nama Bidang yg anda masukan sudah ada';
            return $this->api_output($res);
        }
        // if($)
        #Start Transaksi
        DB::beginTransaction();
        try{

        $save['nama_bidang'] = $nama_bidang;
        if($id)
            DB::table('bidang')->where('id',$id)->update($save);
        else
            DB::table('bidang')->insert($save);
        
        
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

    public function getMasterBidangDetil(){
        $id = $this->input('id','required');
        $data = DB::table('bidang')->where('id', $id)->first();

        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $data;
        return $this->api_output($res);
    }
    ##DONE

    #---------- MASTER CHOICE -----------#
    public function getMasterChoice(){
        $datatable = $this->input('draw') ?  true : false;
        $tipe      = $this->input('tipe');
        $search    = $this->input('search');
        $query = DB::table('choice')->where('id_tipe', $tipe);
            
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

    public function postMasterChoiceHapus(){
        $id   = $this->input('id', 'required');
        $tipe = $this->input('tipe', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #USED FOREIGN KEY
        $used = DB::table('profil_multiple')->where('id_choice', $id)->where('id_tipe',$tipe)->count();
        if($used > 0 ){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Keahlian / Bahasa Sudah digunakan.';
            return $this->api_output($res);
        }
        #USED FOREIGN KEY
        $used = DB::table('loker_multiple')->where('id_choice', $id)->where('id_tipe',$tipe)->count();
        if($used > 0 ){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Keahlian / Bahasa Sudah digunakan.';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

            DB::table('choice')->where('id', $id)->where('id_tipe', $tipe)->delete();
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

    public function postMasterChoicePost(){
        $id   = $this->input('id');
        $nama = $this->input('nama', 'required');
        $tipe = $this->input('tipe', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        
        #VALIDASI MANUAL
        $exist = DB::table('choice')
            ->where('id_tipe', $tipe)
            ->where(DB::raw('lower(nama)'), strtolower($nama));
        if($id)
        $exist->where('id', '<>', $id);

        $exist = $exist->count();

        if($exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Bahasa / Keahlian yg anda masukan sudah ada';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

        $save['nama']    = $nama;
        $save['id_tipe'] = $tipe;
        if($id)
            DB::table('choice')->where('id',$id)->where('id_tipe',$tipe)->update($save);
        else
            DB::table('choice')->insert($save);
        
        
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
    
    public function getMasterChoiceDetil(){
        $id   = $this->input('id','required');
        $tipe = $this->input('tipe','required');
        $data = DB::table('choice')->where('id', $id)->where('id_tipe', $tipe)->first();

        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $data;
        return $this->api_output($res);
    }
    ##DONE

    #---------- MASTER KECAMATAN -----------#
    public function getMasterKecamatan(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $query = DB::table('districts')->where('regency_id', 2101);
            
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

    public function postMasterKecamatanHapus(){
        $id = $this->input('id', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #USED FOREIGN KEY
        $used  = 0;
        $used1 = DB::table('profil_perusahaan')->where('id_kecamatan', $id)->count();
        $used2 = DB::table('profil_pencari_kerja')->where('id_kecamatan', $id)->count();
        $used3 = DB::table('loker')->where('id_kecamatan', $id)->count();
        $used4 = DB::table('villages')->where('district_id', $id)->count();
        $used  = $used1 + $used2 + $used3 + $used4;

        if($used > 0 ){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Kecamatan Sudah digunakan.';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

            DB::table('districts')->where('id', $id)->where('regency_id', 2101)->delete();
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

    public function postMasterKecamatanPost(){
        $id          = $this->input('id');
        $name = $this->input('name', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        
        $exist = DB::table('districts')
            ->where('regency_id', 2101)
            ->where(DB::raw('lower(name)'), strtolower($name));
        if($id)
        $exist->where('id', '<>', $id);

        $exist = $exist->count();

        if($exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Nama Kecamatan yg anda masukan sudah ada';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{
            
            $save['name']       = $name;
            $save['regency_id'] = 2101;
            if($id){
                DB::table('districts')->where('id',$id)->update($save);
            }else{
                $save['id'] = DB::table('districts')->where('regency_id', 2101)->max('id') + 1;
                DB::table('districts')->insert($save);
            }
            
            
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

    public function getMasterKecamatanDetil(){
        $id = $this->input('id','required');
        $data = DB::table('districts')->where('id', $id)->where('regency_id', 2101)->first();

        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $data;
        return $this->api_output($res);
    }
    ##DONE

     #---------- MASTER KELURAHAN -----------#
    public function getMasterKelurahan(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $district_id          = $this->input('district_id');
        $query = DB::table('villages')->where('district_id', $district_id);
            
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

    public function postMasterKelurahanHapus(){
        $id          = $this->input('id', 'required');
        $district_id = $this->input('district_id', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #USED FOREIGN KEY
        $used  = 0;
        $used1 = DB::table('profil_perusahaan')->where('id_kelurahan', $id)->count();
        $used2 = DB::table('profil_pencari_kerja')->where('id_kelurahan', $id)->count();
        $used3 = DB::table('loker')->where('id_kelurahan', $id)->count();
        $used  = $used1 + $used2 + $used3;

        if($used > 0 ){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Kecamatan Sudah digunakan.';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

            DB::table('villages')->where('id', $id)->where('district_id', $district_id)->delete();
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

    public function postMasterKelurahanPost(){
        $id          = $this->input('id');
        $district_id          = $this->input('district_id');
        $name = $this->input('name', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }
        
        $exist = DB::table('villages')
            ->where('district_id', $district_id)
            ->where(DB::raw('lower(name)'), strtolower($name));
        if($id)
        $exist->where('id', '<>', $id);

        $exist = $exist->count();

        if($exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Nama Kelurahan yg anda masukan sudah ada';
            return $this->api_output($res);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{
            
            $save['name']       = $name;
            $save['district_id'] = $district_id;
            if($id){
                DB::table('villages')->where('id',$id)->update($save);
            }else{
                $save['id'] = DB::table('villages')->where('district_id', $district_id)->max('id') + 1;
                DB::table('villages')->insert($save);
            }
            
            
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

    public function getMasterKelurahanDetil(){
        $id = $this->input('id','required');
        $district_id = $this->input('district_id','required');
        $data = DB::table('villages')->where('id', $id)->where('district_id', $district_id)->first();

        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $data;
        return $this->api_output($res);
    }
    ##DONE

    #---------- MASTER ADMIN -----------#
    public function getMasterAdmin(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $query = DB::table('users')->where('id_privilege', 3);
            
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

    public function postMasterAdminHapus(){
        $id = $this->input('id', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

            DB::table('users')->where('id_privilege', 3)->where('id', $id)->delete();
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

    public function postMasterAdminPost(){
        $id           = $this->input('id');
        $id_privilege = 3;
        $nama         = $this->input('nama', 'required');
        $password     = $this->input('password', 'required');
        $password_2   = $this->input('password_2', 'required');
        $email        = $this->input('email', 'required');

        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        $exist = DB::table('users')
            ->where('email', $email);
        if($id)
        $exist->where('id', '<>', $id);

        $exist = $exist->count();

        if($exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, E-mail yg anda masukan sudah ada';
            return $this->api_output($res);
        }

        if($password != $password_2){
            $res['api_status']  = 0;
            $res['api_message'] = 'Password yg anda masukan tidak sama';
            return $this->api_output($res);
        }
        $password = Hash::make($password);

        $config['allowed_type'] = 'png|jpg|jpeg';
        $config['max_size']     = '200';
        $config['required']     = false;
        $gambar = $this->uploadFile('foto', 'admin', 'foto-'.Str::random(5), $config);
        if(!$gambar['is_uploaded']){
            return $this->api_output($gambar['msg']);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{

        $save['id_privilege'] = $id_privilege;
        $save['nama']         = $nama;
        $save['password']     = $password;
        $save['email']        = $email;
        $save['status']       = 1;
        $save['nama_pemilik'] = $nama;
        $save['created_date'] = date('Y-m-d H:i:s');
        if($gambar['filename'])
            $save['foto'] = $gambar['filename'];

        if($id)
            DB::table('users')->where('id',$id)->update($save);
        else
            DB::table('users')->insert($save);
        
        
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

    public function getMasterAdminDetil(){
        $id = $this->input('id','required');
        $data = DB::table('users')->where('id', $id)->where('id_privilege', 3)->first();

        $res['api_status']  = 1;
        $res['api_message'] = 'success';
        $res['data']        = $data;
        return $this->api_output($res);
    }
    ##DONE
    
}