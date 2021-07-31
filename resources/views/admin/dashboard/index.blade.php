@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Dashboard')
<style>
 .fa-bars:before {
 content: white;
 }
 .item label{
  font-size: 13px;
 }
 .fa-bars:after {
 content: white;
 }
 .navbar-white {
 background-color: black;
 }
 .fa-bars{
 color: white!important;
 }
 .main-sidebar {
 background-color: black;
 }
 .form-group{
 margin-bottom: 8px!important;
 }
 table {
 border-collapse: collapse;
 }
 table, td, th {
 border: 1px solid black;
 }
 .multiselectclass .btn-group{
    width: 100%;
 }
 .multiselectclass .btn-default{
    border-color: #aaa!important;
 }
 .multiselectclass .multiselect{
    text-align: left;
 }
 .master{
 width: 100%;
 float: left;
 height: 150px;
 background: #fff;
 }
 
 .multiselect-container>li>a>label{
    padding: 3px 15px 3px 15px;
 }
 .left{
 width: 30%;
 float: left;
 border: 1px solid #000;
 height: 150px;
 border-right: 0px;
 text-align: center;
 vertical-align: middle;
 line-height: 150px;
 font-weight: 600;
 color: #20023c;
 background: #fff;
 }
 .right{
 float: left;
 width: 70%;
 height: 150px;
 border: 1px solid;
 text-align: center;
 padding: 5px;
 background: #fff;
 }
 .slick-prev:before, .slick-next:before{
  color: #000;
 }
 button.slick-next.slick-arrow{
  z-index: 99;
 }
 .slick-slide img{
  display: inline-block;
 }

         /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.filtermodal.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99999; /* Sit on top */
  padding-top: 40%;
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.filtermodal .modal-content {
  margin: auto;
  display: block;
  
  max-width: 700px;
}


.item.slick-slide{
  text-align: center;
}
@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .filtermodal .modal-body {
   
    padding: 10px 35px!important;
}
}

.input-hidden {
  position: absolute;
  left: -9999px;
}

input[type=radio]:checked + label>img {
  border: 1px solid #fff;
  box-shadow: 0 0 2px 1px #427bff;
}

/* Stuff after this is only to make things more pretty */
input[type=radio] + label>img {
  width: 150px;
  height: 150px;
  
}

@media only screen and (min-width: 600px){
 .fullscreendisply{
  width: 400px;
      margin-left: 73px!important;
    box-shadow: 0px 0px 3px #000;
    float: left;
    margin-top: 5px;
 }
 .filtermodal .modal{
  padding-top: 5%!important;
 }
}


.items-collection {
    width: 100%;
}
.items {
    display: inline-block;
}
.items-collection .btn-group {
    width: 100%;
}
.items-collection label.btn-default {
    width: 90%;
    border: 1px solid #305891;
    margin: 5px;
    border-radius: 17px;
    color: #305891;
}
.btn-group>.btn:first-child {
    margin-left: 0;
}
.items-collection label.btn-default.active {
    background-color: #007ba7;
    color: #FFF;
}
</style>

<div class="content-wrapper fullscreendisply" style="margin-bottom: 25px;">
            <!-- Main content -->
            <section class="content ">
               <div class="col-lg-12">
                  <div class="form-group row " style="margin-top: 15px;">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label><b>School :</b></label>
                           <a href="#" class="openaddmodal" style="float: right;" data-toggle="modal" data-typeid="" data-target=".add_modal"><i class="fa fa-plus-circle" style="color: #000; cursor: pointer; font-size: 25px; "></i></a>
                           <a href="#" class="openaddmodaluniform" style="float: right; margin-right: 5px;" data-toggle="modal" data-typeid="" data-target=".add_modaluniform"><i class="fa fa-telegram" aria-hidden="true" style="color: #000; cursor: pointer; font-size: 25px; "></i> </a>
                           <select class="form-control select2 school" name="work_alloted_id" style="width: 100%;" required="">
                              @if(!empty($schools))
                              @foreach($schools as $school)
                              <option value="{{ $school->id }}">{{ $school->name }} ({{ $school->school_code }})</option>
                              @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                     <div class="col-6">
                       
                        <div class="form-group">

                          <input type="radio" name="emotion" value="male" id="sad" class="input-hidden gender" checked="" />
                          <label for="sad">
                            <img src="{{ url('public/boy.png') }}" alt="I'm sad" style="width: 40px; margin-right: 10px; height: auto;" />
                          </label>

                          <input 
                            type="radio" name="emotion"  value="female"
                            id="happy" class="input-hidden gender" />
                          <label for="happy">
                            <img src="{{ url('public/girl.png') }}" 
                              alt="I'm happy" style="width: 40px; height: auto;" />
                          </label>


                         
                        </div>
                     </div>
                     <div class="col-6">
                        
                        <div class="form-group">

                           <input 
                            type="radio" name="season" 
                            id="season" class="input-hidden season" value="summer" checked=""/>
                          <label for="season">
                            <img 
                              src="{{ url('public/sun.jpg') }}"
                              alt="I'm sad" style="width: 40px; margin-right: 10px; height: auto;" />
                          </label>

                          <input 
                            type="radio" name="season"
                            id="winter" class="input-hidden season" value="winter"/>
                          <label for="winter">
                            <img 
                             src="{{ url('public/winter.jpg') }}"   
                              alt="I'm happy" style="width: 40px; height: auto;" />
                          </label>
                           
                        </div>
                     </div>
                      <div class="col-12 multiselectclass">
                        <div class="form-group">
                           <label style="width: 100%;"><b>Item : </b>
                           </label>
                           <select class="form-control multiselect items" name="items[]" style="width: 100%;" required="" multiple="multiple">
                              @if(!empty($items))
                              @foreach($items as $item)
                              <option value="{{ $item->id }}"> {{ $item->name }}</option>
                              @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                     <div class="col-8">
                        <div class="form-group">
                           <label><b>Class: </b>
                           </label>
                           <select class="form-control select2 standard" name="work_alloted_id" style="width: 100%;" required="">
                              <option value="13">Nrs</option>
                              <option value="14">K.g</option>
                              <option value="15">Prep/UKG</option>
                              <option value="1">1</option>
                              <option  value="2">2</option>
                              <option  value="3">3</option>
                              <option  value="4">4</option>
                              <option  value="5">5</option>
                              <option  value="6">6</option>
                              <option  value="7">7</option>
                              <option  value="8">8</option>
                              <option  value="9">9</option>
                              <option  value="10">10</option>
                              <option  value="11">11</option>
                              <option  value="12">12</option>
                              <option value="16">Junior kg</option>
                              <option value="17">senior kg</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="form-group" style="margin-bottom: 0px!important; margin-top: 33px; text-align: right; ">
                           <button type="button" class="btn btn-primary filterclick" style="padding: 4px 10px!important"> <i class="fa fa-search" aria-hidden="true" style="font-size: 13px;"></i> Filter <span class="spinner"></span></button>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <hr>
            <section class="content">
               <div class="col-12 loaddata" style="margin-bottom: 15px;">
                 <div class="" style="width: 100%; text-align: center;">No records found.</div>
                 

                  
               </div>
            </section>
         </div>
         <div id="myModal" class="modal fade filtermodal" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              
              <div class="modal-body loadimages">
               
              </div>
              
            </div>

          </div>
        </div>

<!--/. container-fluid -->
<div class="modal fade add_modal" style="    z-index: 1042;">
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
<div class="modal fade send_order" >
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header" style="padding: 5px 15px;">
            <h5 class="modal-title">Send Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form autocorrect="off" action="{{ route('admin.pendingstock.sendorderimage') }}" autocomplete="off" method="post" class="form-horizontal form-bordered sendorderform">
                {{ csrf_field() }}
            <div class="send_order_id">
            </div>
            <div class="col-md-12 item_master" >
                <div class="form-group">
                    <label style="font-size: 14px;"><b>Vendor: </b>
                    </label>
                    <select class="form-control vendor_id" id="vendor_id" name="vendor_id" required="">
                        <option value="">
                            Select Vendor
                        </option>
                        @if(!empty($vendors))
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">
                                    {{ $vendor->name }} ({{$vendor->whatsapp_no}})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-12">
             <div class="form-group">
                <button type="submit" class="btn btn-info  pull-right"><i class="fa fa-whatsapp"></i> Send <span class="spinner"></span></button>
             </div>
            </div>
            </form>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade add_modaluniform uniform" style="z-index: 1042;     height: auto;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content "  >
            <div class="modal-header" style="padding: 5px 15px;">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body addholidaybodyuniform" style="padding: 0px 15px;">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@push('links')
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick.css">
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css" integrity="sha512-4a1cMhe/aUH16AEYAveWIJFFyebDjy5LQXr/J/08dc0btKQynlrwcmLrij0Hje8EWF6ToHCEAllhvGYaZqm+OA==" crossorigin="anonymous" />
@endpush
@push('script')


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
<script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://kenwheeler.github.io/slick/slick/slick.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js" integrity="sha512-+m6t3R87+6LdtYiCzRhC5+E0l4VQ9qIT1H9+t1wmHkMJvvUQNI5MKKb7b08WL4Kgp9K0IBgHDSLCRJk05cFUYg==" crossorigin="anonymous"></script>
 <script type="text/javascript">
        function generaterandomnumber() {

              var rendomnumber = Math.floor((Math.random() * 1000000) + 1);
              return rendomnumber;
            }
            function unique(array){
            return array.filter(function(el, index, arr) {
                return index === arr.indexOf(el);
            });
        }
        function loadsizes(item_id){
                $.ajax({
                        url: "{{ route('admin.pendingstock.loadsize')}}",
                        type: 'POST',
                        data:{item_id:item_id},
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            $('.loadsize').html(data);
                            $('.dddsizevalue').each(function() { 
                                if($(this).val() != ''){
                                    var id = parseInt($(this).val()); 
                                    
                                    $('.itemselected'+id).addClass('active');
                                }
                            });

                        },
                    });
            }
        // Get the modal
        var modal = document.getElementById("myModal");

        

        /*// Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }*/


         $(document).ready(function(){
          $('body').on('click','.sendtovendor',function(){
                $('.send_order_id').html('');
                
                 // Create a hidden element
                 $('.send_order_id').append(
                     $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'id[]')
                        .val($(this).data('id'))
                 );
                  
                
                $('.send_order').modal('show');
            });
          $('body').on('click', '.openaddmodaluniform', function () {
            
            $.ajax({
                url: "{{ route('admin.uniform.getmodalsmall')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend:function() {
                  var src = "{{ url('public/loder.gif') }}"
                  $('.addholidaybodyuniform').html('<div class="loading" style="text-align: center;    height: 400px;    line-height:400px;"><image src='+src+'></div>');
                },
                success: function (data) {
                    $('.addholidaybodyuniform').html(data);
                    $('.itemdatatable').DataTable({
                      "drawCallback": function( settings ) {
                          $('.clickzoom').magnificPopup({
                                type: 'image',
                                zoom: {
                                    enabled: true,
                                    duration: 300 // don't foget to change the duration also in CSS
                                }
                            });
                      }
                  });
                    

                },
            });
        });
          $('body').on('click', '.openaddmodal', function () {
            
            $.ajax({
                url: "{{ route('admin.uniform.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend:function() {
                  var src = "{{ url('public/loder.gif') }}"
                  $('.addholidaybody').html('<div class="loading" style="text-align: center;    height: 400px;    line-height:400px;"><image src='+src+'></div>');
                },
                success: function (data) {
                    $('.addholidaybody').html(data);
                    $('.itemdatatable').DataTable({
                      "drawCallback": function( settings ) {
                          $('.clickzoom').magnificPopup({
                                type: 'image',
                                zoom: {
                                    enabled: true,
                                    duration: 300 // don't foget to change the duration also in CSS
                                }
                            });
                      }
                  });
                    

                },
            });
        });
          $('body').on('click','.deletesize',function(){
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
                    url: '{{ url("admin/pendingstock/") }}/' + id,
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
                             var item_id = $('.item_id').val();
                            loadsizes(item_id);
                            $('.removeitem'+id).remove();
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
            });
          });
          $('body').on('submit', '.sendorderform', function (e) {
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
                        $('.send_order').modal('hide');
                        
                        
                        toastr.success(data.msg,'Success!')
                        
                        
                        
                    }
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
                          $('.edit_modal').modal('hide');
                          $('#stocks').DataTable().ajax.reload();
                          toastr.success(data.msg,'Success!')
                      }
                  },
              });
          });
            $('body').on('click','.formdisplay',function(){
                $('.sizevalue').val('');
                $('.formsubmitvalue').toggle('displaynone');
            })
            $('.multiselect').multiselect({
                maxHeight: 200,
                includeSelectAllOption: true
            });
            $('body').on('click','.submitvalue',function(){
                var size = $('.sizevalue').val();
                var item_id = $('.item_id').val();
                
                if(size == ''){
                    toastr.error('Size field is required.','Error!')
                }else{
                    $.ajax({
                        url: "{{ route('admin.pendingstock.addsize')}}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {size: size,item_id:item_id},
                        beforeSend:function(){
                            $('.spinclass').css('display','block')
                        },
                        success: function (data) {


                            $('.spinclass').css('display','none')
                            if (data.status == 400) {
                                toastr.error(data.msg)
                            }
                            if (data.status == 200) {
                                $('.sizevalue').val('');
                                $('.size').val('');
                                loadsizes(item_id);
                            }


                        },
                    });
                    
                }
            })
            $('body').on('click','.removerowvisa',function(){
            var id = $(this).data('id');
            $('.removeitem'+id).remove();
            $('.itemselected'+id).removeClass('active');
        })
        $('body').on('click','.addrow',function(){

        rendomnumber = generaterandomnumber();
        //var options = $('.loadsize').get(0).outerHTML;
        var default_size = $('.default_size').val();
        var sizedrop = $(this).data('sizeid');
        var size = $(this).data('size');

        var ek=[];

        $('.dddsizevalue').each(function() { 
            if($(this).val() != ''){
                ek.push(parseInt($(this).val())); 
            }
        });
        var ek = unique(ek);
        if($.inArray(sizedrop, ek) > -1){
            $('.itemselected'+sizedrop).removeClass('active');
            $('.removeitem'+sizedrop).remove();
        }else{

            var html = `<fieldset class="removeitem`+sizedrop+` remove`+rendomnumber+` sizeorder" data-index="`+size+`">
            <legend>
               Quntity Info <i class="fa fa-trash removerowvisa" data-id="`+sizedrop+`" style="color:red; cursor:pointer;"></i>
            </legend>
            <input type="hidden" value="`+sizedrop+`" class="dddsizevalue">
              <div class="row">
               <div class="col-sm-2 col-md-2">
                  <div class="form-group">
                     <label>Size <span style="color: red">*</span></label>
                     <select class="form-control" name="stock[`+rendomnumber+`][size]" required>
                       <option value="`+sizedrop+`">`+size+`</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-3 col-md-3">
                  <div class="form-group">
                     <label>Quantity <span style="color: red">*</span></label>
                     <input type="number" class="form-control" value="`+default_size+`" name="stock[`+rendomnumber+`][quantity]" min="0" max="100000" required>
                  </div>
               </div>
               <div class="col-sm-7 col-md-7">
                  <div class="form-group">
                     <label>Remark </label>
                     <textarea class="form-control" name="stock[`+rendomnumber+`][remark]" placeholder="Remark"></textarea>
                  </div>
               </div>
              </div>
            </fieldset>`;
            $('.itemselected'+sizedrop).addClass('active');
            $('.addnewrow').append(html);

            $('.addnewrow').each(function(){
                var $this = $(this);
                $this.append($this.find('.sizeorder').get().sort(function(a, b) {
                    return parseFloat($(a).data('index')) - parseFloat($(b).data('index'));
                }));
            });

        }

    })
             /********* add new School ********/
              $('body').on('click', '.openaddmodal', function () {

                  $('.modal-title').text('Add Stock');
                  $.ajax({
                      url: "{{ route('admin.pendingstock.getmodal')}}",
                      type: 'POST',
                      headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      
                      success: function (data) {
                          $('.addholidaybody').html(data);
                          /******** cityselectwithstatecountry dropdown **********/
                          $('[data-toggle="tooltip"]').tooltip();
                          
                          $('.status').select2();


                      },
                  });
              });
              $('body').on('change','.item_masters',function(){
                  var item_id = $(this).val();
                  if(item_id != ''){

                      var image = $(this).find(':selected').data('image');
                      var url = "{{ url('public/uniforms/')}}/"+image;
                      $('.loadimage').html(`<a class="clickzoon" href="`+url+`"><img src="`+url+`" style="width: auto; height: 240px; box-shadow: 7px 9px 9px -9px black;    border: 1px solid #ccc; max-width: 320px; border-radius: 10px;">`);
                      $('.clickzoon').magnificPopup({
                              type: 'image',
                              zoom: {
                                  enabled: true,
                                  duration: 300 // don't foget to change the duration also in CSS
                              }
                          });
                  }else{
                      $('.loadimage').html('');
                  }
              });
              $('body').on('change','.status',function(){
                $('.addnewrow').html('');
                var id = $(this).val();
                if(id != ''){
                    $('.sizefieldset').css('display','block');
                    $('.item_id').val(id);
                    $.ajax({
                        url: "{{ route('admin.reports.changedropvalue')}}",
                        type: 'POST',
                        data:{id:id},
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            $('.item_masters').html(data);
                            $('.item_masters').select2();
                            $('.loadimage').html('');
                            loadsizes(id);
                        },
                    });
                }else{
                    $('.sizefieldset').css('display','none');
                }
            });
            $('body').on('click','.myImg',function(){              
              $("#myModal").modal();
              var school = $(this).data('school');
              var gender = $(this).data('gender');
              var season = $(this).data('season');
              var item = $(this).data('item');
              var standard = $(this).data('standard');
              var selectedimage = $(this).data('selectedimage');
              $.ajax({
                    url: "{{ route('admin.loadimages') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{school:school,gender:gender,season:season,standard:standard,item:item},
                    beforeSend: function () {
                        var image = "{{ url('public/loading.gif') }}";
                        $('.loadimages').html('<div style="width:100%; height:200px; padding-top:67px; text-align:center;"><img src="'+image+'"></div>');
                    },
                    success: function (data) {
                        $('.loadimages').html(data);
                        
                        $('.slickslide').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            initialSlide: selectedimage,

                        });
                        
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
            });
           
         
         
           $('.filterclick').click(function(){
                var school =  $('.school').val();
                var gender = $(".gender:checked").val(); 
                var season = $('.season:checked').val();
                var standard = $('.standard').val();
                var items = $('.items').val();
                $.ajax({
                    url: "{{ route('admin.filterdata') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{school:school,gender:gender,season:season,standard:standard,items:items},
                    beforeSend: function () {
                        $('.spinner').html('<i class="fa fa-spinner fa-spin" aria-hidden="true" style="font-size:13px;"></i>');
                    },
                    success: function (data) {
                        $('.spinner').html('');
                        $('.loaddata').html(data);
                        $('.one-time').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,

                        });
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
           });
         })
      </script>
      <script type="text/javascript">
         $('.select2').select2();
      </script>
@endpush
@endsection