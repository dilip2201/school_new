<div class="col-sm-12" style="padding: 0px;">
<div class="items-collection">
   @if(!empty($sizes))
    @foreach($sizes as $size)
    <div class="items addrow" data-sizeid="{{ $size->id }}" data-size="{{ $size->size }}">
        <div class="info-block block-info clearfix">
            <div class="btn-group">
                <label class="btn btn-default itemselected itemselected{{ $size->id }}" style="border-radius: 15px;">
                    <div class="itemcontent">
                        <h5 style="margin-bottom: 0px; font-size: 14px;">{{ $size->size }} </h5>
                    </div>
                </label>
                @if(count($size->sizeobj) == 0)
                <i class="fa fa-trash deletesize" data-id="{{ $size->id }}" style="color: red;cursor: pointer;"></i>
                @endif
            </div>
        </div>
    </div>
    @endforeach
   @endif

   @if(count($sizes) == 0)
   <span> No size available.</span>
   @endif
    
      
</div>
</div>