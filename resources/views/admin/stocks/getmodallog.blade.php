<form  autocorrect="off" action="{{ route('admin.stocks.storelog') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmitlog">
   {{ csrf_field() }}

   <div class="row">
  
    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
    <div class="col-sm-12">
         <div class="form-group">
            <label>Status  <span style="color: red">*</span></label>
            <select class="form-control" name="status">
                @if($stock->status == 'ordered')
                <option value="ordered" @if($stock->status == 'ordered') selected @endif>Ordered</option>
                @endif
                @if($stock->status == 'ordered' || $stock->status == 'dispatched')
                <option value="dispatched" @if($stock->status == 'dispatched') selected @endif>Dispatched</option>
                @endif
                @if($stock->status == 'ordered' || $stock->status == 'dispatched' || $stock->status == 'delivered')
                <option value="delivered" @if($stock->status == 'delivered') selected @endif>Delivered</option>
                @endif
                @if($stock->status == 'ordered' || $stock->status == 'dispatched' || $stock->status == 'partially_delivered')
                <option value="partially_delivered" @if($stock->status == 'partially_delivered') selected @endif>Partially Delivered</option>
                @endif

                @if($stock->status == 'ordered' || $stock->status == 'dispatched' || $stock->status == 'delivered' || $stock->status == 'partially_delivered' || $stock->status == 'cancelled')
                <option value="cancelled" @if($stock->status == 'cancelled') selected @endif>Cancelled</option>
                @endif
            </select>
            
         </div>
      </div>
        <input type="hidden" class="form-control" name="old_qty" value="{{ $stock->pending_quantity }}" required>
    <div class="col-sm-12">
         <div class="form-group">
            <label>Pending Quantity<span style="color: red">*</span></label>
           <input type="text" class="form-control" name="pending_qunatity" value="{{ $stock->pending_quantity }}" required>
         </div>
      </div>      
    <div class="col-sm-12">
         <div class="form-group">
            <label>Remarks  <span style="color: red">*</span></label>
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