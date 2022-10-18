<?php  

namespace App\Http\Controllers\Api;


use DB;
use Str;
use JWTAuth;
use Carbon;
use Sideveloper;
use App\Http\Controllers\MiddleController;

class PerusahaanController extends MiddleController
{

    /* ========== PROFIL START ============ */
    public function postProfilUbah(){
        #VARIABLE PREPARE
        $id_user       = JWTAuth::user()->id;
        $id_profil     = DB::table('profil_perusahaan')->where('id_user', $id_user)->first()->id;
        $nama          = $this->input('nama', 'required|max:200'); #table users
        $no_hp         = $this->input('no_hp', 'required|max:13');
        $id_bidang     = $this->input('id_bidang', 'required|exists:bidang,id');
        $id_kecamatan  = $this->input('id_kecamatan', 'required|exists:districts,id');
        $id_kelurahan  = $this->input('id_kelurahan', 'required|exists:villages,id');
        $deskripsi     = $this->input('deskripsi', 'required|max:2000');
        $alamat        = $this->input('alamat', 'required|max:2000');
        $tahun_berdiri = $this->input('tahun_berdiri', 'required|date_format:Y');
        $website       = $this->input('website', 'required|max:200');
        $total_pegawai = $this->input('total_pegawai', 'required|max:100');
       
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        $config['allowed_type'] = 'png|jpg|jpeg';
        $config['max_size']     = '200';
        $config['required']     = false;
        $gambar = $this->uploadFile('foto', 'perusahaan/'.$id_user, 'foto-'.Str::random(5), $config);
        if(!$gambar['is_uploaded']){
            return $this->api_output($gambar['msg']);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{
            #USER
            $updateUser['nama'] = $nama;
            if($gambar['filename'])
            $updateUser['foto'] = $gambar['filename'];
            DB::table('users')->where('id', $id_user)->update($updateUser);

            #PROFIL
            $updateProfil['tahun_berdiri'] = $tahun_berdiri;
            $updateProfil['website']       = $website;
            $updateProfil['no_hp']         = $no_hp;
            $updateProfil['id_bidang']     = $id_bidang;
            $updateProfil['id_kecamatan']  = $id_kecamatan;
            $updateProfil['id_kelurahan']  = $id_kelurahan;
            $updateProfil['deskripsi']     = $deskripsi;
            $updateProfil['alamat']        = $alamat;
            $updateProfil['total_pegawai'] = $total_pegawai;
            DB::table('profil_perusahaan')->where('id_user', $id_user)->update($updateProfil);

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

    /* ========= LOKER START =========== */
    public function postLokerAdd(){
        // dd($_POST);
        #VARIABLE PREPARE
        $id                 = $this->input('id');
        $id_user            = JWTAuth::user()->id;
        $id_profil          = DB::table('profil_perusahaan')->where('id_user', $id_user)->first()->id;
        $judul              = $this->input('judul', 'required|max:200');
        $deskripsi          = $this->input('deskripsi', 'required|max:2000');
        $tanggal_kadaluarsa = $this->input('tanggal_kadaluarsa', 'required|date_format:Y-m-d');
        $jenis_kelamin      = $this->input('jenis_kelamin');
        $id_jenis_pekerjaan = $this->input('id_jenis_pekerjaan', 'required');
        $id_kecamatan       = $this->input('id_kecamatan', 'required|exists:districts,id');
        $id_kelurahan       = $this->input('id_kelurahan', 'required|exists:villages,id');
        $id_pendidikan      = $this->input('id_pendidikan', 'required|exists:pendidikan,id');
        $show_gaji          = $this->input('show_gaji', 'required');
        $jenis_gaji         = $this->input('jenis_gaji', 'required');
        $status_loker       = $this->input('status_loker', 'required');
        $gaji               = $this->input('gaji', 'numeric|min:0|required');
        $gaji_max           = $this->input('gaji_max', 'numeric|gt:gaji|nullable');

        #CEK JIKA GAJI RANGE
        if($jenis_gaji == 'range' && empty($gaji_max)){
            $res['api_status']  = 0;
            $res['api_message'] = 'Gaji Maksimal Wajib Di isi';
            return $this->api_output($res);
        }

        $judul_multiple     = $this->input('judul_multiple');
        $deskripsi_multiple = $this->input('deskripsi_multiple');

        $id_keahlian = $this->input('id_keahlian');
        $id_bahasa   = $this->input('id_bahasa');
       
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        #Start Transaksi
        DB::beginTransaction();
        try{
            #INSERT LOKER
            $save['id_user']      = $id_user;
            $save['judul']        = $judul;
            $save['deskripsi']    = $deskripsi;
            $save['status_loker'] = $status_loker;
            $save['tanggal_kadaluarsa'] = $tanggal_kadaluarsa;
            if($status_loker == 'POST')
            $save['tanggal_post']       = date('Y-m-d');
            $save['created_date']       = date('Y-m-d H:i:s');
            $save['jenis_kelamin']      = $jenis_kelamin ?? null;
            $save['id_jenis_pekerjaan'] = $id_jenis_pekerjaan;
            $save['id_kecamatan']       = $id_kecamatan;
            $save['id_kelurahan']       = $id_kelurahan;
            $save['id_pendidikan']      = $id_pendidikan;
            $save['show_gaji']          = $show_gaji;
            $save['jenis_gaji']         = $jenis_gaji;
            $save['gaji']               = $gaji;
            $save['gaji_max']           = $gaji_max;
            if($id){
                DB::table('loker')->where('id', $id)->update($save);
            }else{
                $id = DB::table('loker')->insertGetId($save);
            }

            #KEAHLIAN
            DB::table('loker_multiple')->where('id_loker', $id)->where('id_tipe', 2)->delete();
            if($id_keahlian){
                foreach($id_keahlian as $key => $keahlian){
                    $saveKeahlian[$key]['id_tipe']   = 2;
                    $saveKeahlian[$key]['id_loker']  = $id;
                    $saveKeahlian[$key]['id_choice'] = $keahlian;
                }
                DB::table('loker_multiple')->insert($saveKeahlian);
            }

            #BAHASA
            DB::table('loker_multiple')->where('id_loker', $id)->where('id_tipe', 1)->delete();
            if($id_bahasa){
                foreach($id_bahasa as $key => $bahasa){
                    $saveBahasa[$key]['id_tipe']   = 1;
                    $saveBahasa[$key]['id_loker']  = $id;
                    $saveBahasa[$key]['id_choice'] = $bahasa;
                }
                DB::table('loker_multiple')->insert($saveBahasa);
            }

            DB::table('loker_deskripsi')->where('id_loker', $id)->delete();
            DB::table('loker_deskripsi_detil')->where('id_loker', $id)->delete();
            #DESKRIPSI DETIL
            foreach($judul_multiple as $key => $jm){
                if(!$jm)
                continue;

                $saveJudul['id_loker']        = $id;
                $saveJudul['judul_deskripsi'] = $jm;
                $idDeskripsi = DB::table('loker_deskripsi')->insertGetId($saveJudul);
                foreach($deskripsi_multiple[$key] as $dm){
                    if(!$dm)
                    continue;

                    $saveKeterangan['id_loker_deskripsi'] = $idDeskripsi;
                    $saveKeterangan['id_loker']           = $id;
                    $saveKeterangan['keterangan']         = $dm;
                    DB::table('loker_deskripsi_detil')->insert($saveKeterangan);
                }
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

    public function getLokerKelola(){
        $datatable       = $this->input('draw') ?  true : false;
        $search          = $this->input('search');
        $status_loker = $this->input('status_loker');
        $query = DB::table('vloker')
            ->select('id', 'judul', 'status_loker', 'status_color', 'jumlah_pelamar', 'tanggal_dibuat', 'tanggal_kadaluarsa', 'kecamatan', 'kelurahan')
            ->where('id_user', JWTAuth::user()->id)
            ->orderBy('status_loker', 'desc');

        if($status_loker)
            $query->where('status_loker', $status_loker);
            
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

    public function postLokerHapus(){
        $id      = $this->input('id', 'required');
        $id_user = JWTAuth::user()->id;
        #CEK VALID
        if($this->validator()){
            return $this->validator(true);
        }

        $exist = DB::table('loker_pelamar')->where('id_loker', $id)->count();
        if($exist > 0){
            $res['api_status']  = 0;
            $res['api_message'] = 'Sudah ada Pelamar Tidak dapat dihapus';
            return $this->api_output($res);
        }
        
        #Start Transaksi
        DB::beginTransaction();
        try{

            $deleted = DB::table('loker')->where('id', $id)->where('id_user', $id_user)->delete();
            if($deleted > 0){
                DB::table('loker_deskripsi')->where('id_loker', $id)->delete();
                DB::table('loker_deskripsi_detil')->where('id_loker', $id)->delete();
                DB::table('loker_multiple')->where('id_loker', $id)->delete();
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
    /* ========= LOKER END =========== */
}