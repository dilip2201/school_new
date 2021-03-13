<form  autocorrect="off" action="{{ route('admin.vendors.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit" enctype="multipart/form-data">
   {{ csrf_field() }}
   @if(isset($vendor) && !empty($vendor->id))
   <input type="hidden" name="vendorid" value="{{ $vendor->id }}">
   @endif
   <div class="row">
   <div class="col-md-4" >
   <fieldset>
      <legend>
         Stock Info
      </legend>
      
        
         <div class="col-sm-12 ">
            <div class="form-group">
               <label>Date <span style="color: red">*</span></label>
               <input type="date" placeholder="Name" class="form-control" value="@if(!empty($stock)){{ date('Y-m-d',strtotime($stock->date)) }}@else{{ date('Y-m-d') }}@endif" name="date" required="">
            </div>
         </div>
         <div class="col-sm-12">
              <div class="form-group">
                  <label><b>Item category:  <span style="color: red">*</span></b>
                  </label>
                  <select class="form-control status" id="status" name="item_categories" required="">
                      <option value="">Select Item</option>
                      @if(!empty($items))
                      @foreach($items as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                      @endif
                  </select>
              </div>
          </div>
         <div class="col-sm-12">
              <div class="form-group">
                  <label><b>Item Name:  <span style="color: red">*</span></b>
                  </label>
                  <select class="form-control  item_masters" id="item_name" name="item_name" required>
                  </select>
              </div>
          </div>
        
         <div class="col-md-12">
          <div class="form-group">
            <div class="loadimage" style="text-align: center;">
            </div>
          </div>
         </div>     
   </fieldset>
   </div>
  
   <div class="col-md-8">
     <fieldset>
        <legend>
           Quntity Info
        </legend>
        
           <div class="col-sm-12 col-md-4">
              <div class="form-group">
                 <label>Date <span style="color: red">*</span></label>
                 <input type="date" placeholder="Name" class="form-control" value="@if(!empty($stock)){{ date('Y-m-d',strtotime($stock->date)) }}@else{{ date('Y-m-d') }}@endif" name="date" required="">
              </div>
           </div>
      
    </fieldset>
   </div>
   </div>
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
      </div>
   </div>
   </div>
</form>