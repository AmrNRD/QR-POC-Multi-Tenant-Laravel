@include('backend.globals.vue_validation')

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" v-model="fData.name" class="form-control" id="name" placeholder="name">
</div>

<div class="form-group">
    <label for="name">Slug</label>
    <input type="text" v-model="fData.slug" class="form-control" id="name" placeholder="name">
</div>

<div class="form-group">
    <label for="name">Permissions</label>

        <div class="row">
            @foreach ($permissions as $permission => $value)
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <div class="icheck-primary d-inline row">
                            <input class="form-control" type="checkbox" id="checkboxPrimary{{ $permission }}" name="permissions[{{ $permission }}]" value="{{ $permission }}"  {{ ($value ? 'checked' : '') }}>
                            <label for="checkboxPrimary{{ $permission }}">
                                {{ $permission }}
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>

</div>
