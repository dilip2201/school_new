<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Uniform;
use App\ItemSize;
use App\ItemMaster;
use Image;
use App\Item;
use Illuminate\Validation\Rule;
class UniformController extends Controller
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
    	$schools = \DB::table('schools')->get();
    	
        return view('admin.uniform.index',compact('schools'));
    }

    
    public function delete(Request $request)
    {
       
        \DB::table('uniforms')->where('id',$request->deleteid)->delete();
        $arr = array("status" => 200, "msg" => "Successfully deleted", "result" => array());
        return \Response::json($arr);  
    }

    public function loafcopydropdown(Request $request)
    {
       
        $school_id = $request->school;
        $gender = $request->gender;
        $season = $request->season;
        $standard = $request->standard;
        $standerds = \DB::table('uniforms')->select('standard')->where('school_id',$school_id)->where('gender',$gender)->where('season',$season)->where('standard','!=',$standard)->groupBy('standard')->get();
       return view('admin.uniform.copydropdown',compact('standerds'));
    }

    public function copyfinal(Request $request)
    {
        
       
        $school_id = $request->school;

        $gender = $request->gender;
        $season = $request->season;
        $standard = $request->standard;

        $tostandard = $request->tostandard; 
        $togender = $request->togender;
        $toseason = $request->toseason;

        $standerds = \DB::table('uniforms')->where('school_id',$school_id)->where('gender',$gender)->where('season',$season)->where('standard',$standard)->get();
        $itemsizes = \DB::table('item_size')->where('school_id',$school_id)->where('gender',$gender)->where('season',$season)->where('standard',$standard)->get();

        if(!empty($standerds)){
            \DB::table('uniforms')->where('school_id',$school_id)->where('gender',$togender)->where('season',$toseason)->where('standard',$tostandard)->delete();

            \DB::table('item_size')->where('school_id',$school_id)->where('gender',$togender)->where('season',$toseason)->where('standard',$tostandard)->delete();

            foreach ($standerds as $finalstanderd) {
                
                $uni = Uniform::find($finalstanderd->id);
                $new = $uni->replicate();
                $new->standard = $tostandard;
                $new->gender = $togender;
                $new->season = $toseason;
                
                $new->save();
            }
                if(!empty($itemsizes)){
                    foreach ($itemsizes as $itemsize) {
                    $item = ItemSize::find($itemsize->id);
                    $newitem = $item->replicate();
                    $newitem->standard = $tostandard;
                    $newitem->gender = $togender;
                    $newitem->season = $toseason;
                    $newitem->save();
                }
            }
            $arr = array("status" => 200, "msg" => "Successfully Copied.", "result" => array());
        }else{
            $arr = array("status" => 400, "msg" => "No uniforms found.", "result" => array());
        }

       return \Response::json($arr);  
    }
    
    public function getmodal(Request $request)
    {
       
        $items = Item::orderby('id','asc')->get();
        $item_masters = ItemMaster::orderby('id','desc')->get();
        return view('admin.uniform.getmodal',compact('item_masters','items'));
    }

    public function getmodalsmall(Request $request)
    {
       
        $items = Item::orderby('id','asc')->get();
        $item_masters = ItemMaster::orderby('id','desc')->get();
        return view('admin.uniform.getmodalsmall',compact('item_masters','items'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function submituniform(Request $request)
    {
        
        $rules = [
            'label' => 'required',
            'remark' => 'required',
            'school' => 'required',
            'gender' => 'required',
            'season' => 'required',
            'standard' => 'required',
        ];
        if ($request->file == '') {
            if($request->selectvalue == ''){
                $arr = array("status" => 400, "msg" => "Please upload image", "result" => array());
                return \Response::json($arr);    
            }
            
        } 
        
  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {

                $itemsize = Uniform::where('school_id',$request->school)->where('gender',$request->gender)->where('standard',$request->standard)->where('season',$request->season)->where('item_id',$request->item_id)->first();
                if(empty($itemsize)){
                    $uniform = new Uniform;
                }else{
                    $uniform = Uniform::find($itemsize->id);
                    
                }
                if ($request->hasFile('file')) {
                    $destinationPath = public_path().'/uniforms/';
                    $file = $request->file;
                    $fileName1 = time().rand().'.'.$file->clientExtension();
                    $file->move($destinationPath, $fileName1);
                    $uniform->file = $fileName1;
                }
                
                $uniform->school_id = $request->school;
                $uniform->gender = $request->gender;
                $uniform->season = $request->season;
                $uniform->standard = $request->standard;
                $uniform->item_id = $request->item_id;
                $uniform->single_text = $request->label;
                $uniform->remarks = $request->remark;
                $uniform->save();

                $arr = array("status" => 200, "msg" => 'Success!');
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
   

    
    public function savetext(Request $request)
    {
        
        try {


            if($request->selectvalue ==''){
                if(!empty($request->textvalue)){
                    $uniform = new Uniform; 
                    $uniform->school_id = $request->school;
                    $uniform->gender = $request->gender;
                    $uniform->season = $request->season;
                    $uniform->standard = $request->standard;
                    $uniform->item_id = $request->item_id;
                    if($request->field == 'single_text'){
                        $uniform->single_text = $request->textvalue;
                    }
                    if($request->field == 'remark'){
                        $uniform->remarks = $request->textvalue;
                    }
                    $uniform->save();
                }
            }else{
                $uniform = Uniform::find($request->selectvalue);
                $uniform->school_id = $request->school;
                $uniform->gender = $request->gender;
                $uniform->season = $request->season;
                $uniform->standard = $request->standard;
                $uniform->item_id = $request->item_id;
                if($request->field == 'single_text'){
                    $uniform->single_text = $request->textvalue;
                }
                if($request->field == 'remark'){
                    $uniform->remarks = $request->textvalue;
                }
                $uniform->save();
            }
            

            $arr = array("status" => 200, "msg" => 'Success!');
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
       

        return \Response::json($arr);
    }

    public function savesize(Request $request)
    {
        try {
            $itemsize = ItemSize::where('school_id',$request->school)->where('gender',$request->gender)->where('standard',$request->standard)->where('season',$request->season)->where('item_id',$request->item_id)->first();
            
            if(!empty($itemsize)){
                if($request->textvalue == ''){
                    ItemSize::find($itemsize->id)->delete();
                    $arr = array("status" => 200, "msg" => 'Success!');
                    return \Response::json($arr);
                }
            }

            if($request->textvalue != ''){
                if(empty($itemsize)){
                    $uniform = new ItemSize;
                }else{
                    $uniform = ItemSize::find($itemsize->id);
                }
                $uniform->school_id = $request->school;
                $uniform->gender = $request->gender;
                $uniform->season = $request->season;
                $uniform->standard = $request->standard;
                $uniform->item_id = $request->item_id;
                $uniform->size = $request->textvalue;
                $uniform->save();
            }

            $arr = array("status" => 200, "msg" => 'Success!');
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
       

        return \Response::json($arr);
    }
    public function saveimage(Request $request)
    {
        
        
        if ($request->file == '') {
            if($request->selectvalue == ''){
                $arr = array("status" => 400, "msg" => "Please upload image", "result" => array());
                return \Response::json($arr);    
            }
            
        } 
        try {
            if($request->selectvalue ==''){
                $uniform = new Uniform;    
            }else{
                $uniform = Uniform::find($request->selectvalue);
            }
            
            if ($request->hasFile('file')) {
                $destinationPath = public_path().'/uniforms/';
                $thumbnailPath = public_path().'/thumbnail/';
                $file = $request->file;
                $thumbnailImage = Image::make($file);


                $fileName1 = time().rand().'.'.$file->clientExtension();
                $thumbnailImage->resize(120, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbnailImage->save($thumbnailPath.$fileName1);

                $file->move($destinationPath, $fileName1);
                $uniform->file = $fileName1;
            }
            
            $uniform->school_id = $request->school;
            $uniform->gender = $request->gender;
            $uniform->season = $request->season;
            $uniform->standard = $request->standard;
            $uniform->item_id = $request->item_id;
            $uniform->save();

            $arr = array("status" => 200, "msg" => 'Success!');
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
       

        return \Response::json($arr);
    }
    public function loaduniform(Request $request){
        $items = \DB::table('items')->orderby('id','asc')->get();
        $item_sizes = \DB::table('item_masters')->get();
        $school_id = $request->school;
        $gender = $request->gender;
        $season = $request->season;
        $standard = $request->standard;
        return view('admin.uniform.loaduniform',compact('items','school_id','gender','season','standard','item_sizes'));   
    }

    public function storeitem(Request $request){
       
        $item_id = $request->item_id;
        $item_name = $request->item_name;
        $rules = [
            'image' => 'mimes:jpeg,jpg,png',

        ];        
        if ($request->image == '') {
            if($request->itemid == ''){
                $arr = array("status" => 400, "msg" => "Please upload Item Image.", "result" => array());
                return \Response::json($arr);    
            }
            
        } 
        
  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {

           try {


                $itemcount = \DB::table('item_masters')->where('item_id',$item_id)->where('name',$item_name);
                if(!empty($request->itemid)){
                    $itemcount = $itemcount->where('id','<>',$request->itemid);
                }
                $itemcount = $itemcount->count();
                if($itemcount > 0){
                   $arr = array("status" => 400, "msg" => "Item name is already taken.", "result" => array());
                   return \Response::json($arr); 
                }
                if(empty($request->itemid)){
                    $itemmaster = new ItemMaster;
                }else{
                    $itemmaster = ItemMaster::find($request->itemid);
                }

                if ($request->hasFile('image')) {
                    $destinationPath = public_path().'/uniforms/';
                    $thumbnailPath = public_path().'/thumbnail/';
                    $file = $request->image;
                    $thumbnailImage = Image::make($file);
                     $thumbnailImage->resize(120, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $fileName1 = time().rand().'.'.$file->clientExtension();
                    $thumbnailImage->save($thumbnailPath.$fileName1);


                    $file->move($destinationPath, $fileName1);
                    $itemmaster->image = $fileName1;
                }
                $itemmaster->name = $request->item_name;
                $itemmaster->item_id = $request->item_id;
                $itemmaster->ract_number = $request->ract_number;
                $itemmaster->save();

                $items = ItemMaster::with('itemname')->orderby('id','desc')->get();

                $return = '<table style="width:100%" class="itemdatatable">
               <thead>
               <tr>
                 <th>Item Name</th>
                 <th>Item Name</th>
                 <th>Rack Number</th> 
                 <th>Image</th>
                 
                 <th>Action</th>
               </tr>
               </thead>';
               $return .= '<tbody>';
                if(!empty($items)){
                    foreach ($items as $item_master){
                        $image = url('public/company/employee/shirt.png'); 
                        if(!empty($item_master) && file_exists(public_path().'/thumbnail/'.$item_master->image) && !empty($item_master->image)){
                               $image = url('public/thumbnail/'.$item_master->image);
                        }
                    


                        $return .= '<tr>
                                    <td>'.getitemname($item_master->item_id).'</td>
                                    <td>'.$item_master->name.'</td>
                                    <td>'.$item_master->ract_number.'</td>
                                    <td><img src="'.$image.'" class="profile-user-img" style="border: 1px solid #adb5bd; width: 60px; height: 48px;"></span></td>
                                    <td><a title="Edit" class="btn btn-info btn-sm edititem" 
                                    data-item_id="'.$item_master->item_id.'" data-ract_number="'.$item_master->ract_number.'" data-name="'.$item_master->name.'"  data-image ="'.url('public/thumbnail/'.$item_master->image).'"  data-id="'.$item_master->id.'" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> </a></td>
                                    </tr>';
                    }
                }
                if(empty($items)){
                    $return .= '<tr>
                                <td colspan="4">No Item found.</td>
                                </tr>';
                }
                $return .= '</tbody>';
                $return .=  '</table>';     
                $arr = array("status" => 200, "msg" => 'Success!','html'=>$return);
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

    
}
