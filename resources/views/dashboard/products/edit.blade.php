@extends('_layouts.app')

@section('content')

    <div class="container">
{{--        @foreach($Products as $Product)--}}
            <form method="post" action="{{route('products.update', $Product->id)}}" enctype="multipart/form-data">

                @csrf

                @method('put')


                <div class="row  d-flex justify-content-center my-2" style="margin: auto ;padding: 10px ">
                    <div class="form-group">
                        <label for="category">{{__('site.category')}}</label>
                        <select name="category_id" id="category" style="height: 25px; width: 400px ">
                            @foreach($categories as $category)
                                <option
                                    value="{{$category->id}}" {{$Product->category->name==$category->name ? 'selected' : ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @foreach(config('translatable.locales') as  $locale)
                    <div class="form-group">
                        <label for="{{ $locale }}_name">{{__('site.'.$locale . '.name')}}</label>
                        <input class="form-control @error($locale.'_name') is-invalid @enderror" type="text"

                               name="{{ $locale }}[name]" id="{{ $locale }}_name"
                               value="{{ $Product->translate($locale)->name }}">
                        @if ($errors->has($locale.'[name]'))
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                            </span>
                        @endif
                    </div>
                @endforeach


                <div class="form-group">
                <textarea class="form-control ck-editor" name="description">
                    {{$Product->description}}
                </textarea>
                </div>

                <label>{{__('site.image')}}</label>
                <div class="input-group control-group increment">
                    <input type="file" name="images[]" multiple class="form-control image">

                </div>

                <div class="form-group">
                @foreach($Product->images as $image)

                        <img src="{{asset($image->path)}}" style="width: 100px ; cursor:pointer"
                         class="img-thumbnail image-preview">

                    @endforeach
                </div>

                <div class="form-group">
                    <label>{{__('site.price')}}</label>
                    <input name="price" type="number" class="form-control" value="{{$Product->price}}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm form-control">{{__('site.edit')}}</button>
                </div>
            </form>
{{--        @endforeach--}}
    </div>
@endsection


@section('js')
    <script type="text/javascript">

        $(document).ready(function () {


            $(".image").change(function () {

                if (this.files && this.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function (e) {

                        $('.image-preview').attr('src', e.target.result);

                    }

                    reader.readAsDataURL(this.files[0]);

                }

            });

        });

    </script>
@endsection
