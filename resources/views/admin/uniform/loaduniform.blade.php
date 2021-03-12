<div class="masterdiv">
    @if(!empty($items))
      @foreach($items as $item)
      <div class="itemlable">
        <span>{{ $item->name }}</span>
      </div>
      @php
      
      $sizevalue = getvalueofitemsize($school_id,$gender,$season,$standard,$item->id);
      
      @endphp
      <div class="item_size">
        <span class="sizechange" data-id="{{ $item->id }}">@if(!empty($sizevalue)){{ $sizevalue->size}}@else X @endif</span>
        <input type="text" class="displayitem{{ $item->id }} focusitem" data-id="{{ $item->id }}" style="display: none; margin-top: 60px; width: 100%; text-align: center;" value="@if(!empty($sizevalue)){{ $sizevalue->size}}@endif" placeholder="X">
      </div>
      @php
      $values = getvalueofuniform($school_id,$gender,$season,$standard,$item->id);

      @endphp
      @foreach($values as $array => $data)

      @php
      $uploadimage = url('public/uploadsample.png');
      $remarktext = '';
      $single_text = '';
      $itemid = 0;
      $updateid = '';
      $lblsingle_text = 'Click to add Name';
      $lblremarktext = 'Click to add Remarks';
      if(!empty($data['file'])){
        $uploadimage = url('public/thumbnail/'.$data['file']);
      }
      if(!empty($data['remarks'])){
        $remarktext = $data['remarks'];
        $lblremarktext = $data['remarks'];
      }
      if(!empty($data['single_text'])){
        $single_text = $data['single_text'];
        $lblsingle_text = $data['single_text'];
      }
      if(!empty($data['id'])){
        $updateid = $data['id'];
      }
      if(!empty($data['itemid'])){
        $itemid = $data['itemid'];
      }
      
      @endphp
      <div class="first">
        <input type="hidden" class="selectvalue{{ $array }}{{ $item->id }}" value="{{ $updateid }}">
        
        <div class="imagepart" >
          <img src="{{ $uploadimage }}" data-type="{{ $array }}" data-id="{{ $item->id }}" class="imageclick preview{{ $array }}{{ $item->id }}" >
          <input type="file" class="imageUpload openfile{{ $array }}{{ $item->id }}" data-type="{{ $array }}" data-id="{{ $item->id }}" style="display: none;" />
        </div>
        
        <div class="labelpart lablename{{ $array }}{{ $item->id }}" data-type="{{ $array }}" data-id="{{ $item->id }}" >{{ $lblsingle_text }}</div>

        <select style="display: none; width: 100%;" class="focuschangedropdown displayname{{ $array }}{{ $item->id }}" data-type="{{ $array }}" id="displayname{{ $array }}{{ $item->id }}"  data-id="{{ $item->id }}" data-field="single_text">
          <option value="" >Select Item</option> 
          @php $itemmasters = getitemsofitem($item->id);  @endphp

          @if(!empty($itemmasters))
          @foreach($itemmasters as $item_size)
          <option value="{{ $item_size->id }}" @if($itemid == $item_size->id) selected @endif>{{ $item_size->name }} ({{$item_size->ract_number}})</option>
          @endforeach
          @endif
        </select>

        
        <div class="remark remarklable{{ $array }}{{ $item->id }}"  data-type="{{ $array }}" data-id="{{ $item->id }}">{{ $lblremarktext }}</div>
        <input type="text" class="focuschange remarktext displayremark{{ $array }}{{ $item->id }}" data-type="{{ $array }}" data-id="{{ $item->id }}" data-field="remark" value="{{ $remarktext }}"  style="display: none;" value="" placeholder="Remarks">
        @if(!empty($updateid))
        <span class="deleteicon" data-type="{{ $array }}" data-deleteid="{{ $updateid }}" data-id="{{ $item->id }}" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></span>
        @endif
      </div>
      @endforeach


    
      @endforeach
    @endif
</div>
  