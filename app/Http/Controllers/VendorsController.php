<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use DataTables;
use Validator;
class VendorsController extends Controller
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
        return view('admin.vendor.index');
    }

    /**
     * Get all the users
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {

        $vendors = Vendor::orderby('id', 'desc')->get();
        return DataTables::of($vendors)
            ->addColumn('action', function ($q) {
                $id = $q->id;
                $return = '';
                $return .= '<a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> </a> <a title="Delete"  data-id="'.$id.'"   class="btn btn-danger btn-sm delete_record" href="javascript:void(0)"><i class="fas fa-trash"></i> </a>';
                return $return;
            })
            ->addColumn('image', function ($q) {
            $image = url('public/company/employee/default.png'); 
            if(file_exists(public_path().'/company/vendor/'.$q->image) && !empty($q->image)) :
                $image = url('public/company/vendor/'.$q->image); 
            endif;
            return '<img class="profile-user-img img-fluid" src="'.$image.'" style="width:50px; height:50px;">';
            }) 

            ->addColumn('name', function ($q) {
                return $q->name;
            })

            ->addColumn('email', function ($q) {
                return $q->email;
            })
            ->addColumn('whatsapp_number', function ($q) {
                return $q->phone;
            })
            ->addIndexColumn()
            ->rawColumns(['image','status', 'action'])->make(true);
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
            $vndor = Vendor::find($id);
            if ($vndor) {
                $vndor->delete();
                $arr = array("status" => 200, "msg" => 'Vendor deleted successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Vendor not found. please try again!');
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
        ];
        if ($request->hasFile('image1')) {
            $rules['image'] = 'mimes:jpeg,jpg,png,gif|required|max:2024';
        }
  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                if (isset($request->vendorid)) {
                    $vendor = Vendor::find($request->vendorid);
                    $msg = "Vendor updated successfully.";
                }else{
                    $vendor = new Vendor;
                    $msg = "Vendor added successfully.";
                }
                if ($request->hasFile('image')) {
                    $destinationPath = public_path().'/company/vendor';
                    $file = $request->image;
                    $fileName1 = time().'.'.rand() . '.'.$file->clientExtension();
                    $file->move($destinationPath, $fileName1);
                    $vendor->image = $fileName1;
                }
                $vendor->name = $request->name;
                $vendor->email = $request->email;
                $vendor->phone = str_replace(' ', '', $request->phone);
                $vendor->save();


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
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {
        $vendor = array();
        if (isset($request->id) && $request->id != '') {
            $id = $request->id;
            $vendor = Vendor::where('id',$id)->first();
        }
        
        return view('admin.vendor.getmodal', compact('vendor'));
    }

}
