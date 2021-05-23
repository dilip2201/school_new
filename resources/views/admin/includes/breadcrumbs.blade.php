
@if(activeMenu('uniform') != 'active' && activeMenu('dashboard') != 'active' &&  activeMenu('reports') != 'active' && activeMenu('vendors') != 'active' && activeMenu('stocks') != 'active' && activeMenu('po') != 'active' && activeMenu('pendingstock') != 'active')
<!-- Content Header (Page header) -->
<div class="content-header mobiledisplay" style="padding: 10px .5rem;">
   <div class="container">
      <div class="row mb-2">
         <!-- /.col -->
         <div class="col-sm-6 ">
            
            <ol class="breadcrumb ">
               <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                @stack('breadcrumb')
               <li class="breadcrumb-item active">@yield('pageTitle')</li>
            </ol>
            
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@endif