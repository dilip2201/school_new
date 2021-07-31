 <table  class="table table-bordered table-hover importstcokkcheck" style="background: #fff; max-height: 500px; overflow-y: scroll;">
        <thead>
        <tr>
            <th><input type="checkbox" class="allcb"/></th>
            <th>Date</th>
            <th >Item</th>
            <th>Image</th>
            <th style="text-align: center;">Size</th>
            <th  style="text-align: center;">Qty</th>
            
        </tr>
        </thead>
        <tbody>
            @if(!empty($stocks))
            @foreach($stocks as $stock)
                <tr>
                    <td><input type="checkbox" class="cb1" value="{{ $stock->id }}" /></td>
                    <td>{{ date('d M Y',strtotime($stock->date)) }}</td>
                    <td>{{ $stock->item->itemname->name }} ({{ $stock->item->name }})</td>
                    <td><a class="showitem" href="{{ url('public/uniforms/'.$stock->item->image) }}"><img class="previewitem" src="{{ url('public/uniforms/'.$stock->item->image) }}" style="height:40px;width:40px;  "/></a></td>
                    <td>{{ $stock->itemsize->size }}</td>
                    <td>{{ $stock->quantity }}</td>
                    
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
<div class="form-group" style="float: right;">
<label style="width: 100%;">Expected Date :</label>
<input type="date" class="form-control expected_date" style="width: 70%; margin-right: 10px; float: left;">
<button class="btn btn-info  importstockcheckbox"> <i class="fa fa-upload" aria-hidden="true"></i> Import</button>
</div>