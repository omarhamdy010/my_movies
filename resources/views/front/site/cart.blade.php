@extends('front._includefront.layout')

@section('content')
    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>

        @php
            $total = 0
        @endphp

        @if(session('cart'))

            {{--            @foreach(session('cart') as $id => $details)--}}

            @foreach($products as $id=>$product)
                @php

                     $products=\App\Models\Product::with('images')->get();
                @endphp

                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            @foreach($product->images as $images )
                                <div class="col-sm-3 hidden-xs"><img src="{{asset($images->path)}}" width="100"
                                                                     height="100" class="img-responsive"/></div>
                            @endforeach
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $product['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{ $product['price'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $product['quantity'] }}"
                               class="form-control quantity update-cart"/>
                    </td>
                    <td data-th="Subtotal" class="text-center">${{ $product['price'] * $product['quantity'] }}</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                <button class="btn btn-success">Checkout</button>
            </td>
        </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script type="text/javascript">

        $(".update-cart").change(function (e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ route('updatetocart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>
@endsection
