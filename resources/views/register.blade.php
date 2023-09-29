@extends('index')
@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <!-- Register Content -->
                    <div class="account-content">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-7 col-lg-6 login-left">
                                <img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">
                            </div>
                            <div class="col-md-12 col-lg-6 login-right">

                                <!-- Register Form -->
                                <form action="https://dreamguys.co.in/demo/doccure/doctor-dashboard.html">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating">
                                        <label class="focus-label">Name</label>
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating">
                                        <label class="focus-label">Mobile Number</label>
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password" class="form-control floating">
                                        <label class="focus-label">Create Password</label>
                                    </div>
                                    <div class="text-right">
                                        <a class="forgot-link" href="{{route('login')}}">Already have an account?</a>
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg login-btn"
                                        type="submit">Signup</button>
                                </form>
                                <!-- /Register Form -->

                            </div>
                        </div>
                    </div>
                    <!-- /Register Content -->

                </div>
            </div>

        </div>

    </div>
    <br>
    <br>
@endsection
