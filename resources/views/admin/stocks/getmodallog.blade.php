<form  autocorrect="off" action="{{ route('admin.stocks.storelog') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmitlog">
   {{ csrf_field() }}

   <div class="row">
  
    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
    <div class="col-sm-12">
         <div class="form-group">
            <label>Status  <span style="color: red">*</span></label>
            <select class="form-control changestatus" name="status" required>
                <option value="" >Select Item</option>
                @if($stock->status == 'ordered')
                <option value="dispatched" >Dispatched</option>
                @endif
                @if($stock->status == 'ordered' || $stock->status == 'dispatched' || $stock->status == 'delivered' || $stock->status == 'partially_delivered')
                <option value="delivered" >Delivered</option>
                @endif
                @if($stock->status == 'ordered' || $stock->status == 'dispatched' || $stock->status == 'partially_delivered')
                <option value="partially_delivered" >Partially Delivered</option>
                @endif

                @if($stock->status == 'ordered' || $stock->status == 'dispatched' || $stock->status == 'delivered' || $stock->status == 'partially_delivered' || $stock->status == 'cancelled')
                <option value="cancelled" >Cancelled</option>
                @endif
            </select>
            
         </div>
      </div>
        
    <div class="col-sm-12 rcvqtydisply" style="display: none;">
         <div class="form-group">
            <label>Received Quantity<span style="color: red">*</span></label>
           <input type="number" min="0" class="form-control" name="received_qty">
         </div>
      </div> 
       <div class="col-sm-12 expectdisply" style="display: none;">
         <div class="form-group">
            <label>Expected Date<span style="color: red">*</span></label>
           <input type="date" value="@if(!empty($stock->expected_date)){{ date('Y-m-d',strtotime($stock->expected_date))}}@endif" class="form-control" name="expected_date">
         </div>
      </div>       
    <div class="col-sm-12 remarkdisply"  style="display: none;">
         <div class="form-group">
            <label>Remarks </label>
            <textarea class="form-control" name="remark"  rows="3"  placeholder="Enter Remarks" ></textarea>
         </div>
      </div>
 
      

      <div class="col-md-12">
         <div class="form-group">
            <button type="submit" class="btn btn-primary  pull-right"> Submit <span class="spinner"></span></button>
         </div>
      </div>
   </div>
</form>