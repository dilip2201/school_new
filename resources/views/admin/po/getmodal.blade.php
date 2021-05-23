<form  autocorrect="off" action="{{ route('admin.po.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit" enctype="multipart/form-data">
   {{ csrf_field() }}
  
   
   <fieldset>
      <legend>
         PO info
      </legend>
      
        <div class="row">
         <div class="col-sm-3">
            <div class="form-group">

               <label>Date <span style="color: red">*</span></label>
               <input type="date" placeholder="Name" value="{{ date('Y-m-d')}}"  class="form-control" name="date" required="">
            </div>
         </div>
         <div class="col-sm-4">
              <div class="form-group">
                  <label><b>Vendor <span style="color: red">*</span></b>
                  </label>
                  <select class="form-control vendor" name="vendor" required="">
                      <option value="">Select Vendor</option>
                      @if(!empty($vendors))
                      @foreach($vendors as $vendor)
                      <option value="{{ $vendor->id }}">{{ $vendor->company_name }} ({{ $vendor->name }}) @if(!empty($vendor->whatsapp_no)) ({{ $vendor->whatsapp_no }}) @endif</option>
                      @endforeach
                      @endif
                  </select>
              </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <a  class="btn btn-primary importpo" data-toggle="modal" data-target=".import_stock" style="margin-top: 30px;    color: #fff;"> <i class="fa fa-upload" aria-hidden="true"></i> Import </a>
            </div>
          </div>
           
         </div>
         

   </fieldset>
   <div class="loadsize" style="display: none;">
     @if(!empty($stocks))
      @foreach($stocks as $stock)
      <option value="{{ $stock->id }}" data-image="{{ $stock->item->image }}" data-quntity="{{ $stock->quantity }}" class="disableremove dis{{ $stock->id }}" data-size="{{ $stock->itemsize->size }}">{{ $stock->item->name }}({{ $stock->item->itemname->name }}) ({{ $stock->itemsize->size }})({{ $stock->quantity }})</option>
      @endforeach
      @endif
   </div>
   <fieldset>
      <legend>
         Item Info
      </legend>
      <div class="row">
         <div class="col-sm-12">
          <table class="itemdata">
            <tr>
              <th>Item Name</th>
              <th style="text-align: center;">Image</th>
              <th style="text-align: center;">Size</th>
              <th>Quantity</th>
              <th>Delivery Expected Date</th>
              <th style="text-align: center;">Action</th>
            </tr>
             <tr class="removefirsttr">
                <td>
                  <select class="form-control selectitem" name="data[1][item_id]" data-id="1" required="">
                    <option value="">Select Item</option>
                    @if(!empty($stocks))
                    @foreach($stocks as $stock)
                    <option value="{{ $stock->id }}" data-image="{{ $stock->item->image }}" data-quntity="{{ $stock->quantity }}" class="disableremove dis{{ $stock->id }}" data-size="{{ $stock->itemsize->size }}">{{ $stock->item->name }}({{ $stock->item->itemname->name }})({{ $stock->itemsize->size }})({{ $stock->quantity }})</option>
                    @endforeach
                    @endif
                  </select>
                </td>
                <td  style="text-align: center;" class="image1"></td>
                <td style="text-align: center;" class="size1"></td>
                <td class="quantity1"></td>
                <td style="width: 100px;"><input type="date" class="form-control" name="data[1][expected]"></td>
                <td style="text-align: center;"><a class="addrow" style="cursor: pointer;"><i style="color: #208a05; font-size: 28px;" class="fa fa-plus-circle"></i></a></td>
            </tr>
          </table>
         </div>
       </div>
    </fieldset>

   
   <div class="col-md-12">
      <div class="form-group">
         <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
      </div>
   </div>
   
</form>