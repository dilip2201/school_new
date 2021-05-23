@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Ordered Stock Items')
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
    <div class="row" style="margin-top: 20px">

        <div class="col-12">
            
            <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-filter"></i> Click to Filter
            </button>
            </p>
            <div class="collapse" id="collapseExample">
                    <div class="card card-info card-outline displaybl">
                        <div class="card-body" style="padding: 10px 15px;">
                            <form action="{{ route('admin.stocks.export') }}" method="POST">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="form-group row " style="margin-bottom: 0px;">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label style="font-size: 14px;"><b>Start Date: </b>
                                                </label>
                                                <input type="date" class="form-control" name="start_date" id="start_date"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label style="font-size: 14px;"><b>End Date: </b>
                                                </label>
                                                <input type="date" name="end_date" class="form-control" id="end_date"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 item_master" >
                                            <div class="form-group">
                                                <label style="font-size: 14px;"><b>Vendor: </b>
                                                </label>
                                                <select class="form-control vendor_id" id="vendor_id" name="vendor_id">
                                                    <option value="">
                                                        Select Vendor
                                                    </option>
                                                    @if(!empty($vendors))
                                                        @foreach($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}">
                                                                {{ $vendor->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 item_master" >
                                            <div class="form-group">
                                                <label style="font-size: 14px;"><b>Status: </b>
                                                </label><br>
                                                <select class="form-control  stockstatus" id="stockstatus" multiple="multiple" name="status[]">
                                                    <option value="pending" >
                                                        Pending
                                                    </option>
                                                    <option value="ordered" selected>
                                                        Ordered
                                                    </option>
                                                    <option value="dispatched">
                                                        Dispatched
                                                    </option>
                                                    <option value="delivered">
                                                        Delivered
                                                    </option>
                                                    <option value="partially_delivered" selected>
                                                        Partially Delivered
                                                    </option>
                                                    <option value="cancelled">
                                                        Cancelled
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <div class="form-group">
                                                <label style="font-size: 14px;"><b>Export: </b>
                                                </label>
                                                <select class="form-control" id="exportto"  name="exportto">
                                                    <option value="excel" selected>
                                                        Excel
                                                    </option>
                                                    <option value="pdf">
                                                        PDF
                                                    </option>
                                                    <option value="png">
                                                        PNG
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 ml-3" style="padding-left: 0px;">
                                        <button type="button" class="btn btn-success btn-sm searchdata"
                                                style="padding: 6px 16px;"><i class="fa fa-search"></i>  Search
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm ml-1"
                                                style="padding: 6px 15px;"><i class="fa fa-download"></i> Download
                                        </button>
                                        <a href="{{ url('admin/stocks') }}" class="btn btn-danger btn-sm ml-1"
                                                style="padding: 6px 15px;"><i class="fa fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
            </div>
            <div class="loadcount">


            </div>
            <!-- /.col -->
        </div>

    </div>
    <div class="row">
        <div class="col-12">

            <div class="card  card-outline">

                <div class="card-body">
                    <!-- /.card-header -->
                    <table id="stocks" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 50px;">Item</th>
                            <th>Image</th>
                            <th style="text-align: center;">Vendor</th>
                            <th>PO No.</th>
                            <th>Date</th>
                            <th style="width: 50px;">Expected Date</th>
                            <th style="text-align: center;">Size</th>
                            <th  style="text-align: center;">Qty</th>
                            <th  style="text-align: center;">Pending Qty</th>
                            <th>remark</th>
                            <th>Status</th>
                            <th style="width:100px; ">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!-- /.card-body -->
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
<div class="modal fade add_modal" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content " >
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


<div class="modal fade edit_modal" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content " >
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Large Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body editmodel">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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

<div class="modal fade history_log" >
   <div class="modal-dialog  modal-lg">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title"><i class="fa fa-history" aria-hidden="true"></i> History</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body historylog">
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div id="thumbsParentContainer" class="clearfix" style="min-height: 150px; clear: both"></div>

@push('links')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="{{ URL::asset('public/js/intlTelInput.css') }}" />
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css" integrity="sha512-4a1cMhe/aUH16AEYAveWIJFFyebDjy5LQXr/J/08dc0btKQynlrwcmLrij0Hje8EWF6ToHCEAllhvGYaZqm+OA==" crossorigin="anonymous" />
@endpush

@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/intlTelInput.js') }}"></script>
 <!-- Magnific Popup core JS file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js" integrity="sha512-+m6t3R87+6LdtYiCzRhC5+E0l4VQ9qIT1H9+t1wmHkMJvvUQNI5MKKb7b08WL4Kgp9K0IBgHDSLCRJk05cFUYg==" crossorigin="anonymous"></script>
    <script>
         function generaterandomnumber() {

              var rendomnumber = Math.floor((Math.random() * 1000000) + 1);
              return rendomnumber;
            }
        /************** display image preview **********/
         function readURL(input, classes) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.' + classes).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
          $('.select2').select2();
        /******* display city image **********/
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "{{ URL::asset('public/admin/images/flags') }}";
            var $state = $(
                '<span><img src="' + baseUrl + '/' + state.contryflage.toLowerCase() + '.png"  class="img-flag" /> ' + state.text + '</span>'
            );
            return $state;
        }
        /************* image preview**********/
        $('body').on('change', '.logo_image', function() {
            readURL(this, 'image_preview');
        });
        /************** image preview **********/
        $('body').on('change', '.logo_image1', function() {
            readURL(this, 'image_preview1');
        });
        /************** Datatable **********/
        $('body').on('keyup change','.changenumber',function(){
            if($('.is_checked').is(":checked")){
                var id = $(this).data('id');
                var totalvalue = $(this).val();
                var boys = (totalvalue*60)/100;
                var girls = (totalvalue*40)/100;
                $('.boy'+id).val(Math.round(boys));
                $('.girl'+id).val(Math.round(girls));
            }
        });

        function unique(array){
            return array.filter(function(el, index, arr) {
                return index === arr.indexOf(el);
            });
        }

            function loadsizes(item_id){
                $.ajax({
                        url: "{{ route('admin.stocks.loadsize')}}",
                        type: 'POST',
                        data:{item_id:item_id},
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            $('.loadsize').html(data);
                            $('.dddsizevalue').each(function() { 
                                if($(this).val() != ''){
                                    var id = parseInt($(this).val()); 
                                    
                                    $('.itemselected'+id).addClass('active');
                                }
                            });

                        },
                    });
            }
         function getSelectedValues() {
             var selectedVal = $("#multiselect").val();
             for(var i=0; i<selectedVal.length; i++){
                 function innerFunc(i) {
                     setTimeout(function() {
                         location.href = selectedVal[i];
                     }, i*2000);
                 }
                 innerFunc(i);
             }
         }

         function selecteditem(size){

         }
        $(function () {
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

            $('body').on('click','.deletesize',function(){
                var id = $(this).data('id');

                (new PNotify({
                title: "Confirmation Needed",
                text: "Are you sure you wants to delete?",
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                },
                addclass: 'stack-modal',
                stack: {
                    'dir1': 'down',
                    'dir2': 'right',
                    'modal': true
                }
            })).get().on('pnotify.confirm', function () {
                $.ajax({
                    url: '{{ url("admin/stocks/") }}/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        if (data.status == 400) {
                            toastr.error(data.msg, 'Oh No!');
                        }
                        if (data.status == 200) {
                            toastr.success(data.msg, 'Success!');
                             var item_id = $('.item_id').val();
                            loadsizes(item_id);
                            $('.removeitem'+id).remove();
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
            });
            })
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
                               $('#stocks').DataTable().ajax.reload();
                               toastr.success(data.msg,'Success!')
                           }
                       },
                   });
               });

            $('body').on('click','.formdisplay',function(){
                $('.sizevalue').val('');
                $('.formsubmitvalue').toggle('displaynone');
            })

            $('body').on('click','.submitvalue',function(){
                var size = $('.sizevalue').val();
                var item_id = $('.item_id').val();
                
                if(size == ''){
                    toastr.error('Size field is required.','Error!')
                }else{
                    $.ajax({
                        url: "{{ route('admin.stocks.addsize')}}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {size: size,item_id:item_id},
                        beforeSend:function(){
                            $('.spinclass').css('display','block')
                        },
                        success: function (data) {


                            $('.spinclass').css('display','none')
                            if (data.status == 400) {
                                toastr.error(data.msg)
                            }
                            if (data.status == 200) {
                                $('.sizevalue').val('');
                                $('.size').val('');
                                loadsizes(item_id);
                            }


                        },
                    });
                    
                }
            })
            $('.vendor_id').select2();
            $('.stockstatus').multiselect({
                buttonWidth : '160px',
                includeSelectAllOption : true,
                nonSelectedText: 'Select an Option'
            });
            /* datatable */
            var table = $("#stocks").DataTable({
                "responsive": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                stateSave: true,
                // columnDefs: [
                //     { width: 180, targets:  4},
                //     { width: 50, targets:  0},
                //     { width: 180, targets:  2},
                //     { width: 50, targets:  3},
                // ],
                ajax: {
                    'url': "{{ route('admin.stocks.getall') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('.stockstatus').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.vendor_id = $('#vendor_id').val();
                    }
                },
                columns: [
                    {data: 'id','orderable' : false},
                    {data: 'item_id','orderable' : false},
                    {data: 'image','orderable' : false},
                    {data: 'vendor_id'},
                    {data: 'po_number','orderable' : false},
                    {data: 'date'},
                    {data: 'expected_date'},
                    {data: 'size','orderable' : false},
                    {data: 'quantity'},
                    {data: 'pending_quantity','orderable' : false},
                    {data: 'remark','orderable' : false},
                    {data: 'status','orderable' : false},
                    {data: 'action','orderable' : false},
                ],
                drawCallback: () => {
                    $('.showitem').magnificPopup({
                        type: 'image',
                        zoom: {
                            enabled: true,
                            duration: 300 // don't foget to change the duration also in CSS
                        }
                    });
                }
            });
            /* Search records by filter */
            $('body').on('click','.searchdata',function(){
                table.ajax.reload();
            });
        });
        $('body').on('change','.status',function(){
            $('.addnewrow').html('');
            var id = $(this).val();
            if(id != ''){
                $('.sizefieldset').css('display','block');
                $('.item_id').val(id);
                $.ajax({
                    url: "{{ route('admin.reports.changedropvalue')}}",
                    type: 'POST',
                    data:{id:id},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        $('.item_masters').html(data);
                        $('.item_masters').select2();
                        $('.loadimage').html('');
                        loadsizes(id);
                    },
                });
            }else{
                $('.sizefieldset').css('display','none');
            }
        });
        $('body').on('change','.item_masters',function(){
            var item_id = $(this).val();
            if(item_id != ''){

                var image = $(this).find(':selected').data('image');
                var url = "{{ url('public/uniforms/')}}/"+image;
                $('.loadimage').html(`<img src="`+url+`" style="width: auto; height: 240px; box-shadow: 7px 9px 9px -9px black;    border: 1px solid #ccc; max-width: 320px; border-radius: 10px;">`);
            }else{
                $('.loadimage').html('');
            }
        });
        /********* add new School ********/
        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text('Add Stock');
            } else {
                $('.modal-title').text('Edit Vendor');
            }
            $.ajax({
                url: "{{ route('admin.stocks.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.addholidaybody').html(data);
                    /******** cityselectwithstatecountry dropdown **********/
                    $('[data-toggle="tooltip"]').tooltip();
                    $(".mobile-number").intlTelInput({
                        onlyCountries: ['in'],
                    });
                    $('.status').select2();


                },
            });
        });

        $('body').on('click', '.openedtmodal', function () {
            var id = $(this).data('id');

                $('.modal-title').text('Edit Stock');

            $.ajax({
                url: "{{ route('admin.stocks.editmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.editmodel').html(data);
                    $('.status').select2();
                    /******** cityselectwithstatecountry dropdown **********/

                },
            });
        });

        $('body').on('click','.removerowvisa',function(){
            var id = $(this).data('id');
            $('.removeitem'+id).remove();
            $('.itemselected'+id).removeClass('active');
        })
        $('body').on('click','.addrow',function(){

        rendomnumber = generaterandomnumber();
        //var options = $('.loadsize').get(0).outerHTML;
        var default_size = $('.default_size').val();
        var sizedrop = $(this).data('sizeid');
        var size = $(this).data('size');

        var ek=[];

        $('.dddsizevalue').each(function() { 
            if($(this).val() != ''){
                ek.push(parseInt($(this).val())); 
            }
        });
        var ek = unique(ek);
        if($.inArray(sizedrop, ek) > -1){
            $('.itemselected'+sizedrop).removeClass('active');
            $('.removeitem'+sizedrop).remove();
        }else{

            var html = `<fieldset class="removeitem`+sizedrop+` remove`+rendomnumber+`">
            <legend>
               Quntity Info <i class="fa fa-trash removerowvisa" data-id="`+sizedrop+`" style="color:red; cursor:pointer;"></i>
            </legend>
            <input type="hidden" value="`+sizedrop+`" class="dddsizevalue">
              <div class="row">
               <div class="col-sm-2 col-md-2">
                  <div class="form-group">
                     <label>Size <span style="color: red">*</span></label>
                     <select class="form-control" name="stock[`+rendomnumber+`][size]" required>
                       <option value="`+sizedrop+`">`+size+`</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3">
                  <div class="form-group">
                     <label>Quantity <span style="color: red">*</span></label>
                     <input type="number" class="form-control" value="`+default_size+`" name="stock[`+rendomnumber+`][quantity]" min="0" max="100000" required>
                  </div>
               </div>
               <div class="col-sm-7 col-md-7">
                  <div class="form-group">
                     <label>Remark </label>
                     <textarea class="form-control" name="stock[`+rendomnumber+`][remark]" placeholder="Remark"></textarea>
                  </div>
               </div>
              </div>
            </fieldset>`;
            $('.itemselected'+sizedrop).addClass('active');
            $('.addnewrow').append(html);
        }

    })

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
        /******** form submit **********/
        $('body').on('submit', '.formsubmit', function (e) {
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
                        $('.add_modal').modal('hide');
                        $('.edit_modal').modal('hide');
                        $('#stocks').DataTable().ajax.reload();
                        toastr.success(data.msg,'Success!')
                    }
                },
            });
        });

        $('body').on('click', '.history_log_show', function () {
               var id = $(this).data('id');

               $.ajax({
                   url: "{{ route('admin.stocks.getmodalhistory')}}",
                   type: 'POST',
                   headers: {
                       'X-CSRF-TOKEN': '{{ csrf_token() }}'
                   },
                   data: {id: id},
                   success: function (data) {
                       $('.historylog').html(data);
                   },
               });
           });

        /****** delete record******/
        $('body').on('click', '.delete_record', function () {
            var id = $(this).data('id');

            (new PNotify({
                title: "Confirmation Needed",
                text: "Are you sure you wants to delete?",
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                },
                addclass: 'stack-modal',
                stack: {
                    'dir1': 'down',
                    'dir2': 'right',
                    'modal': true
                }
            })).get().on('pnotify.confirm', function () {
                $.ajax({
                    url: '{{ url("admin/vendors/") }}/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        if (data.status == 400) {
                            toastr.error(data.msg, 'Oh No!');
                        }
                        if (data.status == 200) {
                            toastr.success(data.msg, 'Success!');
                            $("#stocks").DataTable().ajax.reload();
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
            });
        });
    </script>
@endpush
@endsection
