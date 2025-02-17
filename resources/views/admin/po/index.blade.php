@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'P.O.')
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
 tr{
    font-size: 14px;

 }
 .dataTables_info{
    font-size: 14px;
 }
.select2-selection__choice{
    color: black !important;
}
.itemdata td, .itemdata th{
     border: 1px solid #000;
     padding: 10px;
}
.itemdata{
    width: 100%;
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
</style>

<div class="container" style="max-width: 95%; margin-top: 15px;">
    <!-- Info boxes -->
    <div class="row" style="margin-top: 20px">

        <div class="col-12">
            @if(checkPermission(['super_admin']))
                <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal"
                   class="btn btn-info btn-sm mr-2 openaddmodal" data-id="" style="float: left; ">
                    <i class="fa fa-plus"></i> Add New
                </a>
            @endif
            <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-filter"></i> Click to Filter
            </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-info card-outline displaybl">
                    <div class="card-body" style="padding: 10px 15px;">
                        <form action="{{ route('admin.po.excelexport') }}" method="POST">
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
                                    <div class="col-md-3 item_master">
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
                                    <div class="col-md-3 item_master">
                                        <div class="form-group">
                                            <label style="font-size: 14px;"><b>Status: </b>
                                            </label><br>
                                            <select class="form-control  stockstatus" id="stockstatus" multiple="multiple"
                                                    name="status[]">
                                                <option value="open" selected>
                                                    Open
                                                </option>
                                                <option value="partially_open">
                                                    Partially Opened
                                                </option>
                                                <option value="closed">
                                                    Closed
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="padding-left: 0px;">
                                        <div class="form-group">
                                            <label style="font-size: 14px;"><b>Export: </b>
                                            </label>
                                            <select class="form-control" id="exportto" name="exportto">
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
                                <div class="col-md-3 ml-3" style="padding-left: 0px;">
                                    <button type="button" class="btn btn-success btn-sm searchdata"
                                            style="padding: 6px 16px;"><i class="fa fa-search"></i> Search
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm ml-1"
                                            style="padding: 6px 15px;"><i class="fa fa-download"></i> Download
                                    </button>
                                    <a href="{{ url('admin/po') }}" class="btn btn-danger btn-sm ml-1"
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
                            <th>Sr.No.</th>
                            <th>Date</th>
                            <th>Po No.</th>
                            <th>Vendor</th>
                            <th>Status</th>
                            <th>Action</th>
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
<div class="modal fade add_modal" style="z-index: 1042;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content " >
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Large Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body addholidaybody" style="max-height: 500px;    overflow-y: scroll;">
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
                <h5 class="modal-title potitle">Large Modal</h5>
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

<div class="modal fade import_stock" style="z-index: 1042;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content " >
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title modalimporttitle">Import Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body import_stockbody" style="max-height: 500px;    overflow-y: scroll;">
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="{{ URL::asset('public/js/intlTelInput.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css" >
@endpush

@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/intlTelInput.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
    <script>
         function generaterandomnumber() {

              var rendomnumber = Math.floor((Math.random() * 1000000) + 1);
              return rendomnumber;
            }


        /******* display city image **********/

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



        $(function () {

            $('.vendor_id').select2();

            $('body').on('click','.vieworderclick',function(){
                var id = $(this).data('id');


                $('.modal-title').text('View PO');

                $.ajax({
                    url: "{{ route('admin.po.viewmodal')}}",
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
                 "order": [[ 2, "desc" ]],
                // columnDefs: [
                //     { width: 180, targets:  4},
                //     { width: 50, targets:  0},
                //     { width: 180, targets:  2},
                //     { width: 50, targets:  3},
                // ],
                ajax: {
                    'url': "{{ route('admin.po.getall') }}",
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
                    {data: 'date'},
                    {data: 'po_number'},
                    {data: 'vendor_id','orderable' : false},
                    {data: 'status','orderable' : false},
                    {data: 'action','orderable' : false},
                ]
            });
            /* Search records by filter */
            $('body').on('click','.searchdata',function(){
                table.ajax.reload();
            });
        });
        $('body').on('change','.status',function(){
            var id = $(this).val();
            $.ajax({
                url: "{{ route('admin.reports.changedropvalue')}}",
                type: 'POST',
                data:{id:id},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.item_masters').html(data);
                    $('.item_masters').select2();
                    $('.loadimage').html('');
                },
            });
        });

        $('body').on('click','.importstockcheckbox',function(){
                var isadded = 0;
                var alreadyimported = $.map($('.selectitem :selected'), function(c,i){
                    if($(c).val() != ''){                        
                        return $(c).val();
                    }
                });
                
                $.map($('.cb1:checked'), function(c,i){
                rendomnumber = generaterandomnumber();
                var expected_date = $('.expected_date').val();
                var options = $('.loadsize').get(0).outerHTML;
                if (alreadyimported.length == 0 && i === 0) {

                    var addorremove = `<a class="addrow" style="cursor: pointer;"><i style="color: #208a05; font-size: 28px;" class="fa fa-plus-circle"></i></a>`;
                    $('.removefirsttr').remove();
                }else{

                    var addorremove = `<a class="removerowvisa" data-id="`+rendomnumber+`" style="cursor: pointer;"><i style="color: #af0808; font-size: 28px;" class="fa fa-minus-circle"></i></a>`;
                }
                
                var html = `<tr class="remove`+rendomnumber+`">
                        <td>
                          <select class="form-control selectitem selectnumber`+c.value+`" name="data[`+rendomnumber+`][item_id]" data-id="`+rendomnumber+`" required>
                            <option value="">Select Item</option>
                           `+options+`
                          </select>
                        </td>
                        <td  style="text-align: center;" class="image`+rendomnumber+`"></td>
                        <td style="text-align: center;" class="size`+rendomnumber+`"></td>
                        <td class="quantity`+rendomnumber+`"></td>
                        <td><input type="date" class="form-control" name="data[`+rendomnumber+`][expected]" value="`+expected_date+`"></td>
                        <td style="text-align: center;">`+addorremove+`</td>
                    </tr>`;
                $('.itemdata').append(html);
                $('.selectitem').select2();
                $('.selectnumber'+c.value+' option[value='+c.value+']').attr('selected','selected');
                $('.selectnumber'+c.value).trigger("change");
                $('.import_stock').modal('hide');
            });


        });
        $('body').on('click', '.importpo', function () {
            $('.modalimporttitle').text('Import Stock');
            var alreadyimported =$.map($('.selectitem :selected'), function(c,i){
                return $(c).val();
            });
            $.ajax({
                url: "{{ route('admin.pendingstock.loadimport')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data : {alreadyimported:alreadyimported},
                beforeSend: function () {
                    $('.import_stockbody').html('');
                },
                success: function (data) {
                    $('.import_stockbody').html(data);
                    $('.allcb').change(function () {
                        $('.importstcokkcheck tbody tr td input[type="checkbox"]').prop('checked', $(this).prop('checked'));
                    });
                    $('.importstcokkcheck').DataTable({
                         "paging":   false,
                    });
                    $('.showitem').magnificPopup({
                        type: 'image',
                        zoom: {
                            enabled: true,
                            duration: 300 // don't foget to change the duration also in CSS
                        }
                    });
                },
            });
            
        });

        $('body').on('click','.caclestock',function(){
                var id = $(this).data('id');

                (new PNotify({
                title: "Confirmation Needed",
                text: "Are you sure you wants to cancel?",
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
                    url: '{{ url("admin/caclestock/") }}/' + id,
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
                            $('#stocks').DataTable().ajax.reload();
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
            });
        });
        $('body').on('click', '.sendtovendor', function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.po.sendtovendor')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                beforeSend: function () {
                    $('.whatsappspinner').html('<i class="fa fa-spinner fa-spin"></i>')
                },
                success: function (data) {
                    if (data.status == 400) {
                        $('.whatsappspinner').html('');
                        toastr.error(data.msg)
                    }
                    if (data.status == 200) {
                        $('.whatsappspinner').html('');
                        $('.loadsentstatus').text(`You have sent this order to vendor `+data.send_count+` times.`)
                        toastr.success(data.msg,'Success!')
                    }
                },
            });
        });
        /********* add new School ********/
        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text('P.O.');
            } else {
                $('.modal-title').text('Edit Vendor');
            }
            $.ajax({
                url: "{{ route('admin.po.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.addholidaybody').html(data);
                    /******** cityselectwithstatecountry dropdown **********/
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.vendor').select2();
                    $('.selectitem').select2();
                },
            });
        });



        $('body').on('click','.removerowvisa',function(){
            var id = $(this).data('id');
            $('.remove'+id).remove();
            $('.disableremove').prop('disabled',false);
            $('.selectitem').each(function(index, elem) {
                
                $('.dis'+$(this).val()).prop('disabled',true);
            });

            

        })
        $('body').on('click','.changelable',function(){
            var id = $(this).data('id');
            $('.changeqty'+id).css('display','none');
            $('.span'+id).css('display','block');
            $('.textv'+id).focus();
        })

        $('body').on('click','.storevalue',function(){
            
            var id = $(this).data('id');
            var textvalue = $('.textv'+id).val();
            $('.changeqty'+id).css('display','block');
            $('.span'+id).css('display','none');
            $('.changeqty'+id).text(textvalue);

            $.ajax({
                url: "{{ route('admin.po.updatevalue')}}",
                type: 'POST',
                data:{id:id,textvalue:textvalue},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                
                success: function (data) {
                
                },
            });


        });
         $('body').on('change','.selectitem',function(){
            var id = $(this).data('id');
            var valuen = $(this).val();
            var image = $(this).find(':selected').data('image');
            var quntity = $(this).find(':selected').data('quntity');
            var size = $(this).find(':selected').data('size');

            var url = "{{ url('public/uniforms/')}}/"+image;
            var qtyhtml = `<span class="changeqty`+valuen+` changelable" data-id="`+valuen+`">`+quntity+`</span><span class="span`+valuen+`" style="display:none;"><input type="text" class="textvalue textv`+valuen+`" style="width: 65px; float:left;" value="`+quntity+`"><i style="cursor: pointer;    float: left;    margin-left: 10px;    color: green;    font-size: 22px;" class="fa fa-check-circle storevalue" data-id="`+valuen+`" aria-hidden="true"></i></span>`;
            $('.image'+id).html(`<a class="showitem" href="`+url+`"><img src="`+url+`" style="width: auto; height: 50px;">`);
            $('.size'+id).html(size);
            $('.quantity'+id).html(qtyhtml);
            $('.disableremove').prop('disabled',false);
            $('.selectitem').each(function(index, elem) {

                $('.dis'+$(this).val()).prop('disabled',true);
            });

            $('.showitem').magnificPopup({
                type: 'image',
                zoom: {
                    enabled: true,
                    duration: 300 // don't foget to change the duration also in CSS
                }
            });

        });
        $('body').on('click','.addrow',function(){

            rendomnumber = generaterandomnumber();
            var options = $('.loadsize').get(0).outerHTML;
            var html = `<tr class="remove`+rendomnumber+`">
                    <td>
                      <select class="form-control selectitem" name="data[`+rendomnumber+`][item_id]" data-id="`+rendomnumber+`" required>
                        <option value="">Select Item</option>
                       `+options+`
                      </select>
                    </td>
                    <td  style="text-align: center;" class="image`+rendomnumber+`"></td>
                    <td style="text-align: center;" class="size`+rendomnumber+`"></td>
                    <td class="quantity`+rendomnumber+`"></td>
                    <td><input type="date" class="form-control" name="data[`+rendomnumber+`][expected]"></td>
                    <td style="text-align: center;"><a class="removerowvisa" data-id="`+rendomnumber+`" style="cursor: pointer;"><i style="color: #af0808; font-size: 28px;" class="fa fa-minus-circle"></i></a></td>
                </tr>`;
            $('.itemdata').append(html);
            $('.selectitem').select2();


             
           

        })
        $('body').on('click', '.submitbutton', function (e) {
            var type = $(this).data('type');
            $('.submittype').val(type);
        });
        /******** form submit **********/
        $('body').on('submit', '.formsubmit', function (e) {
            $('.disableremove').prop('disabled',false);
            var type = $('.submittype').val();
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    if(type == 'submit'){
                        $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
                    }
                    if(type == 'send'){
                       $('.whspinner').html('<i class="fa fa-spinner fa-spin"></i>')
                    }
                },
                success: function (data) {

                    if (data.status == 400) {
                        $('.selectitem').each(function(index, elem) {

                            $('.dis'+$(this).val()).prop('disabled',true);
                        });
                        $('.spinner').html('');
                        $('.whspinner').html('');
                        toastr.error(data.msg)
                    }
                    if (data.status == 200) {
                        $('.spinner').html('');
                        $('.whspinner').html('');
                        $('.add_modal').modal('hide');
                        $('.edit_modal').modal('hide');
                        $('#stocks').DataTable().ajax.reload();
                        toastr.success(data.msg,'Success!')
                    }
                },
            });
        });

    </script>
@endpush
@endsection
