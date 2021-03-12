<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Validator;
use Hash;
use App\City;
use App\Country;
use App\states;
use App\School;
use App\Commision;
use App\UniformHistory;
use App\ItemMaster;
use App\StandardStrength;


class SchoolController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.schools.index');
    }

     /**
     * Get all the users
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {

        $schools = School::orderby('id', 'desc');
        $schools = $schools->get();
        return DataTables::of($schools)
            ->addColumn('action', function ($q) {
                $id = $q->id;

                $return = '<a class="btn btn-primary btn-sm openclientview" data-toggle="modal" data-school_id="'.$id.'" data-typeid="" data-target=".view_detail" href="#"><i class="fas fa-folder"></i> </a>';
                if(checkPermission(['super_admin'])){
                    $return .= ' <a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> </a>';

                    /*$return .= ' <a class="btn btn-danger btn-sm delete_record" data-id="'.$q->id.'" href="javascript:void(0)"> <i class="fas fa-trash"></i> </a>';
*/
                    $return .= ' <a class="btn btn-primary btn-sm opencommission" data-toggle="modal" data-school_id="'.$id.'" data-typeid="" data-target=".add_commision" href="#"><i class="fas fa-plus"></i> </a> ';
                 }

                return $return;
            })
            ->addColumn('image', function ($q) {
            $image = url('public/company/employee/default.png'); 
            if(file_exists(public_path().'/company/employee/'.$q->p_image) && !empty($q->p_image)) :
                $image = url('public/company/employee/'.$q->p_image); 
            endif;
            return '<img class="profile-user-img img-fluid" src="'.$image.'" style="width:50px; height:50px;">';
            }) 

            ->addColumn('name', function ($q) {
                return $q->name;
            })

            ->addColumn('city', function ($q) {
                return $q->city->name;
            })
            
            ->addIndexColumn()
            ->rawColumns(['image','status', 'action'])->make(true);
    }
     /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {
        $school = array();
        if (isset($request->id) && $request->id != '') {
            $id = $request->id;
            $school = School::with('city.state.country')->where('id',$id)->first();
        }
        $standards = \DB::table('standards')->get();
        return view('admin.schools.getmodal', compact('school','standards'));
    }

    public function getcomissionmodal(Request $request)
    {
        $school_id = $request->school_id;
        $items = \DB::table('items')->get();
        return view('admin.schools.commision', compact('school_id','items'));
    }


    public function storehistoryuniform(Request $request)
    {

        // echo '<pre>';
        // print_r($request->all());
        // exit;
        
        $rules = [
            'month' => 'required',
            'year' => 'required',
            'select_uniform' => 'required',
            'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {

                $comission = new UniformHistory;
                $msg = "History of change in uniform added successfully.";
                $comission->school_id = $request->schoolid;
                $comission->month = $request->month;
                $comission->year = $request->year;
                $comission->remarks = $request->remarks;
                $comission->item_ids = implode(',', $request->select_uniform);
                $comission->save();
                $arr = array("status" => 200, "msg" => $msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }

    public function storecommision(Request $request)
    {

        // echo '<pre>';
        // print_r($request->all());
        // exit;
        
        $rules = [
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required',
            'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {

                $comission = new Commision;
                $msg = "Commission added successfully.";
                $comission->school_id = $request->schoolid;
                $comission->month = $request->month;
                $comission->year = $request->year;
                $comission->remarks = $request->remarks;
                $comission->amount = $request->amount;
                $comission->save();
                $arr = array("status" => 200, "msg" => $msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }
    /**
     * Show city state country json
     *
     * @return \Illuminate\Http\Response
     */

    public function citywithstatecountry(Request $request) 
    {
        $input = $request->all();
        //define for get only this countries city 101 = india
        $country_ids= ['230','105','101'];
        $cities = City::with('state.country')
            ->where('name','Like','%'.$input['term']['term'].'%')
            ->whereHas('state.country', function($query) use ($country_ids){
                $query->whereIn('id',$country_ids);
            })
            ->get()->toArray();
        return \Response::json($cities);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function viewdetail(Request $request){
        $id = $request->school_id;
        $comisions = Commision::with('school')->where('school_id',$id)->orderby('id','desc')->get();
        $itemsmasters = \DB::table("uniform_history")->select("uniform_history.*",\DB::raw("GROUP_CONCAT(items.name) as docname"))->leftjoin("items",\DB::raw("FIND_IN_SET(items.id,uniform_history.item_ids)"),">",\DB::raw("'0'"))
            ->groupBy("uniform_history.id")->where('uniform_history.school_id',$id)->orderby('uniform_history.id','desc')->get();
        $school = School::whereId($id)->first();
        return view('admin.schools.show',compact('school','comisions','itemsmasters'));
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'p_name' => 'required',
            'p_number' => 'required'
        ];
        if ($request->hasFile('image1')) {
            $rules['image1'] = 'mimes:jpeg,jpg,png,gif|required|max:2024';
        }
        if ($request->hasFile('image2')) {
            $rules['image2'] = 'mimes:jpeg,jpg,png,gif|required|max:2024';
        }
  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                if (isset($request->schoolid)) {
                    $school = School::find($request->schoolid);
                    $msg = "School updated successfully.";
                }else{
                    $school = new School;
                    $msg = "School added successfully.";
                }
                if ($request->hasFile('image1')) {
                    $destinationPath = public_path().'/company/employee';
                    $file = $request->image1;
                    $fileName1 = time().'.'.rand() . '.'.$file->clientExtension();
                    $file->move($destinationPath, $fileName1);
                    $school->p_image = $fileName1;
                }
                if ($request->hasFile('image2')) {
                    $destinationPath = public_path().'/company/employee';
                    $file = $request->image2;
                    $fileName2 = time().rand() . '.'.$file->clientExtension();
                    $file->move($destinationPath, $fileName2);
                    $school->o_image = $fileName2;
                }
                $school->name = $request->name;
                $school->p_birthdate = $request->p_birthdate;
                $school->s_anniversary = $request->s_anniversary;
                $school->address = $request->address;
                $school->city_id = $request->city_id;
                $school->p_name = $request->p_name;
                $school->p_number = $request->p_number;
                $school->o_number = $request->o_number;
                $school->o_name = $request->o_name;
                $school->school_code = $request->school_code;
                $school->total_students = $request->total_students;
                $school->save();

                StandardStrength::where('school_id',$school->id)->delete();
                
                if(!empty($request->strength)){
                    foreach ($request->strength as $standerd_id => $standarddata) {
                        $total = $standarddata['total'];
                        $boy = $standarddata['boy'];
                        $girl = $standarddata['girl'];
                        if(!empty($total)){
                            $ss = new StandardStrength;
                            $ss->school_id = $school->id;
                            $ss->standard_id = $standerd_id;
                            $ss->total = $total;
                            $ss->boys = $boy;
                            $ss->girls = $girl;
                            $ss->save();
                        }
                    }
                }

                $arr = array("status" => 200, "msg" => $msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $schools = School::find($id);
            if ($schools) {
                $schools->delete();
                $arr = array("status" => 200, "msg" => 'School deleted successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'School not found. please try again!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            $msg = 'You can not delete this as related data are there in system.';
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        } catch (Exception $ex) {
            $msg = 'You can not delete this as related data are there in system.';
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        }
        return \Response::json($arr);
    }
}
