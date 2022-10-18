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
use Sideveloper;
use Auth;
class OptionController extends MiddleController
{
    public function getIndex(){
        $search    = $this->input('search');
        
        switch ($search) {
            case 'kelurahaan':
                $pk    = 'id';
                $fk    = 'district_id';
                $field = 'name';
                $table = DB::table('villages')
                    ->select('villages.id','villages.name')
                    ->join('districts','districts.id','=','villages.district_id')
                    ->where('regency_id', 2101);
                break;
            
            default:
                # code...
                break;
        }

        $id    = $this->input('id');
        $all   = $this->input('all');
        $all   = $all ? true : false;

        if($id){
            $table->where($fk, $id);
        }
        $data = $table->get();
        $option = Sideveloper::makeOption($data, $pk, $field, $all);
        if(count($data) > 0){
            $this->res['api_status']  = 1;
            $this->res['api_message'] = 'success';
            $this->res['data']        = $option;
        }else{
            $this->res['api_message'] = 'Data Kosong';
        }

        #SUKSES
        return $this->api_output($this->res);
    }
}