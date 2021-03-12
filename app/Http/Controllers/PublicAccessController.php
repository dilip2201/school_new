<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\User;
use App\UserApp;
use Carbon\Carbon;
use App\City;
use App\states;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PublicAccessController extends Controller
{
    public function city(Request $request)
    {
        try {
            $result = '<option value="">---- Select City ----</option>';
            if ($request->state_id != '') {
                $city = City::where('state_id', $request->state_id)->get();

                if (!empty($city)) {
                    foreach ($city as $citys) {
                        $result .= '<option value="' . $citys->id . '">' . $citys->name . '</option>';
                    }
                }
            }

            $arr = array("status" => 200, "msg" => 'success', 'result' => $result);
        } catch (\Illuminate\Database\QueryException $ex) {
            $msg = $ex->getMessage();
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        }
        return \Response::json($arr);
    }


    public function citywithstatecountry(Request $request)
    {

        $input = $request->all();
        //define for get only this countries city 101 = india
        $country_ids = ['230', '105', '101'];
        $cities = City::with('state.country')
            ->where('name', 'Like', '%' . $input['term']['term'] . '%')
            ->whereHas('state.country', function ($query) use ($country_ids) {
                $query->whereIn('id', $country_ids);
            })
            ->get()->toArray();
        return \Response::json($cities);


    }
}
