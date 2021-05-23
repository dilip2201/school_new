<form  autocorrect="off" action="{{ route('admin.stocks.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit" enctype="multipart/form-data">
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
      
          <input type="hidden" class="item_id">
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
         <div class="col-sm-12">
              <div class="form-group">
                  <label><b>Default Quantity: </b>
                  </label>
                 <input type="number" placeholder="Default Quantity" class="form-control default_size">
              </div>
          </div>   
   </fieldset>
    <fieldset class="sizefieldset" style="display: none;">
      <legend>
         Sizes
      </legend>
      <div class="col-sm-12">
              <div class="form-group" style="margin-bottom: 0px;">
                <i  style="cursor: pointer; float: left; margin-top: 7px; color: green; font-size: 26px;" class="fa fa-plus-circle formdisplay" aria-hidden="true"></i>
                <div style="display: none;" class="formsubmitvalue">
                <input type="text" placeholder="size" class="form-control sizevalue" style=" margin-left: 10px; width: 50%; float: left;">
                 <i  style="cursor: pointer; float: left; margin-left: 5px; margin-top: 7px; color: green; font-size: 26px;" class="fa fa-check-circle submitvalue" aria-hidden="true"></i>
                 <i  style="cursor: pointer; display: none;    float: left;    margin-left: 5px;    margin-top: 13px;    color: green;    font-size: 15px;" class="fa fa-spinner fa-spin spinclass" aria-hidden="true"></i>
                </div>
              </div>
              <div class="form-group loadsize" style="width: 100%; float: left; margin-top: 15px;">
                
              </div>
          </div>

    </fieldset>
   </div>
  <div class="loadsize" style="display: none;">
      
           @if(!empty($sizes))
            @foreach($sizes as $size)
            <option value="{{ $size->id }}">{{ $size->size }}</option>
            @endforeach
           @endif
         </select>
  </div>
   <div class="col-md-8">
    <div class="addnewrow">
    </div>
   </div>
   </div>
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
      </div>
   </div>
   </div>
</form>