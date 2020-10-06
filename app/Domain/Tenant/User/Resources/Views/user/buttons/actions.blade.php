@if(\Illuminate\Support\Facades\Auth::user()->hasRole('update-users')||\Illuminate\Support\Facades\Auth::user()->hasRole('deactivate-users'))
    <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="la la-ellipsis-h"></i> Actions
    </button>
  <div class="dropdown-menu dropdown-menu-right">
      <a title="{{ __('main.show') }}" class="dropdown-item" href="{{ route('users.show', [$id]) }}"><i class="la la-eye"></i> {{ trans('main.show') }} {{ trans('main.documents') }} </a>
      @if(\Illuminate\Support\Facades\Auth::user()->hasRole('update-users'))
      <a title="{{ __('main.edit') }}" class="dropdown-item" href="{{ route('users.edit', [$id]) }}"><i class="la la-edit"></i> {{ trans('main.edit') }} {{ trans('main.documents') }} </a>
        @endif
      @if(\Illuminate\Support\Facades\Auth::user()->hasRole('deactivate-users'))
      <a title="{{ __('main.delete') }}" class="dropdown-item" href="{{ route('users.destroy', [$id]) }}" data-toggle="modal" data-target="#delete_{{$id}}"><i class="la la-trash"></i> {{ trans('main.delete') }} {{ trans('main.documents') }} </a>
      @endif
  </div>
</div>
@endif
<!--begin::Modal-->
<div class="modal fade" id="delete_{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('main.delete') }} {{ trans('main.users') }}: #{{ $id }} ({{ $name }})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('users.destroy', [$id]) }}" method="post">
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
