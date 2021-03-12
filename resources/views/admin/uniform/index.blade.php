@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Uniform Information')
<style type="text/css">
  @media (min-width: 576px) {
  .uniform .modal-dialog { max-width: none; }
}

.uniform .modal-dialog {
  width: 91%;
  height: 90%;
  padding: 0;
}

.uniform .modal-content {
  height: 95%;
}
</style>

   <!-- Info boxes -->
   <div class="row" style="padding: 0px 15px; margin-top: 15px;">
      <div class="col-md-3 col-sm-12 scoolupload" >
        <div class="col-md-12" style="float: left; padding: 0px; margin-bottom: 10px;">
          <a href="#" data-toggle="modal" data-typeid="" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" data-id="" style="float: right; "><i class="fa fa-plus"></i> Add New</a>  
        </div>
        <div class="col-md-12" style="float: left; padding: 0px; " >
         <div class="card card-info card-outline displaybl" style="">
            <div class="card-body" style="padding: 10px 15px;">
               <div class="col-lg-12">
                  <div class="form-group row " style="margin-bottom: 0px;">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label><b>School: </b>
                           </label>
                           <select class="form-control school" id="status" name="status">
                                <option value="">Select School</option>
                              @if(!empty($schools))
                                @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }} ({{ $school->school_code }})</option>
                                @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-12 ">
                        <div class="form-group">
                          <input type="radio" name="emotion" id="sad" value="male" class="input-hidden gender" checked=""/>
                          <label for="sad">
                            <img src="{{ url('public/boy.png') }}" alt="I'm sad" style="width: 40px; margin-right: 10px; height: auto;" />
                          </label>

                          <input 
                            type="radio" name="emotion" id="happy" value="female"  class="input-hidden gender" />
                            <label for="happy">
                              <img src="{{ url('public/girl.png') }}" alt="I'm happy" style="width: 40px; height: auto;" />
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        
                        <div class="form-group">

                           <input  type="radio" name="season" id="season" value="summer" class="input-hidden season" checked="" />
                          <label for="season">
                            <img src="{{ url('public/sun.jpg') }}" 
                              alt="I'm sad" style="width: 40px; margin-right: 10px; height: auto;" />
                          </label>

                          <input type="radio" name="season" id="winter" value="winter" class="input-hidden season"/>
                          <label for="winter">
                            <img  src="{{ url('public/winter.jpg') }}"  
                              alt="I'm happy" style="width: 40px; height: auto;" />
                          </label>
                           
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label><b>Class:</b>
                           </label>
                           <select class="form-control standard" id="status1" name="status">
                                <option value="">Select Class</option>
                                 <option value="13">Nrs</option>
                                <option value="14">K.g</option>
                                <option value="15">Prep/UKG</option>
                                <option value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                <option value="5">5th</option>
                                <option value="6">6th</option>
                                <option value="7">7th</option>
                                <option value="8">8th</option>
                                <option value="9">9th</option>
                                <option value="10">10th</option>
                                <option value="11">11th</option>
                                <option value="12">12th</option>
                                <option value="16">Junior kg</option>
                                <option value="17">senior kg</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <button class="btn btn-success btn-sm searchdata"style="display: inline-flex;" >Load <span class="spinner" style="margin-left: 5px;"> </span></button>
                     </div>

                     <div class="loafcopydropdown" style="width: 100%; display: none;">
                      <div class="col-md-12" style="margin-top: 20px;">
                        <div class="form-group">
                           <label><b>Copy From :</b>
                           </label>
                           <select class="form-control copystandard select2" id="status" name="status">
                                <option value="13">Nrs</option>
                                <option value="14">K.g</option>
                                <option value="15">Prep/UKG</option>
                                <option value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                <option value="5">5th</option>
                                <option value="6">6th</option>
                                <option value="7">7th</option>
                                <option value="8">8th</option>
                                <option value="9">9th</option>
                                <option value="10">10th</option>
                                <option value="11">11th</option>
                                <option value="12">12th</option>
                                <option value="16">Junior kg</option>
                                <option value="17">senior kg</option>

                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                          <label style="width: 100%;"><b>Gender :</b></label>
                          <div class="custom-control custom-radio" style="display: inline-block;">
                            <input class="custom-control-input copygender" type="radio" value="male" id="customRadio1" name="gendercopy" checked="">
                            <label for="customRadio1" class="custom-control-label" >Male</label>
                          </div>
                          <div class="custom-control custom-radio" style="display: inline-block;">
                            <input class="custom-control-input copygender" type="radio" value="female" id="customRadio2" name="gendercopy" >
                            <label for="customRadio2" class="custom-control-label">Female</label>
                          </div>
                        
                      </div>
                     <div class="col-md-12">

                     <div class="form-group">
                      <label style="width: 100%;"><b>Season :</b></label>
                        <div class="custom-control custom-radio"  style="display: inline-block;">
                          <input class="custom-control-input copyseason" value="summer" type="radio" id="customRadio3" name="seasoncopy" checked="">
                          <label for="customRadio3" class="custom-control-label">Summer</label>
                        </div>
                        <div class="custom-control custom-radio"  style="display: inline-block;">
                          <input class="custom-control-input copyseason" value="winter" type="radio" id="customRadio4" name="seasoncopy" >
                          <label for="customRadio4" class="custom-control-label">Winter</label>
                        </div>
                       
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button class="btn btn-success btn-sm copydatarecord" style="display: inline-flex; background: #f5af12; border:1px solid #000; color: #000;" >Copy <span class="spinnercopy" style="margin-left: 5px;"> </span></button>
                    </div>
                     </div>
                  </div>
                  
               </div>
            </div>
            <!-- /.card -->
         </div>
       </div>
      </div>
      <div class="col-md-9 col-sm-12" >
          <div class="card card-info card-outline displaybl" style="">
            <div class="card-body loaduniform" style="padding: 10px 15px;">
              <div style="width: 100%;"> Please select School,Gender,Season,Standard and then load.
            </div>
          </div>
      </div>
   <!-- /.row -->


<div class="modal fade openimage" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 99999; margin-top: 5%;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">              
      <div class="modal-body loadimage" style="text-align: center;">
      </div>
    </div>
  </div>
</div>
<div class="modal fade add_modal uniform" >
    <div class="modal-dialog ">
        <div class="modal-content "  >
            <div class="modal-header" style="padding: 5px 15px;">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body addholidaybody" style="padding: 0px 15px;">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@push('links')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css" rel="stylesheet"/>
@endpush
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script type="text/javascript">

  function load() {
      $("body").addClass("loading");
    }
    function unload() {
      $("body").removeClass("loading");
    }
  
  function savereitemvalue(id,textvalue){
    var school = $('.school').val();
    var gender = $(".gender:checked").val(); 
    var season = $('.season:checked').val();
    var standard = $('.standard').val();

    var fd = new FormData();
    fd.append('school',school);
    fd.append('gender',gender);
    fd.append('season',season);
    fd.append('standard',standard);
    fd.append('item_id',id);
    fd.append('textvalue',textvalue);
    

      $.ajax({
        url: '{{ route("admin.uniform.savesize") }}',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        async:false,
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
          if(response.status == 200){
            loaduniform();
          }
        },
    });
  }

  function saverelable(type,id,field,textvalue){
    var school = $('.school').val();
    var gender = $(".gender:checked").val(); 
    var season = $('.season:checked').val();
    var standard = $('.standard').val();
    var selectvalue = $('.selectvalue'+type+id).val();

    var fd = new FormData();
      fd.append('field',field);
      fd.append('selectvalue',selectvalue);
      fd.append('school',school);
      fd.append('gender',gender);
      fd.append('season',season);
      fd.append('standard',standard);
      fd.append('item_id',id);
      fd.append('textvalue',textvalue);

      $.ajax({
        url: '{{ route("admin.uniform.savetext") }}',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: fd,
        async:false,
        contentType: false,
        processData: false,
        success: function(response){
          if(response.status == 200){
            loaduniform();
          }
        },
    });
  }
  $('body').on('click','.image_preview1',function(){
      var image = $(this).attr('original');
      $('.openimage').modal('show');
      $('.loadimage').html('<img src="'+image+'" style="max-width:400px; max-height:400px;">');
  });
  $('body').on('change', '.logo_image', function() {
            readURL(this, 'image_preview');
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
                    $('.spinneritem').html('<i class="fa fa-spinner fa-spin"></i>')
                    $('.submititem').prop('disabled', true);
                },
                success: function (data) {
                   $('.submititem').prop('disabled', false);
                    if (data.status == 400) {
                        $('.spinneritem').html('');

                        toastr.error(data.msg)
                    }
                    if (data.status == 200) {
                        $('.spinneritem').html('');
                        $('.loadfullhtml').html(data.html);
                        $('.itemdatatable').DataTable();
                        $(".formsubmit")[0].reset();
                        $('.removeimage').attr('src', "{{url('public/company/employee/shirt.png')}}");
                        $('.itemid').val('');
                        $('.submitbutton').html('Submit <span class="spinneritem"></span>');
                        var school = $('.school').val();
                        var standard = $('.standard').val();
                        if(school != '' && standard != ''){
                          loaduniform();
                        }

                       
                    }
                },
            });
        });
  function loaduniform(){
      var school = $('.school').val();

      var gender = $(".gender:checked").val(); 
      var season = $('.season:checked').val();
      var standard = $('.standard').val();


      if(school == ''){
        toastr.error('Please select school.', 'Oh No!');
      }else if(gender == ''){
        toastr.error('Please select gender.', 'Oh No!');
      }else if (season == ''){
        toastr.error('Please select season.', 'Oh No!');
      } else if  (standard == ''){
        toastr.error('Please select standard.', 'Oh No!');
      } else{
        $.ajax({
            url: '{{ route("admin.uniform.loaduniform") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {school:school,gender:gender,season:season,standard:standard},
            beforeSend: function() {
              $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>');
              load()
            },
            success: function (data) {
              $('.spinner').html('');
              $('.loaduniform').html(data);
              $('[data-toggle="tooltip"]').tooltip();
              $('.loafcopydropdown').css('display','block');

              unload();
            },
            error: function () {
              unload();
                toastr.error('Something went wrong!', 'Oh No!');

            }
        });
      }
  }
  $(document).ready(function(){

  
    $('.school').select2();
    $('.standard').select2();
    $('body').on('click', '.edititem', function () {
      var item_id = $(this).data('item_id');
      if(item_id == ''){
        item_id = 1;
      }
      $('.item_name').val($(this).data('name'));
      $('.item_id').val(item_id);
      $('.rack_number').val($(this).data('ract_number'));
      $('.image_preview').attr('src', $(this).data('image'));
      $('.itemid').val($(this).data('id'));
      $('.submitbutton').html('Update <span class="spinneritem"></span>');
      
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
                    $('.itemdatatable').DataTable();

                },
            });
        });
    $('body').on('blur','.focuschange',function(){
      var type = $(this).data('type');
      var id = $(this).data('id');
      var field = $(this).data('field');
      var textvalue = $(this).val();
      saverelable(type,id,field,textvalue);
    })

    $('body').on('change','.focuschangedropdown',function(){
      var type = $(this).data('type');
      var id = $(this).data('id');
      var field = $(this).data('field');
      var textvalue = $(this).val();
      saverelable(type,id,field,textvalue);
    })
    

    
    $('body').on('blur','.focusitem',function(){
      var id = $(this).data('id');
      var textvalue = $(this).val();
      savereitemvalue(id,textvalue);  
      
      
    })

    $('body').on('keypress','.focusitem',function(e){
    
      if (e.which == 13) {
        var id = $(this).data('id');
        var textvalue = $(this).val();
        savereitemvalue(id,textvalue);
        
      }
    });

    $('body').on('keypress','.focuschange',function(e){
    
      if (e.which == 13) {
         var type = $(this).data('type');
          var id = $(this).data('id');
          var field = $(this).data('field');
          var textvalue = $(this).val();
          saverelable(type,id,field,textvalue);
      }
    });
    $('body').on('click','.deleteicon',function(){
      var deleteid = $(this).data('deleteid');
      $.ajax({
            url: '{{ route("admin.uniform.delete") }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {deleteid:deleteid},
            
            success: function(response){
              if(response.status == 200){
                toastr.success('success.', 'Success!');
                loaduniform();
              }
              if(response.status == 400){
                toastr.error(response.msg, 'Error!');
                
              }
            },
        });
    })
  

    $('body').on('click','.copydatarecord',function(){
      var school = $('.school').val();
      
      var gender = $(".copygender:checked").val(); 
      var season = $('.copyseason:checked').val();
      var standard = $('.copystandard').val();
      

      var tostandard = $('.standard').val();
      var togender = $(".gender:checked").val(); 
      var toseason = $('.season:checked').val();

      (new PNotify({
          title: "Confirmation Needed",
          text: "Are you sure you wants to copy?",
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
              url: '{{ route("admin.uniform.copyfinal") }}',
              type: 'POST',
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              data:{ standard:standard,school:school,gender:gender,season:season,tostandard:tostandard,togender:togender,toseason:toseason
              },
              beforeSend: function () {
                $('.spinnercopy').html('<i class="fa fa-spinner fa-spin"></i>');
              },
              success: function (data) {
                $('.spinnercopy').html('');
                  if (data.status == 400) {
                      toastr.error(data.msg, 'Oh No!');
                  }
                  if (data.status == 200) {
                      toastr.success(data.msg, 'Success!');
                      loaduniform();
                  } 
              },
              
          });
      });
    })

    
     $('body').on('click','.sizechange',function(){
      $(this).css('display','none');
      var id = $(this).data('id');
      $('.displayitem'+id).css('display','block');
      $('.displayitem'+id).focus(); 
    })

    $('body').on('click','.labelpart',function(){
      $(this).css('display','none');
      var type = $(this).data('type');
      var id = $(this).data('id');
      $('.displayname'+type+id).css('display','block');
      $('.displayname'+type+id).select2();
      $('.displayname'+type+id).focus(); 
    })

    $('body').on('click','.remark',function(){
      $(this).css('display','none');
      var type = $(this).data('type');
      var id = $(this).data('id');
      $('.displayremark'+type+id).css('display','block');
      $('.displayremark'+type+id).focus(); 
    })
    
    $('body').on('click','.searchdata',function(){
      loaduniform();

    });
    /*$('body').on('click','.imageclick',function(){
      var id = $(this).data('id');
      var type = $(this).data('type');
      $(".openfile"+type+id).click();
    });*/
    $('body').on('change', '.imageUpload', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            toastr.error("Please Upload valid image", 'Error!');
        }else{
            var school = $('.school').val();
            var gender = $(".gender:checked").val(); 
            var season = $('.season:checked').val();
            var standard = $('.standard').val();
            var selectvalue = $('.selectvalue'+type+id).val();

            var fd = new FormData();
            fd.append('file',file);
            fd.append('selectvalue',selectvalue);
            fd.append('school',school);
            fd.append('gender',gender);
            fd.append('season',season);
            fd.append('standard',standard);
            fd.append('item_id',id);

            $.ajax({
              url: '{{ route("admin.uniform.saveimage") }}',
              type: 'post',
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              data: fd,
              contentType: false,
              processData: false,
              beforeSend: function() {
                load();
              },
              success: function(response){
                unload();
                if(response.status == 200){
                  loaduniform();
                }
              },
          });


            readURL(this, 'preview'+type+id);
        }
    });
  })
/************** display image preview **********/
 function readURL(input, classes) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.' + classes).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}



</script>

@endpush
@endsection