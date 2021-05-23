<style type="text/css">
   .timeline::before{
      background: #c2c3c4;
   }
</style>
<!-- Timelime example  -->
<div class="row">
   <div class="col-md-12">
      <!-- The time line -->
      @if(count($histories) > 0)
      <div class="timeline">
         <!-- timeline time label -->
         @foreach($histories as $key => $value)
            <div class="time-label">
               <span class="bg-red">{{ date('d M Y',strtotime($key))}}</span>
            </div>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            @if(!empty($value))
            @foreach($value as $val)
               @if($val->status == 'pending')
                  @php  $class = "fa fa-clock-o";$bclor = "#bf1731"; $color = "#ffff"; @endphp
               @elseif($val->status == 'ordered' || $val->status == 'delivered' ||  $val->status == 'partially_delivered')
                  @php  $class = "fa fa-check"; $bclor = "#14a544";$color = "#ffff"; @endphp
               @elseif($val->status == 'cancelled')
                  @php $class = "fa fa-pause";$bclor = "#504e54;";$color = "#ffff"; @endphp
               @elseif($val->status == 'dispatched')
                  @php $class = "fa fa-bandcamp";$bclor = "#f12222";$color = "#ffff"; @endphp
               @endif
               <div>
                  <i class="{{ $class }}" style="background-color: {{ $bclor }};color: {{ $color }}"></i>
                  <div class="timeline-item">
                     <span class="time" style="color: #000;"><i class="fas fa-clock"></i> {{ timeAgo($val->created_at) }}</span>
                     <h3 class="timeline-header" style="border: 1px solid #a9a9a9;"> <b>{{ $val->status ?? ''}} </b></h3>
                     <div class="timeline-body" style="border: 1px solid #a9a9a9;">
                        {{ $val->remarks  ?? 'No remarks' }}
                         @if($val->status == 'partially_delivered')
                           <br><b>Received Quauntity :</b> {{ $val->received_qty ?? 0 }}
                         @endif
                         
                        
                     </div>
                  </div>
               </div>
            @endforeach
            @endif
         @endforeach
         <div>
            <i class="fas fa-clock bg-gray"></i>
         </div>
      </div>
      @endif
      @if(count($histories) == 0)
      <h3 style="text-align: center; font-size: 16px;"> No Logs Found</h3>
      @endif
   </div>
   <!-- /.col -->
</div>