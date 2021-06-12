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
        
         <div class="col-md-12 col-sm-12" >
         <fieldset >
            <legend>Upcoming deliveries</legend>
            <table class="table table-bordered table-hover datableload"  style="width:100%">
              <thead>
                  <tr>
                        
                        <th >Item</th>
                        <th>Image</th>
                        <th style="text-align: center;">Vendor</th>
                        <th>PO No.</th>
                        <th style="width: 50px;">Expected Date</th>
                        <th style="text-align: center;">Size</th>
                        <th  style="text-align: center;">Qty</th>
                        <th  style="text-align: center;">Pending Qty</th>
                        
                        <th>Status</th>
                        
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

                      <td>{{ $stock->item->itemname->name }} ({{ $stock->item->name}})</td>
                      <td><a class="showitem" href="{{ url('public/uniforms/'.$stock->item->image) }}"><img class="previewitem" src="{{ url('public/uniforms/'.$stock->item->image) }}" style="height:70px;width:70px;  "/></a></td>
                      <td>{{ $stock->vendor->name ?? 'N/A' }}</td>
                      <td>@if(!empty($stock->po->po_number))
                        <a title="View PO"  data-id="{{ $stock->po->po_number }}"   data-toggle="modal" data-target=".vieworder" class="openedviewmodal vieworderclick" href="javascript:void(0)">{{ $stock->po->po_number }} </a>
                        @else
                        {{ 'N/A' }}
                        @endif
                      </td>
                      <td>{{ $stock->expected_date ?? 'N/A' }}</td>
                      <td>{{ $stock->itemsize->size ?? 'N/A' }}</td>
                      <td>{{ $stock->quantity ?? 'N/A' }}</td>
                      <td>{{ $stock->pending_quantity ?? 'N/A' }}</td>
                      <td>{!! $status !!} </td>
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