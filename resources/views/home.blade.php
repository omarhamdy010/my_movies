@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('site.dashboard') }}</div>
                    <ul>
                        <li class="nav-item dropdown dropdown-menu-right">
                            <a class="nav-link" data-toggle="dropdown"
                               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-labelledby="navbarDropdown"
                               aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{__('site.logout')}}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('site.You_are_logged_in!') }}
                        {{ __('site.but_you_are_still_not_admin') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
