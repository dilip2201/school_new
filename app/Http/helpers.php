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
function getsize($sizeid){
  $size = \DB::table('uniform_sizes')->where('id',$sizeid)->first();
  $return = 0; 
  if(!empty($size)){
      $return = $size->size;
  }
  return $return;
}

function sortByOrder($a, $b) {
    return $a['size'] - $b['size'];
}

function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }
  
function timeAgo($time_ago)
{
  $time_ago = strtotime($time_ago);
  $cur_time = time();
  $time_elapsed = $cur_time - $time_ago;
  $seconds = $time_elapsed ;
  $minutes = round($time_elapsed / 60 );
  $hours = round($time_elapsed / 3600);
  $days = round($time_elapsed / 86400 );
  $weeks = round($time_elapsed / 604800);
  $months = round($time_elapsed / 2600640 );
  $years = round($time_elapsed / 31207680 );
// Seconds
    if($seconds <= 60){
    return "just now";
    }
//Minutes
    else if($minutes <=60){
    if($minutes==1){
    return "one minute ago";
    }
    else{
    return "$minutes minutes ago";
    }
    }
//Hours
    else if($hours <=24){
    if($hours==1){
    return "an hour ago";
    }else{
    return "$hours hrs ago";
    }
    }
//Days
    else if($days <= 7){
    if($days==1){
    return "yesterday";
    }else{
    return date('d M Y',$time_ago);
    }
    }

    else{
  return date('d M Y',$time_ago);
}
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

