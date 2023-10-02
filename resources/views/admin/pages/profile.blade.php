@extends('admin.template')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                <img class="rounded-circle" alt="User Image" src="{{asset('admin/assets/img/profiles/avatar-01.png')}}">
                            </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{ $user->nom }} {{ $user->prenoms }}</h4>
                            <h6 class="text-muted">{{ $user->email }}</h6>
                            <div class="user-Location"><i class="fa fa-map-marker"></i> {{ $user->adresse }}</div>
                            <div class="about-text">{{ $user->genre }}</div>
                        </div>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#per_details_tab">A Propos de Moi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#password_tab">Changer Mon Mot de Passe</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">

                        <!-- Personal Details -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i
                                                    class="fa fa-edit mr-1"></i>Modifier</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Département</p>
                                            <p class="col-sm-10">{{ $user->departement->nom }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Role</p>
                                            <p class="col-sm-10">{{ $user->role->etiquette }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Nom Prénoms</p>
                                            <p class="col-sm-10">{{ $user->nom }} {{ $user->prenoms }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date de Naissance</p>
                                            <p class="col-sm-10">{{ \Carbon\Carbon::parse($user->date_Naissance)->format('d-m-Y') }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Mail</p>
                                            <p class="col-sm-10">{{ $user->email }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Contact</p>
                                            <p class="col-sm-10">{{ $user->contact }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted text-sm-right mb-0">Adresse</p>
                                            <p class="col-sm-10 mb-0">{{ $user->adresse }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Details Modal -->
                                <div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Information Personnelle</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('updateProfile', ['id' => $user->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row form-row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nom">Nom</label>
                                                                <input type="text" class="form-control" id="nom"
                                                                    name="nom" value="{{ $user->nom }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="prenoms">Prénoms</label>
                                                                <input type="text" class="form-control" id="prenoms"
                                                                    name="prenoms" value="{{ $user->prenoms }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="date_naissance">Date de Naissance</label>
                                                                <input type="date" class="form-control"
                                                                    id="date_naissance" name="date_naissance"
                                                                    value="{{ $user->date_Naissance }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" class="form-control" id="email"
                                                                    name="email" value="{{ $user->email }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="contact">Contact</label>
                                                                <input type="text" class="form-control" id="contact"
                                                                    name="contact" value="{{ $user->contact }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="adresse">Adresse</label>
                                                                <input type="text" class="form-control" id="adresse"
                                                                    name="adresse" value="{{ $user->adresse }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="genre">Genre</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="genre" id="genre_masculin"
                                                                        value="Masculin"
                                                                        {{ $user->genre === 'Masculin' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="genre_masculin">
                                                                        Masculin
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="genre" id="genre_feminin" value="Feminin"
                                                                        {{ $user->genre === 'Feminin' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="genre_feminin">
                                                                        Féminin
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-block">Enregistrer
                                                        les modifications</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Edit Details Modal -->

                            </div>
                        </div>
                        <!-- /Personal Details -->

                    </div>
                    <!-- /Personal Details Tab -->

                    <!-- Change Password Tab -->
                    <div id="password_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Modification du Mot de Passe</h5>
                                <div class="row">
                                    <div class="col-md-10 col-lg-6">
                                        <form method="POST" action="{{ route('updatePassword', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="old_password">Ancien Mot de Passe</label>
                                                <input type="password" class="form-control" id="old_password"
                                                    name="old_password">
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">Nouveau Mot de Passe</label>
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password">
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password_confirmation">Confirmer le Nouveau Mot de
                                                    Passe</label>
                                                <input type="password" class="form-control"
                                                    id="new_password_confirmation" name="new_password_confirmation">
                                            </div>

                                            <button class="btn btn-primary" type="submit">Modifier</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
