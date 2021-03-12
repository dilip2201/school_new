 <fieldset>
<legend style="padding: 0px!important;">
<select class="selecttype form-control">
    <option value="commission">Commission History</option>
    <option value="uniform_history">Change Uniform History</option>
</select>   
</legend>

<form  autocorrect="off" action="{{ route('admin.school.storecommision') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmitcomision">
    {{ csrf_field() }}

   
        <input type="hidden" name="schoolid" value="{{ $school_id }}">

    <div class="row">
     <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Month <span style="color: red">*</span></label>
            <select class="form-control select2" name="month" style="width: 100%;" required="">  
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option> 
            <option value="April">April </option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
            </select>
         </div>
      </div>
           <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Year <span style="color: red">*</span></label>
            <select class="form-control select2" name="year" style="width: 100%;" required=""> 
            <?php $firstYear = (int)date('Y') - 2;
            $lastYear = $firstYear + 7;
            for($i=$firstYear;$i<=$lastYear;$i++)
            {
                echo '<option value='.$i.'>'.$i.'</option>';
            }?> 
            
            </select>
         </div>
      </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Amount</label>
                <input type="number" class="form-control" name="amount"
                       placeholder="Amount"
                       value="" required="" maxlength="30">
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="form-group">
               
                        <label>Remarks</label>
                        <textarea class="form-control" rows="3" name="remarks" placeholder="Enter ..." required=""></textarea>
                
            </div>
        </div>

       
 
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
            </div>
        </div>
    </div>
</form>


<form  autocorrect="off" action="{{ route('admin.school.storehistoryuniform') }}" autocomplete="off" method="post" class="form-horizontal form-bordered formsubmithistory" style="display: none;">
    {{ csrf_field() }}
    <input type="hidden" name="schoolid" value="{{ $school_id }}">

    <div class="row">
     <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Month <span style="color: red">*</span></label>
            <select class="form-control select2" name="month" style="width: 100%;" required="">  
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option> 
            <option value="April">April </option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
            </select>
         </div>
      </div>
           <div class="col-sm-12 col-md-6">
         <div class="form-group">
            <label>Year <span style="color: red">*</span></label>
            <select class="form-control select2" name="year" style="width: 100%;" required=""> 
            <?php $firstYear = (int)date('Y') - 2;
            $lastYear = $firstYear + 7;
            for($i=$firstYear;$i<=$lastYear;$i++)
            {
                echo '<option value='.$i.'>'.$i.'</option>';
            }?> 
            
            </select>
         </div>
      </div>
        <div class="col-sm-12 col-md-6 multiselectclass">
            <div class="form-group">
                <label>Select Item</label>
                 <select class="form-control multiselect items" name="select_uniform[]" style="width: 100%;"  multiple="multiple">
                  @if(!empty($items))
                  @foreach($items as $item)
                  <option value="{{ $item->id }}"> {{ $item->name }}</option>
                  @endforeach
                  @endif
               </select>
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" rows="3" name="remarks" placeholder="Enter ..." required=""></textarea>
            </div>
        </div>

       
 
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
            </div>
        </div>
    </div>
</form>
</fieldset>