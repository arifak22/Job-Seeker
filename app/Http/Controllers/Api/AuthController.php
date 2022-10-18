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

class AuthController extends MiddleController
{
    #Auth Register
    public function postRegister(){

        #Prepare Variable
        $tipe           = $this->input('tipe','required');
        $email          = $this->input('email', 'required|email|unique:users,email|max:200');
        $nama_pemilik   = $this->input('nama_pemilik', 'required|max:200');
        $nama           = $this->input('nama', 'max:200');
        $password       = $this->input('password', 'required|min:8');
        $password_again = $this->input('password_again', 'required|min:8');

        #Cek Password Sesuai dua-duanya
        if($password != $password_again){
            $res['api_status']  = 0;
            $res['api_message'] = 'Password yg anda masukan tidak cocok.';
            return $this->api_output($res);
        }

        #CEK VALID
        if($this->validator()){
            return  $this->validator(true);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{
            
            #Insert tabel User
            $save['id_privilege'] = $tipe;
            $save['status']       = 1;
            $save['email']        = $email;
            $save['nama_pemilik'] = $nama_pemilik;
            $save['nama']         = $tipe == '2' ? $nama : $nama_pemilik;
            $save['password']     = Hash::make($password);
            $save['created_date'] = date('Y-m-d H:i:s');
            $id_user = DB::table('users')->insertGetId($save);

            if($tipe == 1){
                #Add
                $saveAdd['id_user'] = $id_user;
                DB::table('kartu_kuning')->insert($saveAdd);
                DB::table('profil_pencari_kerja')->insert($saveAdd);
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

    public function postLogin(){
        $credentials = Request::only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $res['api_status']  = 0;
            $res['api_message'] = 'Token Berhasil di Generate';
            // $token = JWTAuth::attempt($credentials);
            $token = JWTAuth::customClaims(['device' => 'api'])->fromUser(Auth::user());
            $res['jwt_token']   = $token;
        }else{
            $res['api_status']  = 0;
            $res['api_message'] = 'Username & Password tidak sesuai. Coba Lagi.';
            $res['jwt_token']   = null;
        }
        return response()->json($res);
    }
}