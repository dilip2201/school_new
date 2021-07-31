@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Board')
<style type="text/css">
.multiselectclass .btn-group{
    width: 100%!important;
 }
 .multiselectclass .btn-default{
    border-color: #aaa!important;
 }
 .multiselectclass .multiselect{
    text-align: left;
 }
  .multiselect-container>li>a>label{
    padding: 3px 15px 3px 15px;
 }
 .schoostranth{
    width: 100%;
 }
 .schoostranth td, .schoostranth th {
  border: 1px solid #000;
  padding: 8px;
}
.itemdata td, .itemdata th{
     border: 1px solid #000;
     padding: 10px;
}
.itemdata{
    width: 100%;
}
button.multiselect.dropdown-toggle.btn.btn-default{
    text-align: left;
}

fieldset{
    background-color: #fff!important;
}

.table td{
        padding: 5px 10px!important;
}
 .statusbtn {
     padding: 0 5px;
     font-size:12px;
 }
 .displaynone{
    display: none;
 }
 tr{
    font-size: 14px;

 }
 .dataTables_info{
    font-size: 14px;
 }
.select2-selection__choice{
    color: black !important;
}
.btn-group{
    width:100% !important;
}
.multiselect-container{
    width: 100% !important;
}
.items-collection {
    width: 100%;
}
.items {
    display: inline-block;
}
.items-collection .btn-group {
    width: 100%;
}
.items-collection label.btn-default {
    width: 90%;
    border: 1px solid #305891;
    margin: 5px;
    border-radius: 17px;
    color: #305891;
}
.btn-group>.btn:first-child {
    margin-left: 0;
}
.items-collection label.btn-default.active {
    background-color: #007ba7;
    color: #FFF;
}
</style>
<div class="container" style="max-width: 95%; margin-top: 15px;">
    <!-- Info boxes -->

    <div class="row">
        
         <div class="col-md-6 col-sm-6" >
         <fieldset >
            <legend>Upcoming deliveries</legend>
            <table class="table table-bordered table-hover datableload"  style="width:100%">
              <thead>
                  <tr>
                        
                        <th style="width: 120px">Item</th>
                        <th style="text-align: center;">Vendor</th>
                        <th style="width: 50px;">Expected Date</th>
                        <th style="text-align: center;">Type</th>
                        <th style="text-align: center;">Action</th>
                        
                        
                        
                        
                        </tr>
              </thead>
              <tbody>
                  @if(!empty($stocks))
                  @foreach($stocks as $stock)
                  @php

                  if($stock->status == 'pending'){
                    $status = '<button type="button" class="btn btn-warning statusbtn">Pending</button>';
                    } else if($stock->status == 'ordered'){
                        $status = '<button type="button" class="btn btn-primary statusbtn">Ordered</button>';
                    } else if($stock->status == 'dispatched'){
                        $status = '<button type="button" class="btn btn-info statusbtn">Dispatched</button>';
                    } else if($stock->status == 'delivered'){
                        $status = '<button type="button" class="btn btn-success statusbtn">Delivered</button>';
                    } else if($stock->status == 'partially_delivered'){
                        $status = '<button type="button" class="btn btn-warning statusbtn">Partially Delivered</button>';
                    } else if($stock->status == 'cancelled'){
                        $status = '<button type="button" class="btn btn-danger statusbtn">Cancelled</button>';
                    }
                  @endphp
                
                  <tr>

                      <td style="text-align: center; "><a class="showitem" href="{{ url('public/uniforms/'.$stock->item->image) }}"><img class="previewitem" src="{{ url('public/uniforms/'.$stock->item->image) }}" style="height:50px;width:50px;  "/></a> <br>{{ $stock->item->itemname->name }} ({{ $stock->item->name}})</td>
                      
                      <td>Vendor : {{ $stock->vendor->name ?? 'N/A' }} <br>
                      PO : @if(!empty($stock->po->po_number))
                        <a title="View PO"  data-id="{{ $stock->po->po_number }}"   data-toggle="modal" data-target=".vieworder" class="openedviewmodal vieworderclick" href="javascript:void(0)">{{ $stock->po->po_number }} </a>
                        @else
                        {{ 'N/A' }}
                        @endif </td>
                     
                      <td>{{ $stock->expected_date ?? 'N/A' }} <br> {!! $status !!}</td>
                      <td>Size : {{ $stock->itemsize->size ?? 'N/A' }} <br>
                        Qty : {{ $stock->quantity ?? 'N/A' }} <br> 
                        Pending Qty : {{ $stock->pending_quantity ?? 'N/A' }}</td>
                        <td><a title="Change Status" data-id="{{ $stock->id }}" data-toggle="modal" data-target=".add_log" class="btn btn-info btn-sm openaddmodallog" href="javascript:void(0)"><i class="fa fa-plus"></i></a></td>
                      
                  </tr>
                  @endforeach
                  @endif
                  
               </tbody>
            </table>
         </fieldset>
      </div>
      <div class="col-md-6 col-sm-6" >
         <fieldset >
            <legend>Reminders</legend>
            <table class="table table-bordered table-hover datableload"  style="width:100%">
              <thead>
                  <tr>
                        
                        <th style="width: 120px">Item</th>
                        <th style="text-align: center;">Type</th>
                        <th>Reminder</th>
                        <th style="width: 50px;">Status</th>
                        
                        
                        
                        
                        </tr>
              </thead>
              <tbody>
                  @if(!empty($reminders))
                  @foreach($reminders as $stock)
                  @php

                  if($stock->status == 'pending'){
                    $status = '<button type="button" class="btn btn-warning statusbtn">Pending</button>';
                    } else if($stock->status == 'ordered'){
                        $status = '<button type="button" class="btn btn-primary statusbtn">Ordered</button>';
                    } else if($stock->status == 'dispatched'){
                        $status = '<button type="button" class="btn btn-info statusbtn">Dispatched</button>';
                    } else if($stock->status == 'delivered'){
                        $status = '<button type="button" class="btn btn-success statusbtn">Delivered</button>';
                    } else if($stock->status == 'partially_delivered'){
                        $status = '<button type="button" class="btn btn-warning statusbtn">Partially Delivered</button>';
                    } else if($stock->status == 'cancelled'){
                        $status = '<button type="button" class="btn btn-danger statusbtn">Cancelled</button>';
                    }
                  @endphp
                  @php if(!empty($stock->reminder_date)){
                      $rem = date('d M Y',strtotime($stock->reminder_date)).' '.$stock->reminder_time.'<br>'.$stock->reminder_remarks;
                  }else{
                      $rem = '-';
                  } @endphp
                  <tr>

                      <td style="text-align: center; "><a class="showitem" href="{{ url('public/uniforms/'.$stock->item->image) }}"><img class="previewitem" src="{{ url('public/uniforms/'.$stock->item->image) }}" style="height:50px;width:50px;  "/></a> <br>{{ $stock->item->itemname->name }} ({{ $stock->item->name}})</td>
                      
                   
                     
                      <td>Size : {{ $stock->itemsize->size ?? 'N/A' }} <br>
                        Qty : {{ $stock->quantity ?? 'N/A' }} <br> 
                        Pending Qty : {{ $stock->pending_quantity ?? 'N/A' }}</td>
                        <td>{!! $rem !!}</td>
                      <td>{!! $status !!}</td>
                      
                  </tr>
                  @endforeach
                  @endif
                  
               </tbody>
            </table>
         </fieldset>
      </div>
    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
<div class="modal fade add_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Large Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body addholidaybody">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade add_log" >
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title">Order Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body logbody">
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<div class="modal fade vieworder" style="z-index: 1042;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content " >
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Large Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body vieworderbody">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@push('links')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css" integrity="sha512-4a1cMhe/aUH16AEYAveWIJFFyebDjy5LQXr/J/08dc0btKQynlrwcmLrij0Hje8EWF6ToHCEAllhvGYaZqm+OA==" crossorigin="anonymous" />
@endpush
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js" integrity="sha512-+m6t3R87+6LdtYiCzRhC5+E0l4VQ9qIT1H9+t1wmHkMJvvUQNI5MKKb7b08WL4Kgp9K0IBgHDSLCRJk05cFUYg==" crossorigin="anonymous"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
     $(function () {
        $(".datableload").DataTable({
        });
        $('.showitem').magnificPopup({
              type: 'image',
              zoom: {
                  enabled: true,
                  duration: 300 // don't foget to change the duration also in CSS
              }
          });
        $('body').on('change', '.changestatus', function (e) {
                var status = $(this).val();
                $('.rcvqtydisply').css('display','block');
                $('.remarkdisply').css('display','block');
                if(status == 'delivered'){
                    $('.rcvqtydisply').css('display','none');
                    $('.remarkdisply').css('display','block');
                }
                if(status == 'dispatched'){
                    $('.rcvqtydisply').css('display','none');
                    
                }
                if(status == 'cancelled'){
                    $('.rcvqtydisply').css('display','none');
                    
                }
                if(status == ''){
                    $('.rcvqtydisply').css('display','none');
                    $('.remarkdisply').css('display','none');
                }
                if(status == 'partially_delivered'){
                    $('.expectdisply').css('display','block');
                }else{
                    $('.expectdisply').css('display','none');
                }


            });

         $('body').on('submit', '.formsubmitlog', function (e) {
                   e.preventDefault();
                   $.ajax({
                       url: $(this).attr('action'),
                       data: new FormData(this),
                       type: 'POST',
                       contentType: false,
                       cache: false,
                       processData: false,
                       beforeSend: function () {
                           $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
                       },
                       success: function (data) {

                           if (data.status == 400) {
                               $('.spinner').html('');
                               toastr.error(data.msg)
                           }
                           if (data.status == 200) {
                               $('.spinner').html('');
                               $('.add_log').modal('hide');
                               location.reload();
                               toastr.success(data.msg,'Success!')
                           }
                       },
                   });
               });
        $('body').on('click', '.openaddmodallog', function () {
           var id = $(this).data('id');

           $.ajax({
               url: "{{ route('admin.stocks.addlog')}}",
               type: 'POST',
               headers: {
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               data: {id: id},
               success: function (data) {
                   $('.logbody').html(data);


               },
           });
       });
        $('body').on('click','.vieworderclick',function(){
            var id = $(this).data('id');


            $('.modal-title').text('View PO');

            $.ajax({
                url: "{{ route('admin.po.vieworder')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.vieworderbody').html(data);
                    /******** cityselectwithstatecountry dropdown **********/
                    $('.showitem').magnificPopup({
                        type: 'image',
                        zoom: {
                            enabled: true,
                            duration: 300 // don't foget to change the duration also in CSS
                        }
                    });
                },
            });
        })
    });
    </script>
@endpush
@endsection