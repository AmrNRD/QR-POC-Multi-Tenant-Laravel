@if(\Illuminate\Support\Facades\Auth::user()->hasRole('update-admins')||\Illuminate\Support\Facades\Auth::user()->hasRole('deactivate-admins'))
    <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
      <i class="la la-ellipsis-h"></i> Actions
    </button>
  <div class="dropdown-menu dropdown-menu-right">
      <a title="{{ __('main.show') }}" class="dropdown-item" href="{{ route('admins.show', [$id]) }}"><i class="la la-eye"></i> Show </a>
      <a title="{{ __('main.edit') }}" class="dropdown-item" href="{{ route('admins.edit', [$id]) }}"><i class="la la-edit"></i> Edit </a>
      <a title="{{ __('main.delete') }}" class="dropdown-item" href="{{ route('admins.destroy', [$id]) }}" data-toggle="modal" data-target="#delete_{{$id}}"><i class="la la-trash"></i> Delete </a>
  </div>
</div>
    @endif
<!--begin::Modal-->
<div class="modal fade" id="delete_{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('main.delete') }} {{ trans('main.admins') }}: #{{ $id }} ({{ $name }})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('admins.destroy', [$id]) }}" method="post">
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    {{ trans('main.delete') }} {{ trans('main.Documents') }}: #{{ $id }} ({{ $name }})
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('main.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('main.delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--end::Modal-->
