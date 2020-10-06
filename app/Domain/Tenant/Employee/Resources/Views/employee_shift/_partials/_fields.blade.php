@include('backend.globals.vue_validation')

<br>
<label for="role">Employee</label>
<div class="row">

    <select name="employee" id="employee" v-model="fData.employee_id" class="form-control form-control-lg" >
        @foreach ($employees as $employee)
            <option :value="{{$employee->id}}">{{$employee->user->name}}</option>
        @endforeach
    </select>
</div>

<br>
<label for="role">Shift</label>
<div class="row">

    <select name="shift" id="shift" v-model="fData.shift_id" class="form-control form-control-lg" >
        @foreach ($shifts as $shift)
            <option :value="{{$shift->id}}">{{$shift->name}}</option>
        @endforeach
    </select>
</div>


<br>
<label for="name">From</label>
<div class="input-group mt-3">
    <input type="date" v-model="fData.from" class="form-control {{$errors->has('from') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->from : old('from') }}" placeholder="From">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('from'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('from')}}
            </div>
        @endif
    </div>
</div>


<br>
<label for="end_date">To</label>
<div class="input-group mt-3">
    <input type="date" v-model="fData.to" class="form-control {{$errors->has('to') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->to : old('to') }}" placeholder="To">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('to'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('end_date')}}
            </div>
        @endif
    </div>
</div>
