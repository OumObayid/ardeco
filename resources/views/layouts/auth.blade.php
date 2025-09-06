{{-- resources/views/layouts/auth.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #121212;
            font-family: 'Segoe UI', sans-serif;
            color: #f1f1f1;
        }

        .auth-box {
            background-color: #1e1e1e;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 400px;
        }

        .auth-box .form-control {
            background-color: #262626;
            border: 1px solid #444;
            color: #f1f1f1;
        }

        .auth-box .form-control:focus {
            background-color: #262626;
            color: #fff;
            border-color: #e3c34e;
            box-shadow: none;
        }

        .auth-box .btn-primary {
            background-color: #e3c34e;
            border-color: #e3c34e;
            color: #000;
        }

        .auth-box .btn-primary:hover {
            background-color: #b28211;
            border-color: #b28211;
            color: #fff;
        }

        a {
            color: #e3c34e;
        }

        a:hover {
            color: #b28211;
        }
        .form-icon{
          position: absolute;
          top: 50%;
          transform: translate(-50%);
          left: 18px;
          font-size: 1rem;
        }
        .input-with-icon{
            padding-left: 2.2rem;
        }
    </style>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="auth-box">
            @yield('auth-content')
        </div>
    </div>
@endsection
