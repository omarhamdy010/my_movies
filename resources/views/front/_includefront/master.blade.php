<!DOCTYPE html>
<html lang="en">

@include('front._includefront.head')
<body class="home">

@include('front._includefront.navbar')

<header id="head">
    <div class="container">
        <div class="row">
            <h1 class="lead">Product</h1>
        </div>
    </div>
</header>

<div class="container text-center">
    <br> <br>
    <h2 class="thin">The best place to tell people why they are here</h2>
    <p class="text-muted">
        The difference between involvement and commitment is like an eggs-and-ham breakfast:<br>
        the chicken was involved; the pig was committed.
    </p>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@yield('content')

@include('front._includefront.footer')


@yield('scripts')

<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="{{asset('assets/js/headroom.min.js')}}"></script>
<script src="{{asset('assets/js/jQuery.headroom.min.js')}}"></script>
<script src="{{asset('assets/js/template.js')}}"></script>
</body>
</html>
