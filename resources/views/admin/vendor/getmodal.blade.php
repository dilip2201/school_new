<form  autocorrect="off" action="{{ route('admin.vendors.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit" enctype="multipart/form-data">
   {{ csrf_field() }}
   @if(isset($vendor) && !empty($vendor->id))
   <input type="hidden" name="vendorid" value="{{ $vendor->id }}">
   @endif
   <fieldset>
      <legend>
         Personal Info
      </legend>
      <div class="row">
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Owner name <span style="color: red">*</span></label>
               <input type="text" placeholder="Name" class="form-control" value="@if(!empty($vendor)){{ $vendor->name }}@endif" name="name" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Email<span style="color: red">*</span></label>
               <input type="email" placeholder="Email" class="form-control" value="@if(!empty($vendor)){{ $vendor->email }}@endif" name="email" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Company<span style="color: red">*</span></label>
               <input type="text" placeholder="Company Name" class="form-control" value="@if(!empty($vendor)){{ $vendor->company_name }}@endif" name="company_name" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Phone<span style="color: red">*</span></label>
               <input type="phone" placeholder="Phone" class="form-control mobile-number" value="@if(!empty($vendor)){{ $vendor->phone }}@endif" name="phone" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Whatsapp no.<span style="color: red">*</span></label>
               <input type="phone" placeholder="Whatsapp no." class="form-control mobile-number" value="@if(!empty($vendor)){{ $vendor->whatsapp_no }}@endif" name="whatsapp_no" required="">
            </div>
         </div>
         <div class="col-sm-12 col-md-4">
            <div class="form-group">
               <label>Address<span style="color: red">*</span></label>
                <textarea placeholder="Company Address..." class="form-control"  name="address" required="">@if(!empty($vendor)){{ $vendor->address }}@endif </textarea>
            </div>
         </div>


         <div class="col-md-4">
            <div class="form-group">
               <label>Profile Image</label>
               <input type="file" name="image" accept="image/*"
                  class="form-control logo_image1" style="padding: 3px;"
                  placeholder="Profile image">
            </div>
         </div>
         @php $image = url('public/company/vendor/default.png'); @endphp
         @if(!empty($vendor) && file_exists(public_path().'/company/vendor/'.$vendor->image) && !empty($vendor->image))
         @php $image = url('public/company/vendor/'.$vendor->image);  @endphp
         @endif
         <div class="col-sm-12 col-md-2">
            <span style=""><img src="{{$image}}" class="image_preview1 profile-user-img" style="width: 80px;
               height: 78px;margin-top: 13px; margin-left: 10px;"></span>
         </div>

      </div>
   </fieldset>

    <fieldset>
        <legend>
            Contact Person
        </legend>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" placeholder="Contact Person Name" class="form-control" value="@if(!empty($vendor)){{ $vendor->cp_name }}@endif" name="cp_name" >
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" placeholder="Designation" class="form-control" value="@if(!empty($vendor)){{ $vendor->cp_designation }}@endif" name="cp_designation" >
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="phone" placeholder="Contact Person Phone" class="form-control mobile-number" value="@if(!empty($vendor)){{ $vendor->cp_phone }}@endif" name="cp_phone" >
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Whatsapp no.</label>
                    <input type="phone" placeholder="Contact Person Whatsapp No." class="form-control mobile-number" value="@if(!empty($vendor)){{ $vendor->cp_whatsapp_no }}@endif" name="cp_whatsapp_no" >
                </div>
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
