<!-- Logo -->
<div class="header-left">
    <a href="index.html" class="logo">
        <img src="{{ asset('assets/img/logoX.png') }}" alt="Logo">
    </a>
    <a href="index.html" class="logo logo-small">
        <img src="{{ asset('assets/img/faviconX.png') }}" alt="Logo" width="30" height="30">
    </a>
</div>
<!-- /Logo -->

<a href="javascript:void(0);" id="toggle_btn">
    <i class="fe fe-text-align-left"></i>
</a>

<div class="top-nav-search">

</div>

<!-- Mobile Menu Toggle -->
<a class="mobile_btn" id="mobile_btn">
    <i class="fa fa-bars"></i>
</a>
<!-- /Mobile Menu Toggle -->

<ul class="nav user-menu">
    @if (Auth::check())
        @include('admin.pages.notification.notification')
    @endif
    <li class="nav-item dropdown has-arrow">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <span class="user-img"><img class="rounded-circle"
                    src="{{asset('admin/assets/img/profiles/avatar-01.png')}}" width="31"
                    alt="{{ auth()->user()->nom }}"></span>
        </a>
        <div class="dropdown-menu">
            <div class="user-header">
                <div class="avatar avatar-sm">
                    <img src="{{asset('admin/assets/img/profiles/avatar-01.png')}}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="user-text">
                    <h6>{{ auth()->user()->nom }} {{ auth()->user()->prenoms }}</h6>
                    <p class="text-muted mb-0">{{ Str::ucfirst(auth()->user()->role->etiquette) }}</p>
                </div>
            </div>
            <a class="dropdown-item" href="{{route('profile')}}">Profile</a>
            <a class="dropdown-item" href="{{ route('deconnexion') }}">Déconnexion</a>
        </div>
    </li>
</ul>
