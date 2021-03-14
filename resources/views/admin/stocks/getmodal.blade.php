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
     <fieldset>
        <legend>
           Quntity Info
        </legend>
          <div class="row">
           <div class="col-sm-2 col-md-2">
              <div class="form-group">
                 <label>Size <span style="color: red">*</span></label>
                 <select class="form-control" name="stock[1][size]" required>
                   @if(!empty($sizes))
                    @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                    @endforeach
                   @endif
                 </select>
              </div>
           </div>
           <div class="col-sm-3 col-md-3">
              <div class="form-group">
                 <label>Quantity <span style="color: red">*</span></label>
                 <input type="number" class="form-control" name="stock[1][quantity]" min="0" max="100000"required>
              </div>
           </div>
           <div class="col-sm-7 col-md-7">
              <div class="form-group">
                 <label>Remark <span style="color: red">*</span></label>
                 <textarea class="form-control" name="stock[1][remark]" placeholder="Remark" required></textarea>
              </div>
           </div>
          </div>
    </fieldset>

    </div>
    <a class="btn btn-info addrow" style="color:#fff;"><i class="fa fa-plus"></i> Add new</a> <i class="fa fa-info-circle" style="cursor: pointer;" data-toggle="tooltip" title="By Clicking on add new button, it will add new quantity row."></i>
   </div>
   </div>
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
      </div>
   </div>
   </div>
</form>