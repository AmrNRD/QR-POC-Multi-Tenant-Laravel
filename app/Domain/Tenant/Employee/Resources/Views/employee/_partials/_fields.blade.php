@include('backend.globals.vue_validation')
<label for="role">User</label>
<select name="user" id="user" v-model="fData.user_id" class="form-control form-control-lg select" >
    @foreach ($users as $user)
        <option :value="{{$user->id}}">{{$user->name}}</option>
    @endforeach
</select>

<br>
<label for="gender">Gender</label>
<select name="gender" id="role" class="form-control form-control-lg select">
    <option value="male">Male</option>
    <option value="female">Female</option>
</select>

<br>
<label for="gender">Address</label>
<div class="input-group">
    <input v-model="fData.address" type="text" class="form-control {{$errors->has('address') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->address : old('address') }}" placeholder="Full address">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('address'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('address')}}
            </div>
        @endif
    </div>
</div>

<br>
<label for="gender">Date of birth</label>
<div class="input-group">
    <input type="date" v-model="fData.date_of_birth" class="form-control {{$errors->has('date_of_birth') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->date_of_birth : old('date_of_birth') }}" placeholder="Date of birth">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-clock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('date_of_birth'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('date_of_birth')}}
            </div>
        @endif
    </div>
</div>
