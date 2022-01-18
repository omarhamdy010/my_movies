@extends('_layouts.app')

@section('content')
    <div class="container">

        <form method="post" action="{{route('users.update', $user->id)}}" enctype="multipart/form-data">

            @csrf

            @method('put')


                <div class="form-group">

                    <label for="name">{{__('site.name')}}</label>

                    <input class="form-control @error('name') is-invalid @enderror"
                           type="text" name="name" id="name" value="{{ $user->name }}" >

                    @if($errors->has('name'))

                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>

                    @endif

                </div>



            <div class="form-group">

                <label>{{__('site.email')}}</label>

                <input name="email" type="email" class="form-control" value="{{$user->email}}">

                @if ($errors->has('email'))

                    <span class="text-danger">{{ $errors->first('email') }}</span>

                @endif

            </div>

            <div class="form-group">

                <label for="admin">{{__('site.image')}}</label>

                <input name="image" type="file" value="{{old('image')}}" class="form-control image">

            </div>

            <div class="form-group">

                <img src="{{$user->image_path}}" style="width:100px ; height: 100px" class="form-control image-preview">

            </div>


            <div class="form-group">

                <label for="admin">is admin</label>

                <select name="is_admin" id="admin" class="form-control">

                    <option value="0">is not admin</option>

                    <option value="1">is admin</option>

                </select>

            </div>

            @php

                $models = ['user' ,'category' , 'product' ];
                $per =['create', 'read' , 'update' , 'delete'];

            @endphp

            <div class="card">

                <div class="card-header d-flex p-0">

                    <ul class="nav nav-pills ml-auto p-2">

                        <li class="nav-item"><a class="nav-link active " href="#" data-toggle="tab">Permissions</a></li>

                    </ul>

                </div>

                <div class="card-body">

                    <div class="tab-content">

                        @foreach( $permissions as $permission)

                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"

                                   {{ $user->permissions->contains($permission) ? 'checked': ''  }}>

                            {{ $permission->display_name }}

                        @endforeach

                    </div>

                </div>

            </div>

            <div>

                <button type="submit" class="btn btn-primary btn-sm ">{{__('site.edit')}}</button>

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
