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
.modal {
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
.modal-content {
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
  .modal-body {
   
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
 .modal{
  padding-top: 5%!important;
 }
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
         <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              
              <div class="modal-body loadimages">
               
              </div>
              
            </div>

          </div>
        </div>
@push('links')
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick.css">
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
@endpush
@push('script')


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
<script src="{{ URL::asset('public/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://kenwheeler.github.io/slick/slick/slick.js"></script>
 <script type="text/javascript">
        // Get the modal
        var modal = document.getElementById("myModal");

        

        /*// Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }*/


         $(document).ready(function(){
            $('.multiselect').multiselect({
                maxHeight: 200,
                includeSelectAllOption: true
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