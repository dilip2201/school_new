@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Users')

<div class="container" style="max-width: 95%;">
    <!-- Info boxes -->

    <div class="row">
        <div class="col-12" style="margin-top: -40px;">
        <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal"
                       class="btn btn-info btn-sm openaddmodal" data-id="" style="float: right; ">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                    <span class="clicktosearch " style="float: right;margin-right: 10px;"><button class="btn btn-sm btn-info"> Click To Search <i
                        class="fa fa-search"></i></button></span>
                </div>
        <div class="col-12">
            <div class="card card-info card-outline displaybl"  style=" display: none;">
                <div class="card-body" style="padding: 10px 15px;">
                    <div class="col-lg-12">
                        <div class="form-group row " style="margin-bottom: 0px;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Status: </b>
                                    </label>
                                    <select class="form-control status" id="status" name="status">
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-left: 0px;">
                                <button class="btn btn-success btn-sm searchdata"
                                        style="margin-top: 33px;padding: 6px 16px;">Search <span
                                        class="spinner"></span>
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger btn-sm"
                                   style="margin-top: 33px;margin-left: 5px;padding: 6px 16px;cursor: pointer; ">
                                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="card  card-outline">
               
                <div class="card-body">
                    <!-- /.card-header -->
                    <table id="employee" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>User Id</th>
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



@push('script')
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        function readURL(input, classes) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.' + classes).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('body').on('change', '.logo_image', function() {
            readURL(this, 'image_preview');
        });
        $(function () {
            /* datatable */
            $("#employee").DataTable({
                "responsive": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    'url': "{{ route('admin.users.getall') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $("#status").val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "orderable": false},
                    {data: 'image'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'status'},
                    {data: 'action', orderable: false},
                ]
            });
            /*filter*/
            $('.searchdata').click(function () {
                event.preventDefault();
                $("#employee").DataTable().ajax.reload()
            })
        });

        $('body').on('click', '.clicktosearch', function () {
            $('.displaybl').toggle("slide");
        })
        /********* add new employee ********/
        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text('Add User');
            } else {
                $('.modal-title').text('Edit User');
            }
            $.ajax({
                url: "{{ route('admin.users.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.addholidaybody').html(data);
                        $(".formsubmit").validate({

                    });

                },
            });
        });

        

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
                    url: '{{ url("admin/users/") }}/' + id,
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
        /** change status**/
        $('body').on('click', '.changestatus', function () {
            var id = $(this).data('id');
            var status = $(this).data('status');
            (new PNotify({
                title: "Confirmation Needed",
                text: "Are you sure you wants to "+ status +" this record?",
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
                    url: '{{ route("admin.users.changestatus") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {id: id, status: status},
                    success: function (data) {
                        $("#employee").DataTable().ajax.reload();
                        toastr.success('Status changed successfully.', 'Success!');
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');

                    }
                });
            })

        });
    </script>
@endpush
@endsection