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
                    <table class="table table-striped table-inverse" id="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>email</th>
                                <th>address</th>
                                <th>active</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->address}}</td>
                                <td><toggle-button color="#007bff" @change="onChange({{$item->id}},$event)" :value="{{$item->active=="active"?"true":"false"}}"></toggle-button></td>
                                <td>   @include("{$alias}::company.buttons.actions",['id' => $item->id,'name'=>$item->name])</td>
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
    @include("{$alias}::company._partials._index-scripts")
@endpush
