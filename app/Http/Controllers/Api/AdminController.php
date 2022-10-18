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
}