@extends('_layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{route('categories.update', $category->id)}}" enctype="multipart/form-data">
            @csrf
            @method('put')
            @foreach(config('translatable.locales') as  $locale)
                <div class="form-group">
                    <label for="{{ $locale }}_name">{{__('site.'.$locale . '.name')}}</label>
                    <input class="form-control @error($locale.'_name') is-invalid @enderror" type="text"

                           name="{{ $locale }}[name]" id="{{ $locale }}_name"
                           value="{{ $category->translate($locale)->name }}">
                    @if ($errors->has($locale.'[name]'))
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                            </span>
                    @endif
                </div>
            @endforeach

            <div class="form-group">
                <label>{{__('site.image')}}</label>
                <input class="form-control image" type="file" name="image"
                       value="{{ old('image') }}">
            </div>

            <img src="{{$category->image_path}}" style="height: 200px ; width: 200px"
                 class="form-control image-preview">

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm form-control">{{__('site.edit')}}</button>
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
