<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Setting;
use App\CompanySetting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CompanySetting::where('userid',Auth::user()->id)->get();
        //dd($data);
        return view('company.settings.index',compact('data'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'data' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status"=>400,"msg"=>$validator->errors()->first(),"result"=>array());
        } else {

            try {
                $input = $request->all();

                foreach ($input['data'] as $key => $value){
                 //   DB::enableQueryLog();
                    $key = str_replace("'",'',$key);
                   // Setting::where('key',$key)->update(['value'=>$value]);
                   if($key == 'minlogintime' || $key =='maxlogouttime'){
                        $value = date('h:i a ', strtotime($value));
                   }
                    $user = CompanySetting::firstOrNew(array('key' => $key,'userid'=>Auth::user()->id));
                    $user->userid = Auth::user()->id;
                    $user->key = $key;
                    $user->value = $value;
                    $user->save();
                   // dd(DB::getQueryLog());
                }

                $msg = 'Setting Update successfully.';
                $arr = array("status"=>200,"msg"=>$msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;

                $arr = array("status" => 400, "msg" =>$msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;

                $arr = array("status" => 400, "msg" =>$msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }

    
}
