@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Stocks')
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
 .statusbtn {
     padding: 5px;
 }
</style>
<div class="container" style="max-width: 95%; margin-top: 50px;">
    <!-- Info boxes -->
    <div class="row" style="margin-top: 20px">

        <div class="col-12">
            <div class="card card-info card-outline displaybl">
                <div class="card-body" style="padding: 10px 15px;">
                    <div class="col-lg-12">
                        <div class="form-group row " style="margin-bottom: 0px;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><b>Start Date: </b>
                                    </label>
                                    <input type="date" class="form-control" name="start_date" id="start_date"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><b>End Date: </b>
                                    </label>
                                    <input type="date" name="end_date" class="form-control" id="end_date"/>
                                </div>
                            </div>
                            <div class="col-md-3 item_master" >
                                <div class="form-group">
                                    <label><b>Vendor: </b>
                                    </label>
                                    <select class="form-control vendor" id=" item_masters" name="vendor_id">
                                        <option>
                                            Test
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 item_master" >
                                <div class="form-group">
                                    <label><b>Status: </b>
                                    </label>
                                    <select class="form-control  status" id="status" name="status">
                                        <option value="pending">
                                            Pending
                                        </option>
                                        <option value="ordered">
                                            Ordered
                                        </option>
                                        <option value="dispatched">
                                            Dispatched
                                        </option>
                                        <option value="delivered">
                                            Delivered
                                        </option>
                                        <option value="partially_delivered">
                                            Partially Delivered
                                        </option>
                                        <option value="cancelled">
                                            Cancelled
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <button class="btn btn-success btn-sm searchdata"
                                        style="margin-top: 33px;padding: 6px 16px;">Search <span
                                        class="spinner"></span>
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="margin-top: 33px;padding: 6px 16px;"><i class="fa fa-download"></i> Export Excel</span>
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="margin-top: 33px;padding: 6px 16px;"><i class="fa fa-download"></i> Export PDF</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="loadcount">


            </div>
            <!-- /.col -->
        </div>

    </div>
    <div class="row">
        @if(checkPermission(['super_admin']))
        <div class="col-12 mb-3" style="">
        <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal"
                       class="btn btn-info btn-sm openaddmodal" data-id="" style="float: right; ">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>
                @endif
        <div class="col-12">

            <div class="card  card-outline">

                <div class="card-body">
                    <!-- /.card-header -->
                    <table id="stocks" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Expected Date</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Pending Quantity</th>
                            <th>remark</th>
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
<div class="modal fade add_modal" >
    <div class="modal-dialog modal-lg">
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


@push('links')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="{{ URL::asset('public/js/intlTelInput.css') }}" />
@endpush

@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/intlTelInput.js') }}"></script>
    <script>

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


        $(function () {

            $('body').on('change','.selecttype',function(){
                var selecttype = $(this).val()
                if(selecttype == 'commission'){
                    $('.formsubmitcomision').css('display','block');
                    $('.formsubmithistory').css('display','none');
                }else{
                    $('.formsubmithistory').css('display','block');
                    $('.formsubmitcomision').css('display','none');
                }
            });
            /* datatable */
            $("#stocks").DataTable({
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
                        d.status = $('.status').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'item_id'},
                    {data: 'date'},
                    {data: 'expected_date'},
                    {data: 'size'},
                    {data: 'quantity'},
                    {data: 'pending_quantity'},
                    {data: 'remark'},
                    {data: 'status'},
                    {data: 'action'},
                ]
            });
        });
        /********* add new School ********/
        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text('Add Vendor');
            } else {
                $('.modal-title').text('Edit Vendor');
            }
            $.ajax({
                url: "{{ route('admin.vendors.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.addholidaybody').html(data);
                    /******** cityselectwithstatecountry dropdown **********/
                    $(".mobile-number").intlTelInput({
                        onlyCountries: ['in'],
                    });
                    /******** validation **********/
                        $(".formsubmit").validate({
                            rules: {
                            "name": {
                                 required: true,
                                 maxlength: 50,
                             },
                            "email": {
                                required: true,
                            },

                        },
                        messages: {
                        }

                    });

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
                        $('#employee').DataTable().ajax.reload();
                        toastr.success(data.msg,'Success!')
                    }
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
                            $("#employee").DataTable().ajax.reload();
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
