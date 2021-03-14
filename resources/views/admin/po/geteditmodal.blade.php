<form  autocorrect="off" action="{{ route('admin.stocks.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit" enctype="multipart/form-data">
   {{ csrf_field() }}
   @if(isset($stock) && !empty($stock->id))
   <input type="hidden" name="stockid" value="{{ $stock->id }}">
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
               <input type="date" class="form-control" value="@if(!empty($stock)){{ date('Y-m-d',strtotime($stock->date)) }}@else{{ date('Y-m-d') }}@endif" name="date" required="">
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
                      <option value="{{ $item->id }}" @if(!empty($stock) && $stock->item->itemname->id == $item->id ) selected @endif>{{ $item->name }}</option>
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
                    @if(!empty($item_names))
                      @foreach($item_names as $item_name)
                        <option value="{{ $item_name->id }}" data-image="{{ $item_name->image }}" @if(!empty($stock) && $stock->item->id == $item_name->id ) selected @endif>{{ $item_name->name }}</option>
                      @endforeach
                    @endif
                  </select>
              </div>
          </div>
        
         <div class="col-md-12">
          <div class="form-group">
            <div class="loadimage" style="text-align: center;">
              @if(!empty($stock) && isset($stock->item->image))
              <img src="{{ url('public/uniforms/'.$stock->item->image) }}" style="width: auto; height: 240px; box-shadow: 7px 9px 9px -9px black;    border: 1px solid #ccc; max-width: 320px; border-radius: 10px;">
              @endif

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
                 <select class="form-control" name="size" required>
                   @if(!empty($sizes))
                    @foreach($sizes as $size)
                    <option value="{{ $size->id }}" @if(!empty($stock) && ($stock->itemsize->size == $size->size)) selected @endif>{{ $size->size }}</option>
                    @endforeach
                   @endif
                 </select>
              </div>
           </div>
           <div class="col-sm-3 col-md-3">
              <div class="form-group">
                 <label>Quantity <span style="color: red">*</span></label>
                 <input type="number" class="form-control" name="quantity" min="0" value="{{ $stock->quantity }}" max="100000"required>
              </div>
           </div>
           <div class="col-sm-7 col-md-7">
              <div class="form-group">
                 <label>Remark <span style="color: red">*</span></label>
                 <textarea class="form-control" name="remark" placeholder="Remark" required>{{ $stock->remark }}</textarea>
              </div>
           </div>
          </div>
    </fieldset>

    </div>
   </div>
   </div>
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Update <span class="spinner"></span></button>
      </div>
   </div>
   </div>
</form>