
<label for="stage_id">Select Stage<span class="text-danger">*</span></label>
<select name="stage_id" id="stage_id" class="form-control" required>
    @foreach ($stages as $stage)
    @php
        $disabled ="";
        if($stage->id == 9){
          if(($to_be_delivered > 0) || $remaining_amt > 0){
            $disabled = 'disabled';
          }
        }
    @endphp
        <option value="{{ $stage->id }}" {{$disabled}}>{{ $stage->stage_name }}</option>
    @endforeach
</select>