@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Reports')

<style type="text/css">
    table{
        width: 100%;
    }
    table td, table th {
  border: 1px solid #000;
  padding: 8px;
}
</style>
<div class="container" style="max-width: 95%; margin-top: 15px;">
    <!-- Info boxes -->

    <div class="row">
        
        <div class="col-12">
            <div class="card card-info card-outline displaybl">
                <div class="card-body" style="padding: 10px 15px;">
                    <div class="col-lg-12">
                        <div class="form-group row " style="margin-bottom: 0px;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Items: </b>
                                    </label>
                                    <select class="form-control status" id="status" name="status">
                                        <option value="">Select Item</option>
                                        @if(!empty($items))
                                        @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 item_master" >
                                <div class="form-group">
                                    <label><b>Item Name: </b>
                                    </label>
                                    <select class="form-control  item_masters" id=" item_masters" name="item_masters">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-left: 0px;">
                                <button class="btn btn-success btn-sm searchdata"
                                        style="margin-top: 33px;padding: 6px 16px;">Search <span
                                        class="spinner"></span>
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
    <!-- /.row -->
</div>

@push('links')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css" >
@endpush
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
    <script>


       
    $(function () {
        $('.status').select2();
        $('body').on('change','.status',function(){
            var id = $(this).val();
            $.ajax({
                url: "{{ route('admin.reports.changedrop')}}",
                type: 'POST',
                data:{id:id},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.item_masters').html(data);
                    $('.item_masters').select2();
                },
            });
        });
        /********* add new employee ********/
        $('body').on('click', '.searchdata', function () {
            var status = $('.status').val();
            var item_master = $('.item_masters').val();
            if(status == ''){
                toastr.error("Select items.", 'Oh No!');
            }else{
                $.ajax({
                    url: "{{ route('admin.reports.loadreport')}}",
                    type: 'POST',
                    data:{status:status,item_master:item_master},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        $('.loadcount').html(data);
                         $('.clickzoom').magnificPopup({
                            type: 'image',
                            zoom: {
                                enabled: true,
                                duration: 300 // don't foget to change the duration also in CSS
                            }
                        });
                    },
                });
            }
        });
    });
    </script>
@endpush
@endsection