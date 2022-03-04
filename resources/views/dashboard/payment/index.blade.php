@extends('_layouts.app')

@section('content')
    <div class="content-wrapper">

        <div class="row  d-flex justify-content-center my-2"  style="margin: auto ;padding: 10px ">

                <div>
                    <a href="{{route('cities.create')}}" class="btn btn-primary">{{__('site.create')}}</a>
                </div>


        </div>
        <div class="row">
            <table class="table table-bordered yajra-datatable">
                <thead>
                <tr>
                    <th>{{__('site.no')}}.</th>
                    <th>{{__('site.name')}}</th>
                    <th>{{__('site.shipping_price')}}</th>
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
                    url: "{{route('city.getcity')}}",
                    method: 'get',
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'shipping_price', name: 'shipping_price'},
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
