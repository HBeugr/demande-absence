@extends('template')
@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-8 offset-md-2">

                <!-- Login Tab Content -->
                <div class="account-content">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 col-lg-6 login-left">
                            <img src="assets/img/login-banner.jpg" class="img-fluid" alt="{{env('APP_NAME')}} Login">
                        </div>
                        <div class="col-md-12 col-lg-6 login-right">
                            <div class="login-header">
                                <h3>Login <span>{{env('APP_NAME')}}</span></h3>
                            </div>
                            {{-- <?php
                                $pass = '@Beugre_2020';
                                echo password_hash($pass, PASSWORD_DEFAULT)
                                ?> --}}
                            <form action="{{route('authenticate')}}" method="POST">
                                @csrf
                                <div class="form-group form-focus">
                                    <input type="email" class="form-control floating" name="email">
                                    <label class="focus-label">Votre Mail</label>
                                </div>
                                <div class="form-group form-focus">
                                    <input type="password" class="form-control floating" name="password">
                                    <label class="focus-label">Votre Mot de Passe</label>
                                </div>
                                <div class="text-right">
                                    <a class="forgot-link" href="{{route('forgot-password')}}">Vous avez oublié votre mot de passe ?</a>
                                </div>
                                <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Connexion</button>
                                {{-- <div class="text-center dont-have">Vous n'avez pas de compte? <a href="{{route('register')}}">Register</a></div> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Login Tab Content -->

            </div>
        </div>

    </div>

</div>
<br>
<br>
@endsection
