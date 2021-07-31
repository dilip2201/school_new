
<style type="text/css">
    th, td {
  border: 1px solid #797979;
  border-collapse: collapse;
  padding: 10px;
  text-align: center;
}
</style>


   
   
   <div class="row">
      
      <div class="col-sm-12 col-md-12 loadfullhtml" style="margin-top: 20px; padding-bottom: 20px; max-height: 421px; overflow-y: scroll;">
         <table style="width:100%" class="itemdatatable">
            <thead>
           <tr>
             <th style="text-align: left;">Item Name</th>
             
             <th>Image</th> 
             <th>Action</th>
           </tr>
           </thead>
           <tbody>
            @if(!empty($item_masters))
            @foreach ($item_masters as $item_master)
             <tr>
             <td style="text-align: left;" >{{ $item_master->name }} ({{ $item_master->itemname->name ?? ''}})</td>
             @php $image = url('public/company/employee/shirt.png'); @endphp
             @if(!empty($item_master) && file_exists(public_path().'/thumbnail/'.$item_master->image) && !empty($item_master->image))
             @php $image = url('public/thumbnail/'.$item_master->image);  @endphp
             @endif

             <td><a class="clickzoom" href="{{ url('public/uniforms/'.$item_master->image)}}"><img src="{{$image}}"  class=" profile-user-img" style="border: 1px solid #adb5bd; width: 60px; height: 48px;"></a></td>

             <td><a title="Send to vendor" data-id="{{ $item_master->id }}" class="btn btn-info btn-sm sendtovendor" href="javascript:void(0)"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></td>
            </tr>
            @endforeach
            @endif
            </tbody>

           
         </table>

      </div>
   </div>   
   </div>
