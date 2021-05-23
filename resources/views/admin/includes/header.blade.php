<style>
    .dropdown-item.active, .dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: #2d353d;
}
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white navmenu" style="padding: .5rem 0.2rem;">
    <div class="container" style="max-width: 100%;">
        <div class="navbar-brand">

            <a href="{{ url('admin/dashboard') }}">
                <span class="fa fa-html5" style="margin-left: 10px;width: 100%;color: #fff; font-size: 25px;
                  "></span>
            </a>
        </div>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{activeMenu('dashboard')}}">{{ __('message.Dashboard') }}</a>
                </li>
                @if(checkPermission(['super_admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.users.index')}}" class="nav-link {{activeMenu('users')}}">Users</a>
                </li>
                @endif
                @if(checkPermission(['super_admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.school.index')}}" class="nav-link {{activeMenu('school')}}">School</a>
                </li>
                @endif
                @if(checkPermission(['super_admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.uniform.index')}}" class="nav-link {{activeMenu('uniform')}}">Uniform Information</a>
                </li>
                @endif
                
                @if(checkPermission(['super_admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index')}}" class="nav-link {{activeMenu('reports')}}">Reports</a>
                </li>
                @endif

                @if(checkPermission(['super_admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.vendors.index')}}" class="nav-link {{activeMenu('vendors')}}">Vendors</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{activeMenu('stocks')}} {{activeMenu('po')}} {{activeMenu('pendingstock')}}">Purchase order</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                     <li><a href="{{ route('admin.pendingstock.index') }}" class="dropdown-item {{activeMenu('pendingstock')}}">Pending Stock Items</a></li>
                      <li><a href="{{ route('admin.stocks.index') }}" class="dropdown-item {{activeMenu('stocks')}}">Stock Item</a></li>
                      <li><a href="{{ route('admin.po.index') }}" class="dropdown-item {{activeMenu('po')}}">P.O.</a></li>
                    </ul>
                  </li>
            </ul>
        </div>
        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">


           

            <li class="nav-item dropdown profiledrop">
                @php
                if(!empty(auth()->user()->image)){
                $image =auth()->user()->image;
                }else{
                $image = 'default.png';
                }
                @endphp
                <a class="nav-link" data-toggle="dropdown" href="#" style="padding-top: 5px;">
                    <img src="{{ url('public/company/employee/'.$image) }}" style=" width: 30px;">

                </a>


                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                    style="top: 133%; min-width: 315px!important; border-radius: 10px;">
                    <div
                        style="width:100%; padding: 20px; background: url('{{ url('public/admin/user_profile_bg.jpg') }}');background-size: cover;">
                        <div class="m-card-user m-card-user--skin-dark" style="color: #fff;">
                            <div class="m-card-user__details">
                                <span
                                    style="font-size: 20px; width: 100%; display: block;">{{ auth()->user()->name }} {{ auth()->user()->lastname }}</span>
                                <a href="#" class="m-card-user__email m--font-weight-300 m-link"
                                    style="color: #fff;">{{ auth()->user()->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>

                    <div class="buttonsection" style="padding: 15px;">
                        <a href="{{ route('admin.profile') }}" class="btn btnpopup profilebutton"><i class="fa fa-user"
                                aria-hidden="true"></i> Profile</a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btnpopup"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>

                </div>

            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->