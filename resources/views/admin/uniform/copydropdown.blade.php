<div class="col-md-12" style="margin-top: 20px;">
    <div class="form-group">
       <label><b>Copy From :</b>
       </label>
       <select class="form-control copystandard" id="status" name="status">
            <option value="">Select Standard</option>
            @if(!empty($standerds))
            @foreach($standerds as $standerd)
            <option value="{{ $standerd->standard }}">{{ $standerd->standard }}</option>
            @endforeach
            @endif
            
           
       </select>
    </div>
 </div>
<div class="col-md-2">
  <button class="btn btn-success btn-sm copydatarecord" style="display: inline-flex; background: #f5af12; border:1px solid #000;" >Copy <span class="spinnercopy" style="margin-left: 5px;"> </span></button>
</div>