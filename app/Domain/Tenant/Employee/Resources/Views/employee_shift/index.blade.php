@extends('backend.layout')

@push('styles')
    <link href="{{ asset('layout-dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('sub_header')
    @component('backend.components.sub-header')
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!--begin: Datatable -->
                    {{-- {!! $dataTable->table(['class' => 'table table-bordered table-hover'], true) !!} --}}
                    <table class="table table-striped table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>id</th>
                                <th>employee</th>
                                <th>shift</th>
                                <th>assigned to the shift since</th>
                                <th>to</th>
                                <th>added at</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td><a href="{{route('employees.show', $item->employee_id)}}">{{$item->employee->user->name}}</a></td>
                                <td><a href="{{route('shifts.show', $item->shift_id)}}">{{$item->shift->name}}</a></td>
                                <td>{{$item->from}}</td>
                                <td>{{$item->to}}</td>
                                <td>{{$item->created_at}}</td>
                                <td> @include("{$alias}::employee_shift.buttons.actions", ['id' => $item->id,'name'=>$item->name])</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset("layout-dist/plugins/datatables/jquery.dataTables.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("layout-dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}" type="text/javascript"></script>
    <!--end::Page Vendors -->
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush
