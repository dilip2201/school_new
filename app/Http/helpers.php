<?php
use App\User;
use Mail as MailUser;
use App\Uniform;
use App\ItemMaster;
use App\School;
/************************** Dilip Functions ***********************************/

function activeMenu($uri = '') {
    $active = '';
    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
        $active = 'active';
    }
    return $active;
}

/************************** Dilip Functions end ***********************************/

function getitemsofitem($itemid){
  $item_sizes = \DB::table('item_masters')->where('item_id',$itemid)->get();
  return $item_sizes;
}

function getvaluetotal($standardid, $schoolid, $type){
  $strength = \DB::table('standard_strength')->where('standard_id',$standardid)->where('school_id',$schoolid)->first();
  if(!empty($strength)){
    return $strength->$type;
  }else{
    return '';
  }

}

function getvaluetotalin($standardid, $schoolid, $type){
  $strength = \DB::table('standard_strength')->where('standard_id',$standardid)->where('school_id',$schoolid)->first();
  if(!empty($strength)){
    return $strength->$type;
  }else{
    return 0;
  }

}


/************************** Sonal Functions ***********************************/
/**
 * @param $permissions
 * @return bool
 * Added by Sonal Ramdatti
 */
function begin()
{
    \DB::beginTransaction();
}

function commit()
{
    \DB::commit();
}

function rollback()
{
    \DB::rollBack();
}
/**
 * For check permission
 */
function checkPermission($permissions)
{
    if (auth()->check()) {
        $userAccess = auth()->user()->role;
        foreach ($permissions as $key => $value) {
            if ($value == $userAccess) {
                return true;
            }
        }
        return false;
    } else {
        return false;
    }
}



/************************** dhruv Functions ***********************************/
/************************************** Get Content of language *****************************/
function getcontentof($languageid, $contentid)
{

    $return = '';
    $content = \App\LanguageText::where([['language_id', $languageid], ['content_id', $contentid]])->first();
    if (!empty($content)) {
        $return = $content->text;
    }
    return $return;
}
function Getlanguages()
{
    $branchs = \App\Language::where([['activated', '1'], ['status', 'active']])->orwhere('id', 1)->get();
    return $branchs;
}
/************************** dhruv Functions end ***********************************/
function getimagesof($itemid,$school,$gender,$season,$standard){
  $uniforms = Uniform::with('itemname')->where('school_id',$school)->where('gender',$gender)->where('season',$season)->where('standard',$standard)->where('item_id',$itemid)->get();
  return $uniforms;
}

function getschoolname($schoolid){
  $school = School::where('id',$schoolid)->first();
  if(!empty($school)){
    return $school->name;  
  }
  
}
function getstdname($stdid){
  $std = \DB::table('standards')->where('id',$stdid)->first();
  if(!empty($std)){    
  return $std->name;
  }
}

function getvalueofitemsize($school_id,$gender,$season,$standard,$item_id){
  $uniforms = \DB::table('item_size')->where('school_id',$school_id)->where('gender',$gender)->where('season',$season)->where('standard',$standard)->where('item_id',$item_id)->first();
  return $uniforms;

}


function getvalueofuniform($school_id,$gender,$season,$standard,$item_id){
  $uniforms = Uniform::with('itemname')->where('school_id',$school_id)->where('gender',$gender)->where('season',$season)->where('standard',$standard)->where('item_id',$item_id);

  $totaluniform = $uniforms->count();
  $finalunit = $uniforms->get();

  
  $return = array();
  if($totaluniform > 0){
    $total = 5 - $totaluniform;
    $startfrom = $totaluniform + 1;
    $i = 1;
    foreach ($finalunit as $uniform) {
      $single_text = null;
      if(!empty($uniform->itemname->name)){
        $single_text = $uniform->itemname->name.' ('.$uniform->itemname->ract_number.')';
      }

      $single_textimage = null;
      if(!empty($uniform->itemname->name)){
        $single_textimage = $uniform->itemname->image;
      }
      $array[$i] = array('id'=>$uniform->id,'single_text'=>$single_text,'itemid'=>$uniform->single_text,'file'=>$single_textimage,'remarks'=>$uniform->remarks);
      $i++;
    }
    for ($newuni=$startfrom; $newuni <= 5 ; $newuni++) { 
      $array[$newuni] = array();
    }

  } else{
    for ($uni=1; $uni <= 5 ; $uni++) { 
      $array[$uni] = array();
    }
  }
  return $array;

}
function getitemname($itemid) {

 $item = ItemMaster::with('itemname')->where('item_id',$itemid)->first();

if(isset($item->item_id)){
   $itemname = $item->itemname->name;
}else{
   $itemname = NULL;
}
return $itemname;

}

