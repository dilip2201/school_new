<style>
   hr {
   margin-top: 0.5rem; 
   margin-bottom: 0.5rem; 
   border: 0;
   border-top: 1px solid rgba(0,0,0,.1);
   }
   #accordion tr,#accordion td,#accordion th{
    border: 1px solid #828282!important;
   }
   .myaccordion .card,
   .myaccordion .card:last-child .card-header {
   }
   .myaccordion .card-header {
   border-bottom-color: #004987;
   background: transparent;
   }
   .myaccordion .fa-stack {
   font-size: 18px;
   }
   .myaccordion .btn {
   width: 100%;
   font-weight: bold;
   color: #004987;
   padding: 0;
   }
   .myaccordion .btn-link:hover,
   .myaccordion .btn-link:focus {
   text-decoration: none;
   }
   .myaccordion li + li {
   margin-top: 10px;
   }
</style>
<div class="row">
   <div class="col-md-6">
      <!-- Profile Image -->
      <div class="card card-primary">
         <div class="card-header" style="background-color: #6f6767;padding: 5px 10px;">
            <h3 class="card-title"><b>About Owner</b></h3>
         </div>
         @php $image = url('public/company/employee/default.png'); @endphp
         @if(!empty($school) && file_exists(public_path().'/company/employee/'.$school->o_image) && !empty($school->o_image))
         @php $image = url('public/company/employee/'.$school->o_image);  @endphp
         @endif
         <div class="card-body box-profile" style="border: 1px solid #c1c1c1;padding: 0.25rem;">
            <div class="text-center" style="float: left;">
               <span style=""><img src="{{$image}}" class="image_preview profile-user-img" style="width: 80px;
                  height: 78px;margin-top: 10px; margin-left: 10px;"></span>
            </div>
            <h3 class="profile-username text-center" style="margin-right: 90px;">@if(empty( $school->o_name))  Anonymous  @else {{ $school->o_name ?? ' - ' }} @endif</h3>
            <ul class="list-group list-group-unbordered mb-3">
               <li class="list-group-item" style="margin-left: 30px">
                  <i class="fa fa-phone" aria-hidden="true"></i> <b> </b> : {{ $school->o_number ?? ' - ' }} <a class="float-right"> </a>
               </li>
            </ul>
         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <!-- About Me Box -->
      <!-- /.card -->
   </div>
   <div class="col-md-6">
      <!-- Profile Image -->
      <div class="card card-primary" >
         <div class="card-header" style="background-color: #6f6767;padding: 5px 10px;">
            <h3 class="card-title"><b>About Principal</b></h3>
         </div>
         <div class="card-body box-profile" style="border: 1px solid #c1c1c1;padding: 0.25rem;">
            <div class="text-center" style="float: left;">
               @php $image = url('public/company/employee/default.png'); @endphp
               @if(!empty($school) && file_exists(public_path().'/company/employee/'.$school->p_image) && !empty($school->p_image))
               @php $image = url('public/company/employee/'.$school->p_image);  @endphp
               @endif
               <span style=""><img src="{{$image}}" class="image_preview profile-user-img" style="width: 80px;
                  height: 78px;margin-top: 10px; margin-left: 10px;"></span>
            </div>
            <h3 class="profile-username text-center" style="margin-right: 90px;">@if(empty( $school->p_name))  @else {{ $school->p_name ?? ' - ' }}@endif</h3>
            <ul class="list-group list-group-unbordered mb-3">
               <li class="list-group-item" style="margin-left: 30px">

                  <i class="fa fa-phone" aria-hidden="true"></i> : {{ $school->p_number  ?? ' - '}}&nbsp;@if(empty( $school->p_birthdate))  @else| <b> <i class="fa fa-birthday-cake" aria-hidden="true"></i> </b> : {{ $school->p_birthdate ?? ' - '}} <a class="float-right"> </a>@endif
               </li>
            </ul>
         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <!-- About Me Box -->
      <!-- /.card -->
   </div>
   <!-- /.col -->
</div>
<div id="accordion" class="myaccordion">
   <div class="card" style="box-shadow: 0px 0px 3px #000;">
      <div class="card-header" id="headingOne">
         <h2 class="mb-0">
            <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            School Detail
            <span class="fa-stack fa-sm">
            <i class="fas fa-circle fa-stack-2x"></i>
            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
            </span>
            </button>
         </h2>
      </div>
      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
         <div class="card-body" style="padding: 10px 15px!important;">
            <strong><i class="fa fa-book" aria-hidden="true"></i>&nbsp; School Name :  </strong>{{ $school->name }}({{ $school->school_code }}) &nbsp;&nbsp;&nbsp; |  <strong><i class="fa fa-book" aria-hidden="true"></i>&nbsp; Total Students : </strong>{{ $school->total_students ?? ' - ' }} 
            <br>
            <hr>
            <strong><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp; Address :  </strong> {{ $school->address }}
            <br>
            <hr>
            <strong><i class="fas fa-map-marker-alt mr"></i>&nbsp;  Location :  </strong>{{ $school->city->name }},{{ $school->city->state->name }},{{ $school->city->state->country->name  }}
            @if(empty($school->s_anniversary))@else
            <hr>
            <strong><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;  School Anniversary :  </strong>{{ $school->s_anniversary }}@endif
         </div>
      </div>
   </div>
   <div class="card" style="box-shadow: 0px 0px 3px #000;">
      <div class="card-header" id="headingTwo" style="  border-bottom-color: #004987;
         background: transparent;">
         <h2 class="mb-0">
            <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Commission History
            <span class="fa-stack fa-2x">
            <i class="fas fa-circle fa-stack-2x"></i>
            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
            </span>
            </button>
         </h2>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
         <div class="card-body">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>Date</th>
                     <th>Amount</th>
                     <th>Remark</th>
                  </tr>
               </thead>
               <tbody>
                  @if(!empty($comisions))
                  @foreach($comisions as $comision)
                  <tr>
                     <td>{{ $comision->month ?? ' - ' }}, {{$comision->year ?? ' - '}}</td>
                     <td>{{ $comision->amount ?? ' - '}}</td>
                     <td>{{ $comision->remarks ?? ' - '}}</td>
                  </tr>
                  @endforeach
                  @endif
                  @if(count($comisions) == 0)
                  <tr>
                     <td style="text-align: center;" colspan="3"> No record found.</td>
                  </tr>
                  @endif
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="card" style="box-shadow: 0px 0px 3px #000;">
      <div class="card-header" id="headingthree" style="  border-bottom-color: #004987;
         background: transparent;">
         <h2 class="mb-0">
            <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
            History of change in uniform
            <span class="fa-stack fa-2x">
            <i class="fas fa-circle fa-stack-2x"></i>
            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
            </span>
            </button>
         </h2>
      </div>
      <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordion">
         <div class="card-body">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>Date</th>
                     <th>Item Name</th>
                     <th>Remark</th>
                  </tr>
               </thead>
               <tbody>
                  @if(!empty($itemsmasters))
                  @foreach($itemsmasters as $itemsmaster)
                  <tr>
                     <td>{{ $itemsmaster->month ?? ' - ' }}, {{$itemsmaster->year ?? ' - '}}</td>
                     <td>{{ $itemsmaster->docname ?? ' - '}}</td>
                     <td>{{ $itemsmaster->remarks ?? ' - '}}</td>
                  </tr>
                  @endforeach
                  @endif
                  @if(count($itemsmasters) == 0)
                  <tr>
                     <td style="text-align: center;" colspan="3"> No record found.</td>
                  </tr>
                  @endif
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<script>
   $("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
   $(e.target)
   .prev()
   .find("i:last-child")
   .toggleClass("fa-minus fa-plus");
   });
   
</script>