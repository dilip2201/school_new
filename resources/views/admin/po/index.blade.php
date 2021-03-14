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
</style>

<div class="container" style="max-width: 95%; margin-top: 15px;">
    <!-- Info boxes -->
    <div class="row" style="margin-top: 20px">

        <div class="col-12">
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
                            <div class="col-md-2 item_master" >
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
                            <div class="col-md-2 item_master" >
                                <div class="form-group">
                                    <label style="font-size: 14px;"><b>Status: </b>
                                    </label>
                                    <select class="form-control  stockstatus" id="stockstatus" multiple="multiple" name="status[]">
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
                            <div class="col-md-1" style="padding-left: 0px;">
                                <button type="button" class="btn btn-success btn-sm searchdata"
                                        style="margin-top: 33px;padding: 6px 16px;"><i class="fa fa-search"></i>  Search
                                </button>
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

                            <div class="col-md-1" style="padding-left: 0px;">
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="margin-top: 33px;padding: 6px 15px;"><i class="fa fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
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
         function generaterandomnumber() {

              var rendomnumber = Math.floor((Math.random() * 1000000) + 1);
              return rendomnumber;
            }


        /******* display city image **********/





        $(function () {
            $('.stockstatus').select2();
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
                    {data: 'id'},
                    {data: 'date'},
                    {data: 'po_number'},
                    {data: 'vendor_id'},
                    {data: 'status'},
                    {data: 'action'},
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
                    $(".mobile-number").intlTelInput({
                        onlyCountries: ['in'],
                    });
                    $('.vendor').select2();


                },
            });
        });



        $('body').on('click','.removerowvisa',function(){
            var id = $(this).data('id');
            $('.remove'+id).remove();

        })
        $('body').on('click','.addrow',function(){

        rendomnumber = generaterandomnumber();
        var options = $('.loadsize').get(0).outerHTML;
        var html = `<fieldset class="remove`+rendomnumber+`">
        <legend>
           Quntity Info <i class="fa fa-trash removerowvisa" data-id="`+rendomnumber+`" style="color:red; cursor:pointer;"></i>
        </legend>
          <div class="row">
           <div class="col-sm-2 col-md-2">
              <div class="form-group">
                 <label>Size <span style="color: red">*</span></label>
                 <select class="form-control" name="stock[`+rendomnumber+`][size]" required>
                   `+options+`
                 </select>
              </div>
           </div>
           <div class="col-sm-3 col-md-3">
              <div class="form-group">
                 <label>Quantity <span style="color: red">*</span></label>
                 <input type="number" class="form-control" name="stock[`+rendomnumber+`][quantity]" min="0" max="100000" required>
              </div>
           </div>
           <div class="col-sm-7 col-md-7">
              <div class="form-group">
                 <label>Remark <span style="color: red">*</span></label>
                 <textarea class="form-control" name="stock[`+rendomnumber+`][remark]" placeholder="Remark" required></textarea>
              </div>
           </div>
          </div>
    </fieldset>`;
        $('.addnewrow').append(html);

    })
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

    </script>
@endpush
@endsection
