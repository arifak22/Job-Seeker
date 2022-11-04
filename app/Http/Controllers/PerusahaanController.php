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
        $data['loker']         = DB::table('loker')->where('id_user', Auth::user()->id)->where('status_loker', 'POST')->count();
        $data['lamaran']       = DB::table('loker_pelamar')->join('loker', 'loker.id','=', 'loker_pelamar.id_loker')->where('id_user', Auth::user()->id)->count();
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
        $data['title'] = 'Kelola Loker';
        $data['tipe']  = 'perusahaan';
        return Sideveloper::load('dashboard', 'perusahaan/lokerkelola', $data);
    }

    public function getLokerApplicant(){
        $id   = $this->input('id');
        $tipe = $this->input('tipe');
        $data['title'] = 'Loker Applicant';
        $data['judul'] = DB::table('loker')->where('id', $id)->first()->judul;
        $data['data']  = DB::table('loker_pelamar')
            ->join('vprofil_pencari_kerja', 'vprofil_pencari_kerja.id_user', '=', 'loker_pelamar.id_pelamar')
            ->where('id_loker', $id)->orderBy('tanggal_melamar', 'desc')->get();

        if($tipe == 'excel'){
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            #SET TITLE
            $spreadsheet->getProperties()->setCreator('SIAPNARI')
                ->setTitle('Pelamar Kerja');
            $spreadsheet->getActiveSheet()->setTitle('Pelamar Kerja');

            #VALUE EXCEL
            $sheet = $spreadsheet->setActiveSheetIndex(0);
            #SET PROPERTIES
            $sheet->setCellValue('A1', 'DAFTAR PELAMAR KERJA');
            $spreadsheet->getActiveSheet()->mergeCells("A1:J1");
            $sheet->setCellValue('A2', 'LOWONGAN KERJA: '.$data['judul']);
            $spreadsheet->getActiveSheet()->mergeCells("A2:J2");

            #TITLE
            $sheet->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'Nama')
                ->setCellValue('C4', 'Jenis Kelamin')
                ->setCellValue('D4', 'Tanggal Lahir')
                ->setCellValue('E4', 'Umur')
                ->setCellValue('F4', 'Pendidikan Terakhir')
                ->setCellValue('G4', 'E-mail')
                ->setCellValue('H4', 'No. HP')
                ->setCellValue('I4', 'Alamat')
                ->setCellValue('J4', 'Tanggal Melamar');
            $sheet->getStyle('A1:J4')->getAlignment()->setHorizontal('center');

            #SET VALUE
            $i = 5;
            foreach($data['data'] as $d){
                $sheet->setCellValue('A'.$i, $i-4)
                    ->setCellValue('B'.$i, $d->nama)
                    ->setCellValue('C'.$i, $d->jenis_kelamin)
                    ->setCellValue('D'.$i, $d->tanggal_lahir)
                    ->setCellValue('E'.$i, $d->umur)
                    ->setCellValue('F'.$i, $d->pendidikan_terakhir . ' - ' . $d->jurusan)
                    ->setCellValue('G'.$i, $d->email)
                    ->setCellValue('H'.$i, $d->no_hp)
                    ->setCellValue('I'.$i, $d->kecamatan. ', '.$d->kelurahan)
                    ->setCellValue('J'.$i, $d->tanggal_melamar);
                $i++;
            }

            #AUTO SIZE
            for ($z='A'; $z <= 'J' ; $z++) { 
                $sheet->getColumnDimension($z)->setAutoSize(TRUE);
            }

            #OUTPUT EXCEL
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$data['judul'].'_'.date('YmdHis').'.xlsx"');
            return $writer->save("php://output");
        }

        return Sideveloper::load('dashboard', 'perusahaan/lokerapplicant', $data);
    }

    public function getKaryawan(){
        $data['title'] = 'Karyawan';
        return Sideveloper::load('dashboard', 'perusahaan/karyawan', $data);
    }
}