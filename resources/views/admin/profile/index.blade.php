@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Profile')
@php
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-info card-outline">
                <div class="card-body box-profile">
                    @php
                    if(!empty(auth()->user()->image)){
                    $image = auth()->user()->image;
                    }else{
                    $image = 'default.png';
                    }
                    @endphp
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ url('public/company/employee/'.$image) }}" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ auth()->user()->name }} {{ auth()->user()->lastname }}
                    </h3>
                    <p class="text-muted text-center">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b> <a class="float-right">{{ auth()->user()->phone ?? '' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> <a class="float-right">@if(auth()->user()->status == 'active')<i
                                    class="fa fa-check" style="font-size: 16px; color: green"></i> @else <i
                                    class="fa fa-times" style="font-size: 16px; color: red"></i> @endif</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item "><a class="nav-link active" href="#timeline" data-toggle="tab">Personal
                                Info</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Change Password</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="timeline">
                            <!-- The timeline -->
                            <div class="card-block">
                                <div class="edit-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form action=" {{ route('profileupdate') }}" class="formsubmit"
                                                method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>First Name <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="name"
                                                                    required
                                                                    value="{{ auth()->user()->name ? auth()->user()->name : '-'  }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Last Name <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="lastname"
                                                                    required
                                                                    value="{{ auth()->user()->lastname ? auth()->user()->lastname : ''  }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Phone <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="phone"
                                                                    
                                                                    value="{{ auth()->user()->phone ? auth()->user()->phone : ''  }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Email<span style="color: red;">*</span></label>
                                                                <input type="email" class="form-control"
                                                                    name="email"
                                                                    value="{{ auth()->user()->email ? auth()->user()->email : '-'  }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Profile Image</label>
                                                                <input type="file" name="image" accept="image/*"
                                                                    class="form-control logo_image"
                                                                    placeholder="Profile image">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if(auth()->user()->image)
                                                            <?php $img = auth()->user()->image; ?>
                                                            @else
                                                            <?php $img = 'default.png'; ?>
                                                            @endif
                                                            <label class="col-sm-2 col-lg-2 col-form-label"></label>
                                                            <div class="col-sm-4 col-lg-4">
                                                                <img src="{{ URL::asset('public/company/employee/'.$img) }}"
                                                                    class="img-radius image_preview" width="60px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end of table col-lg-6 -->
                                                </div>
                                                <hr>
                                                <!-- end of row -->
                                                <div class="text-left">
                                                    <button type="submit" name="submit" value="Save"
                                                        class="btn btn-primary waves-effect waves-light m-r-20">
                                                        Save<span class="spinner"></span></button>
                                                </div>
                                            </form>
                                            <!-- end of edit info -->
                                        </div>
                                        <!-- end of col-lg-12 -->
                                    </div>
                                    <!-- end of row -->
                                </div>
                                <!-- end of edit-info -->
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- change password -->
                        <div class="tab-pane" id="password">
                            <!-- info card start -->
                            <div class="card-block">
                                <form class="form-some-up form-block passwordformsubmit" role="form"
                                    action="{{ route('changepassword') }}" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Current Password <span
                                                style="color: red;">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="current_password"
                                                placeholder="Current Password" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">New Password <span
                                                style="color: red;">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="new_password"
                                                placeholder="New Password" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Confirm Password <span
                                                style="color: red;">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="Confirm Password" value="" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Update <span
                                                class="passwordspinner"></span></button>
                                    </div>
                                </form>
                            </div>
                            <!-- info card end -->
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
</div>
@push('script')
    <script src="{{ URL::asset('public/js/slider.js') }}"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">


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
$(".formsubmit").validate({
    rules: {
        name : {
            required:true,
            maxlength: 20,
        },
        lastname:{
            required:true,
            maxlength: 20,
        },
        phone: {
            required:true,
            number: true,
            maxlength: 10,
            minlength: 10,

        }
    }

});
$(".passwordformsubmit").validate();
$('body').on('submit', '.formsubmit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        data: new FormData(this),
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
        },
        success: function(data) {

            if (data.status == 400) {
                $('.spinner').html('');
                toastr.error(data.msg)
            }
            if (data.status == 200) {

                $('.spinner').html('');
                toastr.success(data.msg)
            }
        },
    });
});
/*change password*/
$('body').on('submit', '.passwordformsubmit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        data: new FormData(this),
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
        },
        success: function(data) {
            if (data.status == 400) {
                $('.spinner').html('');
                toastr.error(data.msg)

            }
            if (data.status == 200) {
                $('.spinner').html('');
                $(".passwordformsubmit")[0].reset();
                toastr.success(data.msg)
            }
        },
    });
});

/***********setting*********/
$('body').on('submit', '.settiingsubmitform', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        data: new FormData(this),
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>');
            $('.submitbutton').prop("disabled", true);

        },
        success: function(data) {

            $('.submitbutton').prop("disabled", false);
            if (data.status == 400) {
                $('.spinner').html('');
                toastr.error(data.msg, 'Oh No!');
            }
            if (data.status == 200) {
                $('.spinner').html('');

                toastr.success(data.msg, 'Success!');
            }

        },
    });

});
</script>
@endpush
@endsection