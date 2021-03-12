<div class="card card-info card-outline">
   <div class="card-body" style="padding: 10px 15px;">
      <div class="col-md-12" style="padding: 0px; text-align: center; ">
         <img src="{{ url('public/uniforms/'.$item->image) }}" width="500px;">
      </div>
   </div>
</div>
<div class="card  card-outline">
   <div class="card-body">
      <div class="col-md-12"  style="padding: 0px;">
         <table id="customers">
            <tr>
               <th style="width: 25%;">School</th>
               <th>Standard</th>
               <th>Total</th>
            </tr>
            @php $mytotal = 0; @endphp
            @if(!empty($return))
            @foreach($return as $schoolid => $gender)
            @php $schooltotal = 0; @endphp
            <tr>
               <td>{{ getschoolname($schoolid) }}</td>
               <td>
                  @if(!empty($gender))
                  @foreach($gender as $standard => $tpye)
                  <h6>{{ getstdname($standard) }} 
                     @if(!empty($tpye))
                     @foreach($tpye as $gender => $name)
                     @if($gender == 'male')
                     @php $mtoal = getvaluetotalin($standard,$schoolid,'boys'); 
                     $schooltotal += $mtoal
                     @endphp
                     <b>Boys</b>({{ $mtoal }})
                     @endif
                     @if($gender == 'female')
                     @php $ftoal = getvaluetotalin($standard,$schoolid,'girls');
                     $schooltotal += $ftoal
                     @endphp
                     <b>Girls</b>({{ $ftoal }})
                     @endif
                     @endforeach
                     @endif
                  </h6>
                  @endforeach
                  @endif
               </td>
               <td>{{ $schooltotal }}</td>
            </tr>
            @php $mytotal += $schooltotal; @endphp
            @endforeach
            @endif
            <tr>
               <td  style="text-align: right;" colspan="2">Total</td>
               <td>{{ $mytotal  }}</td>
            </tr>
         </table>
      </div>
   </div>
</div>