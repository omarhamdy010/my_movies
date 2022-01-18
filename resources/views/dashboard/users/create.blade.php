@extends('_layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data">
            @csrf
            @method('post')
                <div class="form-group">

                    <label for="_name">{{__('site.name')}}</label>

                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                           value="{{ old('name') }}">
                    @if ($errors->has('name'))

                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                        </span>
                    @endif

                </div>

            <div class="form-group">

                <label>{{__('site.email')}}</label>

                <input name="email" type="email" value="" placeholder="{{__('site.email')}}" class="form-control">

                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif

            </div>

                        <div class="form-group">

                            <label for="admin">{{__('site.image')}}</label>

                            <input name="image" type="file" value="{{old('image')}}" class="form-control image">

                        </div>

                        <div class="form-group">

                            <img src="{{asset('upload/users/default.png')}}" style="width:100px ; height: 100px" class="form-control image-preview">

                        </div>

            <div class="form-group">
                <label for="admin">{{__('site.status')}}</label>

                <select name="is_admin" id="admin" class="form-control">
                    <option value="0">{{__('site.not_admin')}}</option>
                    <option value="1">{{__('site.admin')}}</option>
                </select>

            </div>

            <div class="form-group">
                <label>{{__('site.password')}}</label>
                <input name="password" type="password" value="" placeholder="{{__('site.password')}}"
                       class="form-control">
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>

            @php
                $models = ['user' ,'category' , 'product' ];
                $per =['create', 'read' , 'update' , 'delete']
            @endphp

            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active " href="#" data-toggle="tab">Permissions</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        @foreach($permissions as $permission)
                            <input type="checkbox" name="permissions[]"
                                   value="{{ $permission->id  }}">{{$permission->display_name}}
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-success btn-sm ">{{__('site.create')}}</button>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {



            $(".image") .change( function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        debugger;
                        $('.image-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }

            });
        });
    </script>

@endsection
