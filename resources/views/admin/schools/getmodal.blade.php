<form  autocorrect="off" action="{{ route('admin.school.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit">
   {{ csrf_field() }}
   @if(isset($school) && !empty($school->id))
   <input type="hidden" name="schoolid" value="{{ $school->id }}">
   @endif
   <fieldset>
      <legend>
         Personal Info
      </legend>
      <div class="row">
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>School Name <span style="color: red">*</span></label>
               <input type="text" placeholder="Name" class="form-control" value="@if(!empty($school)){{ $school->name }}@endif" name="name" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>School Code<span style="color: red">*</span></label>
               <input type="text" placeholder="School Code" class="form-control" value="@if(!empty($school)){{ $school->school_code }}@endif" name="school_code" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>No. of Students<span style="color: red">*</span></label>
               <input type="number" placeholder="No. of Students" class="form-control" value="@if(!empty($school)){{ $school->total_students }}@endif" name="total_students" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Address<span style="color: red">*</span></label>
               <textarea class="form-control" placeholder="Address" name = "address" rows="1" required="">@if(!empty($school)){{ $school->address }}@endif</textarea>
            </div>
         </div>

         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>School Anniversary Date</label>
               <input type="date" placeholder="Date" class="form-control" value="@if(!empty($school)){{ $school->s_anniversary }}@endif" name="s_anniversary">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <div class="col-md-12 no-padding">
                  <label><i class="fa fa-map" aria-hidden="true"></i> {{ __('message.City') }} <span style="color: red;">*</span></label>
                  <select class="form-control cityselectwithstatecountry" name="city_id">
                     @if(!empty($school))
                     <option value="{{ $school->city->id }}" selected>{{ $school->city->name }}, {{ $school->city->state->name }}, {{ $school->city->state->country->name }}</option>
                     @endif
                  </select>
               </div>
            </div>
         </div>
      </div>
   </fieldset>
   <fieldset>
      <legend>
         Principal Info
      </legend>
      <div class="row">
         <div class="col-sm-12 col-md-6">
            <div class="form-group">
               <label>Name <span style="color: red">*</span></label>
               <input type="text" placeholder="Name" class="form-control" value="@if(!empty($school)){{ $school->p_name }}@endif" name="p_name" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-6">
            <div class="form-group">
               <label>Number<span style="color: red">*</span></label>
               <input type="text" placeholder="Number" class="form-control" value="@if(!empty($school)){{ $school->p_number }}@endif" name="p_number" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-6">
            <div class="form-group">
               <label>Birth Date</label>
               <input type="date" placeholder="Date" class="form-control" value="@if(!empty($school)){{ $school->p_birthdate }}@endif" name="p_birthdate">
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>Profile Image</label>
               <input type="file" name="image1" accept="image/*"
                  class="form-control logo_image" style="padding: 3px;" 
                  placeholder="Profile image">
            </div>
         </div>
         @php $image = url('public/company/employee/default.png'); @endphp
         @if(!empty($school) && file_exists(public_path().'/company/employee/'.$school->p_image) && !empty($school->p_image))
         @php $image = url('public/company/employee/'.$school->p_image);  @endphp
         @endif
         <div class="col-sm-12 col-md-2">
            <span style=""><img src="{{$image}}" class="image_preview profile-user-img" style="width: 80px;
               height: 78px;margin-top: 13px; margin-left: 10px;"></span>
         </div>
      </div>
   </fieldset>
    <fieldset>
      <legend>
         School Strength
      </legend>
      <input type="checkbox" name="is_checked" class="is_checked" value="1"> 60-40 ratio

  <table  class="schoostranth">
  <tr>
    <th>Item</th>
    <th>Total Strength</th>
    <th>Boys</th>
    <th>Girls</th>
  </tr>
  @if(!empty($standards))
  @foreach($standards as $standard)
  @if(isset($school) && !empty($school->id))
  <tr>
    <td>{{ $standard->name }}</td>
    <td><input type="number" min="1" name="strength[{{ $standard->id }}][total]" class="form-control changenumber totalstrength{{ $standard->id }}" value="{{ getvaluetotal($standard->id,$school->id,'total') }}" placeholder="Total" data-id="{{ $standard->id }}"></td>
    <td><input type="number" min="1" placeholder="Boys"  value="{{ getvaluetotal($standard->id,$school->id,'boys') }}" name="strength[{{ $standard->id }}][boy]" data-id="{{ $standard->id }}" class="form-control boyvalue boy{{ $standard->id }}"></td>
    <td><input type="number" min="1"  placeholder="Girls"  value="{{ getvaluetotal($standard->id,$school->id,'girls') }}"  name="strength[{{ $standard->id }}][girl]" data-id="{{ $standard->id }}" class="form-control girlvalue girl{{ $standard->id }}"></td>
  </tr>
  @else
  <tr>
    <td>{{ $standard->name }}</td>
    <td><input type="number" min="1" name="strength[{{ $standard->id }}][total]" class="form-control changenumber totalstrength{{ $standard->id }}"  placeholder="Total" data-id="{{ $standard->id }}"></td>
    <td><input type="number" min="1" data-id="{{ $standard->id }}"  placeholder="Boys" name="strength[{{ $standard->id }}][boy]" class="form-control boyvalue boy{{ $standard->id }}"></td>
    <td><input type="number" min="1" data-id="{{ $standard->id }}"  placeholder="Girls" name="strength[{{ $standard->id }}][girl]" class="form-control girlvalue  girl{{ $standard->id }}"></td>
  </tr>
   @endif
  @endforeach
  @endif
  
</table>
   </fieldset>
   <fieldset>
      <legend>
         Owner Info
      </legend>
      <div class="row">
         <div class="col-sm-12 col-md-3">
            <div class="form-group">
               <label>Name</label>
               <input type="text" placeholder="Name" class="form-control" value="@if(!empty($school)){{ $school->o_name }}@endif" name="o_name">
            </div>
         </div>
         <div class="col-sm-12 col-md-3">
            <div class="form-group">
               <label>Number</label>
               <input type="text" placeholder="Number" class="form-control" value="@if(!empty($school)){{ $school->o_number }}@endif" name="o_number">
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>Profile Image</label> 
               <input type="file" name="image2" accept="image/*"
                  class="form-control logo_image1" style="padding: 3px;" 
                  placeholder="Profile image">
            </div>
         </div>
         @php $image = url('public/company/employee/default.png'); @endphp
         @if(!empty($school) && file_exists(public_path().'/company/employee/'.$school->o_image) && !empty($school->o_image))
         @php $image = url('public/company/employee/'.$school->o_image);  @endphp
         @endif
         <div class="col-sm-12 col-md-2">
            <span style=""><img src="{{$image}}" class="image_preview1 profile-user-img" style="width: 80px;
               height: 78px;margin-top: 13px; margin-left: 10px;"></span>
         </div>
      </div>
   </fieldset>
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
      </div>
   </div>
   </div>
</form>