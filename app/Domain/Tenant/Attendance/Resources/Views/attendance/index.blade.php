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
                                <th>date</th>
                                <th>check in at</th>
                                <th>check out at</th>
                                <th>shift start</th>
                                <th>shift end</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->employee->user->name}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$item->check_in}}</td>
                                <td>{{$item->check_out}}</td>
                                <td>{{$item->shift_start}}</td>
                                <td>{{$item->shift_end}}</td>
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
