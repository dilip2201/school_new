<!DOCTYPE html>
<html lang="en">
     @include('admin.includes.head')

     <style type="text/css">
      #cover {
    background: url("{{ url('public/loder.gif') }}") no-repeat scroll center center #FFF;
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: 99;
}

    </style>
   <body class="hold-transition layout-top-nav  layout-footer-fixed">
    <div class="loadmodal"></div>
    
    <div id="cover"></div>
      <div class="wrapper">
        @include('admin.includes.header')
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper contentwrap ">
          @include('admin.includes.breadcrumbs')
            <!-- Main content -->
            <section class="content mobilepadding">
               @yield('content')
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         @include('admin.includes.footer')
      </div>
      @include('admin.includes.scripts')
   </body>
</html>
