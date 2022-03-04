@extends('_layouts.app')

@section('content')

    <div class="container">
        <form method="post" action="{{route('cities.store')}}" enctype="multipart/form-data">
            @csrf
            @method('post')
            @foreach(config('translatable.locales') as  $locale)

                <div class="form-group">

                    {{--                    <label for="{{ $locale }}_name" style="display: inline">{{__('site.'.$locale . '.name')}}</label>--}}

                    <input name="{{ $locale }}[name]" placeholder="{{__('site.'.$locale . '.name')}}" class="form-control @error('name') is-invalid @enderror "
                           type="text" value="{{ old($locale.'.name') }}">

                    @error($locale.'.name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                </div>

            @endforeach
            <div class="form-group">

                <label for="shipping_price">{{__('site.shipping_price')}}</label>

                <input class="form-control @error('shipping_price') is-invalid @enderror " type="number" name="shipping_price" id="shipping_price"
                       value="{{ old('shipping_price') }}">
                @error('shipping_price')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>

            <div>
                <button type="submit" class="btn btn-success btn-sm ">{{__('site.create')}}</button>
            </div>
        </form>
    </div>
@endsection
