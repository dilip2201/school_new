<form  autocorrect="off" action="{{ route('admin.stocks.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit" enctype="multipart/form-data">
   {{ csrf_field() }}
   @if(isset($vendor) && !empty($vendor->id))
   <input type="hidden" name="vendorid" value="{{ $vendor->id }}">
   @endif
   
   <fieldset>
      <legend>
         PO info
      </legend>
      
        <div class="row">
         <div class="col-sm-3">
            <div class="form-group">
               <label>Date <span style="color: red">*</span></label>
               <input type="date" placeholder="Name" class="form-control" name="date" required="">
            </div>
         </div>
         <div class="col-sm-3">
              <div class="form-group">
                  <label><b>Vendor <span style="color: red">*</span></b>
                  </label>
                  <select class="form-control vendor" name="vendor" required="">
                      <option value="">Select Vendor</option>
                      @if(!empty($vendors))
                      @foreach($vendors as $vendor)
                      <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                      @endforeach
                      @endif
                  </select>
              </div>
          </div>
       
        
         <div class="col-md-12">
          <div class="form-group">
            <div class="loadimage" style="text-align: center;">
            </div>
          </div>
         </div>  
         </div>
         

   </fieldset>
   <fieldset>
      <legend>
         Item Info
      </legend>
    </fieldset>

   
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
      </div>
   </div>
   
</form>