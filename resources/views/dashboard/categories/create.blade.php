@extends('_layouts.app')

@section('content')

    <div class="container">

        <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
            @csrf

            @method('post')

            @foreach(config('translatable.locales') as  $locale)

                <div class="form-group">

                    <label for="{{ $locale }}_name">{{__('site.'.$locale . '.name')}}</label>

                    <input class="form-control @error($locale.'_name') is-invalid @enderror" type="text"

                           name="{{ $locale }}[name]" id="{{ $locale }}_name" value="{{ old($locale.'.name') }}">

                    @if ($errors->has($locale.'[name]'))

                        <span class="invalid-feedback" role="alert">

                    <strong>{{ $message }}</strong>

                        </span>

                    @endif

                </div>

            @endforeach

            <div class="form-group">
                <label>{{__('site.image')}}</label>
                <input class="form-control image @error('image') is-invalid @enderror" type="file" name="image"
                       value="{{ old('image') }}">
                @if ($errors->has('image'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                            </span>
                @endif
            </div>
            <img src="{{asset('upload/categories/default.png')}}" style="height: 200px ; width: 200px"
                 class="form-control image-preview">
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-sm form-control">{{__('site.create')}}</button>
            </div>
        </form>

    </div>

@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {

            $('.image').change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        debugger;
                        $('.image-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
                $(".alert").removeClass("loading").hide();
            });
        });

    </script>
@endsection
