@extends('_layouts.app')

@section('content')
    <div class="container">

        <form method="post" action="{{route('products.store')}}" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="row  d-flex justify-content-center my-2" style="margin: auto ;padding: 10px ">

                <div class="form-group">
                    <select name="category_id" id="category" style="height: 25px; width: 400px ">
                        <option class="justify-content-center text-center"
                                value="">{{__('site.choose_category')}}</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
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
                <label>{{__('site.description')}}</label>
                <textarea class="form-control ck-editor" name="description">
                    {{old('description')}}
                </textarea>
            </div>

            <label>{{__('site.image')}}</label>
            <div class="input-group control-group increment">
                <input type="file" name="images[]" multiple class="form-control image">

            </div>

            <div class="form-group">
                <img src="{{asset('/upload/products/default.png')}}" multiple="image[]"  style="width: 100px"
                     class="img-thumbnail image-preview">
            </div>


            <div class="form-group">
                <label>{{__('site.price')}}</label>
                <input name="price" type="number" class="form-control">
                @error('price') <p class="text-danger">{{$message}}</p> @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-sm form-control">{{__('site.create')}}</button>
            </div>
        </form>
    </div>



@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {


            $(".image").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        debugger;
                        $('.image-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }

            });


            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click",".btn-danger",function(){
                $(this).parents(".control-group").remove();
            });
        });
    </script>
@endsection
