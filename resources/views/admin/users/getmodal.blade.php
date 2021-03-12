<form  autocorrect="off" action="{{ route('admin.users.store') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmit">
    {{ csrf_field() }}

    @if(isset($user) && !empty($user->id) )
        <input type="hidden" name="userid" value="{{ encrypt($user->id) }}">
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control " name="name"
                       placeholder="Name"
                       value="@if(!empty($user)){{ $user->name }}@endif" required="" maxlength="30">
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lastname"
                       placeholder="Last Name"
                       value="@if(!empty($user)){{ $user->lastname }}@endif" required="" maxlength="30">
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>User Id</label>
                <input type="text" class="form-control " name="username"
                       placeholder="User Id" minlength="4"
                       value="@if(!empty($user)){{ $user->username }}@endif" required="">
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control " minlength="6" name="password"
                       placeholder="password"
                       value="" @if(empty($user)) required @endif>
            </div>
        </div>
        <input id="password-confirm" type="password" placeholder="Confirm Password"
                    name="asaspassword_confirmation" autocomplete="new-password" style="display: none;">
        <div class="container-fluid">
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                
                <label>Profile Image</label>
                <input type="file" name="image" accept="image/*"
                    class="form-control logo_image" style="padding: 3px;" 
                    placeholder="Profile image">
            </div>
        </div>
          @php $image = url('public/company/employee/default.png'); @endphp

          @if(!empty($user) && file_exists(public_path().'/company/employee/'.$user->image) && !empty($user->image))
               @php $image = url('public/company/employee/'.$user->image);  @endphp
          @endif
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
              <span style=""><img src="{{$image}}" class="image_preview profile-user-img" width="auto" height="100px" style="margin-left: 60px;"></span>
            </div>
        </div>
      </div>
    </div>
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
            </div>
        </div>
    </div>
</form>