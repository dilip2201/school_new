
<style type="text/css">
    th, td {
  border: 1px solid #797979;
  border-collapse: collapse;
  padding: 10px;
  text-align: center;
}
</style>




   <div class="row">
      <div class="col-sm-12 col-md-4">
         <fieldset>
            <legend>
               Item Info
            </legend>
            <form  action="{{ route('admin.uniform.storeitem') }}"  enctype="multipart/form-data" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit">
               {{ csrf_field() }}
               <input type="hidden" name="itemid" class="itemid" value="">
               <div class="col-12">
                    <div class="form-group">
                        <label><b>Item : </b>
                        </label>
                        <select class="form-control item_id" name="item_id" required="">
                              @if(!empty($items))
                              @foreach($items as $item)
                              <option value="{{ $item->id }}"> {{ $item->name }}</option>
                              @endforeach
                              @endif
                        </select>
                    </div>
               </div>
               <div class="col-sm-12 col-md-12">
                  <div class="form-group">
                     <label>Item Name<span style="color: red">*</span></label>
                     <input type="text" placeholder="Item Name" class="form-control item_name" value="" name="item_name" required="">
                  </div>
               </div>
               <div class="col-sm-12 col-md-12">
                  <div class="form-group">
                     <label>Rack Number<span style="color: red">*</span></label>
                      <input type="text" placeholder="Rack Number" class="form-control rack_number" value="" name="ract_number" required="">
                  </div>
               </div>
                <div class="col-md-9" style="float: left;">
                    <div class="form-group">
                       <label>Item Image</label>
                       <input type="file" name="image" accept="image/*"
                          class="form-control logo_image" style="padding: 3px;"
                          placeholder="Profile image">
                    </div>
                 </div>
                <div class="col-sm-6 col-md-3" style="float: left;">
                  <span style=""><img src="{{ url('public/company/employee/shirt.png') }}" class="image_preview removeimage profile-user-img form-control image" style="width: 65px;
                     height: auto; border: 1px solid #adb5bd; "></span>
                </div>
                <div class="col-md-9" style="float: left;">
                    <div class="form-group">
                       <label>Back Image</label>
                       <input type="file" name="back_image" accept="image/*"
                          class="form-control back_image" style="padding: 3px;"
                          placeholder="Back image">
                    </div>
                 </div>
                <div class="col-sm-6 col-md-3" style="float: left;">
                  <span style=""><img src="{{ url('public/company/employee/shirt.png') }}" class="back_image_preview removeimage profile-user-img form-control image" style="width: 65px;
                     height: auto; border: 1px solid #adb5bd; "></span>
                </div>
                <div class="col-md-9" style="float: left;">
                    <div class="form-group">
                       <label>Mono Image</label>
                       <input type="file" name="mono_image" accept="image/*"
                          class="form-control mono_image" style="padding: 3px;"
                          placeholder="Mono image">
                    </div>
                 </div>
                 <div class="col-sm-6 col-md-3" style="float: left;">
                  <span style=""><img src="{{ url('public/company/employee/shirt.png') }}" class="mono_image_preview removeimage profile-user-img form-control image" style="width: 65px;
                     height: auto; border: 1px solid #adb5bd; "></span>
                </div>
               <div class="col-md-6" style="float: right;">
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinneritem"></span></button>
                  </div>
               </div>
            </form>

         </fieldset>
      </div>
      <div class="col-sm-12 col-md-8 loadfullhtml" style="margin-top: 20px; padding-bottom: 20px; max-height: 421px; overflow-y: scroll;">
         <table style="width:100%" class="itemdatatable">
            <thead>
           <tr>
             <th>Item Name</th>
             <th>Item Name</th>
             <th>Rack Number</th>
             <th>Image</th>
             <th>Action</th>
           </tr>
           </thead>
           <tbody>
            @if(!empty($item_masters))
            @foreach ($item_masters as $item_master)
             <tr>
             <td>{{ $item_master->itemname->name ?? ''}}</td>
             <td>{{ $item_master->name }}</td>
             <td>{{ $item_master->ract_number }}</td>
             @php $image = url('public/company/employee/shirt.png'); @endphp
             @if(!empty($item_master) && file_exists(public_path().'/thumbnail/'.$item_master->image) && !empty($item_master->image))
             @php $image = url('public/thumbnail/'.$item_master->image);  @endphp
             @endif
             @if((!empty($item_master) && $item_master->back_image != '') && file_exists(public_path().'/thumbnail/'.$item_master->back_image) && !empty($item_master->back_image))
             @php $backimage = url('public/thumbnail/'.$item_master->back_image);  @endphp
             @endif
             @if((!empty($item_master) && $item_master->mono_image != '') && file_exists(public_path().'/thumbnail/'.$item_master->mono_image) && !empty($item_master->mono_image))
             @php $monoimage = url('public/thumbnail/'.$item_master->mono_image);  @endphp
             @endif

                 <td><a class="clickzoom" href="{{ url('public/uniforms/'.$item_master->image)}}"><img src="{{$image}}"  class=" profile-user-img" style="border: 1px solid #adb5bd; width: 60px; height: 48px;"></a><a class="clickzoom" href="{{ url('public/uniforms/'.$item_master->back_image)}}"><img src="{{$backimage}}"  class=" profile-user-img" style="border: 1px solid #adb5bd; width: 60px; height: 48px;"></a><a class="clickzoom" href="{{ url('public/uniforms/'.$item_master->mono_image)}}"><img src="{{$monoimage}}"  class=" profile-user-img" style="border: 1px solid #adb5bd; width: 60px; height: 48px;"></a></td>

             <td><a title="Edit" class="btn btn-info btn-sm edititem" data-item_id = "{{ $item_master->item_id }}" data-mono-image="{{url('public/thumbnail/'.$item_master->mono_image)}}" data-back-image="{{url('public/thumbnail/'.$item_master->back_image)}}" data-image ="{{url('public/thumbnail/'.$item_master->image)}}" data-ract_number="{{ $item_master->ract_number }}" data-name="{{ $item_master->name }}" data-id="{{ $item_master->id }}" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> </a></td>
            </tr>
            @endforeach
            @endif
            </tbody>


         </table>

      </div>
   </div>
   </div>
