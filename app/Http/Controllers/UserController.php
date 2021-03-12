<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;   
class UserController extends Controller
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
        return view('admin.users.index');
    }


    /**
     * Get all the users
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {

        $users = User::orderby('id', 'desc')->where('id','!=',1);
        if (isset($request->status) && !empty($request->status)) {
            $users = $users->where('status',$request->status);
        }
        if (isset($request->role) && !empty($request->role)) {
            $users = $users->where('role',$request->role);
        }
        
        $users = $users->get();
        return DataTables::of($users)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                $return = '<a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> Edit</a>';
                /*if($q->role != 'super_admin'){
                 $return .= ' <a class="btn btn-danger btn-sm delete_record" data-id="'.$q->id.'" href="javascript:void(0)"> <i class="fas fa-trash"></i> Delete</a>';
                }*/
                return $return;
            })
            ->addColumn('image', function ($q) {
            $image = url('public/company/employee/default.png'); 
            if(file_exists(public_path().'/company/employee/'.$q->image) && !empty($q->image)) :
                $image = url('public/company/employee/'.$q->image); 
            endif;
            return '<img class="profile-user-img img-fluid img-circle" src="'.$image.'" style="width:50px; height:50px; border-radius:50%;">';
            }) 
            
            ->addColumn('name', function ($q) {
                return $q->name.' '.$q->lastname;
            })


            ->addColumn('email', function ($q) {
                return $q->email ?? $q->username;
            })
            ->addColumn('status', function ($q) {
                $id = encrypt($q->id);
                if ($q->status == 'active') {
                    return ' <a  class="badge badgesize badge-success right changestatus" data-status="inactive" data-id="' . $id . '" href="javascript:void(0)">' . ucwords($q->status) . '</a>';
                }
                if ($q->status == 'inactive') {
                    return '<a class="badge badgesize badge-danger right changestatus"  data-status="active"  data-id="' . $id . '" href="javascript:void(0)">' . ucwords($q->status) . '</a>';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['image','status', 'action'])->make(true);
    }


    /**
     * Change status of user active or inactive
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response send response in json
     */
    public function changestatus(Request $request)
    {

        try {
            $id = decrypt($request->id);
            $holiday = User::find($id);
            if ($holiday) {
                $holiday->update(['status' => $request->status]);
                $arr = array("status" => 200, "msg" => 'Holiday status change successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Holiday not found. please try again!');
            }

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


     /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {

        $user = array();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $user = User::where('id',$id)->first();

        }
        return view('admin.users.getmodal', compact('user'));
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
            'lastname' => 'required',
        ];
        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpeg,jpg,png,gif|required|max:2024';
        }
        if (isset($request->userid)) {
            $userid = decrypt($request->userid);
            $rules['username'] = 'required|unique:users,username,'.$userid;
        }else{
            $rules['username'] = 'required|unique:users,username';
            $rules['password'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                if (isset($userid)) {
                    $user = User::find($userid);
                    $msg = "User updated successfully.";
                }else{
                    $user = new User;
                    $msg = "User added successfully.";
                }
                if ($request->hasFile('image')) {
                    $destinationPath = public_path().'/company/employee';
                    $file = $request->image;
                    $fileName = time() . '.'.$file->clientExtension();
                    $file->move($destinationPath, $fileName);
                    $user->image = $fileName;
                }
                $user->name = $request->name;
                $user->lastname = $request->lastname;
                $user->username = $request->username;

                $user->role = 'user';
                if(!empty($request->password)){
                    $user->password = Hash::make($request->password);    
                }
                $user->save();
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
            $holiday = User::find($id);
            if ($holiday) {
                $holiday->delete();
                $arr = array("status" => 200, "msg" => 'User deleted successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'User not found. please try again!');
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
