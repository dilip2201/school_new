@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'School')
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
</style>
<div class="container" style="max-width: 95%;">
    <!-- Info boxes -->

    <div class="row">
        @if(checkPermission(['super_admin']))
        <div class="col-12" style="margin-top: -40px;">
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
                    <table id="employee" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                        <tr>
                            <th>Sr.No.</th> 
                            <th>Image</th>
                            <th>Name</th>
                            <th>School Code</th>
                            <th>Address</th>
                            <th>City</th>
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
<!-- /.modal -->
<div class="modal fade view_detail" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">School Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body detailview">

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade add_commision" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Commision Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body commisionviews">

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@push('links')
 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
@endpush

@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
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

        $('body').on('keyup change','.boyvalue',function(){
            if(!$('.is_checked').is(":checked")){
                var id = $(this).data('id');
                var boyvalue = $('.boy'+id).val();
                var girlvalue = $('.girl'+id).val();
                var total = Number(boyvalue) + Number(girlvalue);
                $('.totalstrength'+id).val(total);
            }
        })
        $('body').on('keyup change','.girlvalue',function(){
            if(!$('.is_checked').is(":checked")){
                var id = $(this).data('id');
                var boyvalue = $('.boy'+id).val();
                var girlvalue = $('.girl'+id).val();
                var total = Number(boyvalue) + Number(girlvalue);
                $('.totalstrength'+id).val(total);
            }
        })
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
            $("#employee").DataTable({
                "responsive": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                stateSave: true,
                columnDefs: [
                    { width: 180, targets:  4},
                    { width: 50, targets:  0},
                    { width: 180, targets:  2},
                    { width: 50, targets:  3},
                ],
                ajax: {
                    'url': "{{ route('admin.school.getall') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "orderable": false},
                    {data: 'image'},
                    {data: 'name'},
                    {data: 'school_code'},
                    {data: 'address'},
                    {data: 'city'},
                    {data: 'action', orderable: false},
                ]
            });
            /*filter*/
            $('.searchdata').click(function () {
                event.preventDefault();
                $("#employee").DataTable().ajax.reload()
            })
        });
        /********* add new School ********/
        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text('Add School');
            } else {
                $('.modal-title').text('Edit School');
            }
            $.ajax({
                url: "{{ route('admin.school.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.addholidaybody').html(data);
                        /******** cityselectwithstatecountry dropdown **********/
                        $(".cityselectwithstatecountry").select2({

                        dropdownParent: $('.add_modal'),
                        minimumInputLength: 2,
                        placeholder: "City",
                        templateResult: formatState,
                        ajax: {
                            url: "{{ route('admin.school.citywithstatecountry') }}",
                            dataType: 'json',
                            type: "POST",

                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: function (term) {
                                
                                return {
                                    term: term
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.name + ', ' + item.state.name + ', ' + item.state.country.name,
                                            id: item.id,
                                            contryflage: item.state.country.sortname
                                        }
                                    })
                                };
                            }

                        }
                    });
                    /******** validation **********/
                        $(".formsubmit").validate({
                            rules: {
                            "name": {
                                 required: true,
                                 maxlength: 50,
                             },
                            "address": {
                                maxlength: 50,
                            },
                            "p_name": {
                                 required: true,
                                 maxlength: 50,
                             },
                            "p_number": {
                                required:true,
                                number: true,
                                maxlength: 10,
                                minlength: 10,
                            },
                            "city_id": {
                               required:true,
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
                /******** form submit **********/
        $('body').on('submit', '.formsubmitcomision', function (e) {
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
                        $('.add_commision').modal('hide');
                        $('#employee').DataTable().ajax.reload();
                        toastr.success(data.msg,'Success!')
                    }
                },
            });
        });

        $('body').on('submit', '.formsubmithistory', function (e) {
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
                        $('.add_commision').modal('hide');
                        $('#employee').DataTable().ajax.reload();
                        toastr.success(data.msg,'Success!')
                    }
                },
            });
        });

        $('body').on('click','.openclientview',function(){
            var school_id = $(this).data('school_id');
            $.ajax({
                url: '{{ route("admin.school.viewdetail") }}',
                type: 'POST',
                data:{school_id:school_id},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    
                   $('.detailview').html(data);
                },
                error: function () {
                    toastr.error('Something went wrong!', 'Oh No!');

                }
            });

        });

        $('body').on('click','.opencommission',function(){
             var school_id = $(this).data('school_id');
            $.ajax({
                url: '{{ route("admin.school.getcomissionmodal") }}',
                type: 'POST',
                data:{school_id:school_id},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    
                   $('.commisionviews').html(data);
                   $('.multiselect').multiselect({
                        maxHeight: 200,
                        includeSelectAllOption: true
                    });
                    $(".formsubmitcomision").validate({
                       
                    });
                },
                error: function () {
                    toastr.error('Something went wrong!', 'Oh No!');

                }
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
                    url: '{{ url("admin/school/") }}/' + id,
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
