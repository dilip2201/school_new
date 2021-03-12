<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uniform;
use App\ItemMaster;

class ReportsController extends Controller
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
    	$items = \DB::table('items')->orderby('id','asc')->get();
    	$item_masters = \DB::table('item_masters')->orderby('id','asc')->get();
        return view('admin.reports.index',compact('items','item_masters'));
    }

    public function changedrop(Request $request)
    {
    	
    	$item_masters = \DB::table('item_masters')->where('item_id',$request->id)->get();
    	$return = '';

    	if(!empty($item_masters)){
    		foreach ($item_masters as $item_master) {
    			$return .= '<option value="'.$item_master->id.'">'.$item_master->name.'</option>';
    		}
    	}
        return  $return;
    }

    
    public function loadreport(Request $request)
    {
    	$item_master = $request->item_master;
        $item = ItemMaster::where('id',$item_master)->first();	
    	$uniforms = Uniform::where('single_text',$item_master)->get();
    	$return = array();
    	if(!empty($uniforms)){
    		foreach ($uniforms as $uniform) {
    			$return[$uniform->school_id][$uniform->standard][$uniform->gender] = 1;
    		}
    	}
    	/*echo '<pre>';
    	print_r($return);
    	exit;*/
        return view('admin.reports.tablelisting',compact('return','item'));
    }
}
