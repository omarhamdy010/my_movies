@extends('_layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="row  d-flex justify-content-center my-2" style="margin: auto ;padding: 10px ">
{{--            @if(auth()->user()->hasPermission('category_create'))--}}
                <div>
                    <a href="{{route('categories.create')}}" class="btn btn-primary">{{__('site.create')}}</a>
                </div>
{{--            @endif--}}
        </div>
        <div class="row">
            <table class="table table-bordered yajra-datatable">
                <thead>
                <tr>
                    <th>{{__('site.no')}}.</th>
                    <th>{{__('site.name')}}</th>
                    <th>{{__('site.parent_category')}}</th>
                    <th>{{__('site.image')}}</th>
                    <th>{{__('site.actions')}}</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


@endsection
@section('js')

    <script type="text/javascript">
        $(document).ready(function () {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('categories.catajax')}}",
                    method: 'get',
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'parent_category', name: 'parent_category'},
                    {data: 'image', name: 'image'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>

@endsection
