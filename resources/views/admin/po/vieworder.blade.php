<div class="row">
  

<div class="col-md-3">
   <!-- Profile Image -->
   <div class="card card-primary card-outline" style="border: 1px solid #9a9a9a!important;">
      <div class="card-body box-profile">
         <div class="text-center">
            @php
            $image = url('public/company/employee/default.png'); 
            if(file_exists(public_path().'/company/vendor/'.$po->vendor->image) && !empty($po->vendor->image)) :
            $image = url('public/company/vendor/'.$po->vendor->image); 
            endif;
            @endphp
            <img class="profile-user-img img-fluid img-circle" style="height: 100px;" src="{{ $image }}" alt="User profile picture">
         </div>
         <h3 class="profile-username text-center" style="font-size: 14px; margin-top: 15px; margin-bottom: 0px!important;">{{ $po->vendor->name }} - {{ $po->vendor->company_name ?? '' }}</h3>
         <p class="text-muted text-center"><i class="fa fa-whatsapp" style="color: green;"></i> {{ $po->vendor->whatsapp_no }}</p>
         <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
               <b><i class="fa fa-envelope"></i> Email</b> <a class="float-right">{{ $po->vendor->email }}</a>
            </li>
            <li class="list-group-item">
               <b><i class="fa fa-calendar"></i> PO Date </b> <a class="float-right">{{ date('M d, Y',strtotime($po->date)) }}</a>
            </li>
            <li class="list-group-item">
               <b><i class="fa fa-circle"></i> PO Number </b> <a class="float-right">{{ $po->po_number }}</a>
            </li>
         </ul>
      </div>
      <!-- /.card-body -->
   </div>
   <!-- /.card -->           
</div>
<div class="col-md-9">
   <table class="itemdata">
      <tbody>
         <tr>
            <th>Item Name</th>
            <th style="text-align: center;">Image</th>
            <th style="text-align: center;">Size</th>
            <th>Quantity</th>
            <th>Delivery Expected Date</th>
            
         </tr>
          @if(!empty($po->stocks))
            @foreach($po->stocks as $stock)
         <tr>
            <td> {{ $stock->item->name }} ({{ $stock->item->itemname->name}})</td>
            <td style="text-align:center;"><a class="showitem" href="{{ url('public/uniforms/'.$stock->item->image)  }}"><img src="{{ url('public/uniforms/'.$stock->item->image) }}" style="width: 50px;"></td>
            <td >{{ getsize($stock->size) }}</td>
            <td >{{ $stock->quantity }} </td>
            <td >@if(!empty($stock->expected_date)) {{ date('d M Y',strtotime($stock->expected_date)) }} @else N/A @endif</td>
            
         </tr>
            @endforeach
          @endif
            
      </tbody>
   </table>
   <p class="loadsentstatus" style="margin-top: 10px; margin-bottom: 0px;">@if($po->send_count == 0)
      You have not sent this order to vendor.
      @else
      You have sent this order to vendor {{ $po->send_count }} times.
      @endif
       </p>
   <button data-id="{{ $po->id }}" class="btn btn-info btn-sm mt-15 sendtovendor" style="margin-top: 15px; "><i class="fa fa-whatsapp"></i> Send PO to vendor <span class="whatsappspinner"></span></button> <button data-id="{{ $po->id }}" class="btn btn-danger btn-sm mt-15 caclestock" style="margin-top: 15px; "><i class="fa fa-times"></i> Cancle PO </button>
</div>
</div>