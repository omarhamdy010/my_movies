<div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li class="dropdown">
                    <ul class="dropdown">
                        <button type="button" class="btn btn-info" data-toggle="dropdown">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                        </button>
                        <div class="dropdown-menu">
                            <div class="row total-header-section">
                                <div class="col-lg-6 col-sm-6 col-6">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                                </div>
                                @php $total = 0 @endphp
{{--                                @foreach((array) session('cart') as $id => $details)--}}
{{--                                    @php $total += $details['price'] * $details['quantity'] @endphp--}}
{{--                                @endforeach--}}
                                @php
                                    $products=\App\Models\Product::with('images')->get();
                                @endphp
                                @foreach($products as $id=>$product)

                                    @php $total += $product['price'] * $product['quantity'] @endphp

                                @endforeach
                                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                    <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                                </div>
                            </div>
                            @if(session('cart'))
{{--                                @foreach(session('cart') as $id => $details)--}}
                                @foreach($products as $id=>$product)
                                <div class="row cart-detail">
                                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                            <img src="{{ $product['image'] }}" />
                                        </div>
                                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                            <p>{{ $product['name'] }}</p>
                                            <span class="price text-info"> ${{ $product['price'] }}</span> <span class="count"> Quantity:{{ $product['quantity'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                    <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>
                                </div>
                            </div>
                        </div>
                    </ul>
                    <ul class="dropdown-menu">

                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>

</div>
