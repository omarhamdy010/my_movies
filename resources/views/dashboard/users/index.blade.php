@extends('_layouts.app')

@section('content')


    <div class="content-wrapper" >
        <div class="row">
            <table class="table table-bordered yajra-datatable" style="">
                <thead>
                <tr>
                    <th>{{__('site.no')}}</th>
                    <th>{{__('site.name')}}</th>
                    <th>{{__('site.email')}}</th>
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
                    url: "{{route('users.ajax')}}",
                    method: 'get',
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'image', name: 'image'},
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endsection
