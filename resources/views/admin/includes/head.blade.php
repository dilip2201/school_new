<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('pageTitle') | School Deparment</title>

    <!-- Font Awesome Icons -->

    <link rel="stylesheet" href="{{ URL::asset('public/admin/plugins/fontawesome-free/css/all.min.css') }}">
    @stack('select')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/company/developer.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ URL::asset('public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('public/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/admin/Pnotify/pnotify.custom.min.css') }}" />
    @stack('links')
    @stack('style')
</head>