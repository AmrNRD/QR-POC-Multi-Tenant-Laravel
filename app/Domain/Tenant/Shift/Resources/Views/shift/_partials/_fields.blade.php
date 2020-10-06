@include('backend.globals.vue_validation')
<label for="name">Name</label>
<div class="input-group mt-3">
    <input v-model="fData.name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->name : old('name') }}" placeholder="Shift name">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('name'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('name')}}
            </div>
        @endif
    </div>
</div>
<br>
<label for="threshold">Threshold</label>
<div class="input-group mt-3">
    <input type="number" v-model="fData.threshold" class="form-control {{$errors->has('threshold') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->threshold : old('threshold') }}" placeholder="Threshold in minutes">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('threshold'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('threshold')}}
            </div>
        @endif
    </div>
</div>
<br>
<label for="start_at">Start at</label>
<div class="input-group mt-3">
    <input type="time" v-model="fData.start_at" class="form-control {{$errors->has('start_at') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->start_at : old('start_at') }}" placeholder="Start at">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('start_at'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('start_at')}}
            </div>
        @endif
    </div>
</div>
<br>
<label for="name">End at</label>
<div class="input-group mt-3">
        <input type="time" v-model="fData.end_at" class="form-control {{$errors->has('end_at') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->end_at : old('end_at') }}" placeholder="End at">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-clock"></span>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('end_at'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('end_at')}}
            </div>
        @endif
    </div>
</div>

<br>
<label for="name">Start date</label>
<div class="input-group mt-3">
    <input type="date" v-model="fData.start_date" class="form-control {{$errors->has('start_date') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->start_date : old('start_date') }}" placeholder="Start at">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('start_date'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('start_date')}}
            </div>
        @endif
    </div>
</div>


<br>
<label for="end_date">End date (Leave it empty if you prefer)</label>
<div class="input-group mt-3">
    <input type="date" v-model="fData.end_date" class="form-control {{$errors->has('end_date') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->end_date : old('end_date') }}" placeholder="End at">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('end_date'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('end_date')}}
            </div>
        @endif
    </div>
</div>

<br>
<label for="type">Type</label>
<div class="input-group mt-3">
<select id="type" v-model="fData.type" class="form-control form-control-lg">
        <option value="fixed">fixed</option>
        <option value="flexible">flexible</option>
</select>
</div>



{{--@if($action == 'edit')--}}
{{--<label for="role">Start at</label>--}}
<br>
<br>
{{--<div class="row">--}}


{{--</div>--}}
{{--@endif--}}
