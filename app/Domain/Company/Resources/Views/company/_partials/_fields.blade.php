@include('backend.globals.vue_validation')

<div class="input-group mt-3">
    <input v-model="fData.name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->name : old('name') }}" placeholder="Company name">
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
<div class="input-group mt-3">
    <input type="email" v-model="fData.email" class="form-control {{$errors->has('email') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->email : old('email') }}" placeholder="Email">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-envelope"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('email'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('email')}}
            </div>
        @endif
    </div>
</div>

<div class="input-group mt-3">
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


@if ($action == 'create')
    <div class="input-group mt-3">
        <input v-model="fData.slug" type="text" class="form-control {{$errors->has('slug') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->slug : old('slug') }}" placeholder="Domain slug">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if($errors->has('slug'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('slug')}}
                </div>
            @endif
        </div>
    </div>
    <br>
    <br>
    <label>Admin</label>
    <div class="input-group mt-3">
    <input v-model="fData.admin.name" type="text" class="form-control {{$errors->has('admin.name') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->name : old('name') }}" placeholder="Full name">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('admin.name'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('admin.name')}}
            </div>
        @endif
    </div>
</div>
<div class="input-group mt-3">
    <input type="email" v-model="fData.admin.email" class="form-control {{$errors->has('admin.email') ? 'is-invalid':''}}" value="{{ ($action == 'edit') ? $edit->email : old('admin.email') }}" placeholder="Email">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-envelope"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('admin.email'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('admin.email')}}
            </div>
        @endif
    </div>
</div>


<div class="input-group mt-3">
    <input type="password" v-model="fData.admin.password" class="form-control {{$errors->has('admin.password') ? 'is-invalid':''}}" placeholder="Password">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-lock"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($errors->has('admin.password'))
            <div class="alert alert-danger w-100 m-0" role="alert">
                {{$errors->first('admin.password')}}
            </div>
        @endif
    </div>
</div>
    <div class="input-group mt-3">
        <input type="password" v-model="fData.admin.password_confirmation" class="form-control {{$errors->has('admin.password_confirmation') ? 'is-invalid':''}}" placeholder="Retype password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
@endif

{{--@if($action == 'edit')--}}


{{--@endif--}}
