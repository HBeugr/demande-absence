@extends('admin.template')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Utilisateur</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item active">Utilisateur</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Formulaire de Création</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <form action="{{ route('utilisateurs.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault09">Département</label>
                                            <select id="validationDefault09" name="departement_id" class="form-control">
                                                <option value="">Selectionnez le Département</option>
                                                @foreach ($departements as $departement)
                                                    @if (Str::lower(auth()->user()->role->etiquette) == 'manager' &&
                                                            Str::lower(auth()->user()->departement->nom) == 'commercial')
                                                        @if (Str::lower($departement->nom) == 'commercial')
                                                            <option value="{{ $departement->id }}">
                                                                {{ Str::ucfirst($departement->nom) }}
                                                            </option>
                                                        @endif
                                                    @elseif (Str::lower(auth()->user()->role->etiquette) != 'manager')
                                                        <option value="{{ $departement->id }}">{{ $departement->nom }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('departement')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3"><label for="validationDefault08">Rôle</label>
                                            <select id="validationDefault08" name="role_id" class="form-control">
                                                <option value="">Selectionnez le Rôle</option>
                                                @foreach ($roles as $role)
                                                    @if (Str::lower(auth()->user()->role->etiquette) == 'manager' &&
                                                            Str::lower(auth()->user()->departement->nom) == 'commercial')
                                                        @if (Str::lower($role->etiquette) == 'employé')
                                                            <option value="{{ $role->id }}">
                                                                {{ Str::ucfirst($role->etiquette) }}</option>
                                                        @endif
                                                    @elseif (Str::lower(auth()->user()->role->etiquette) != 'manager')
                                                        <option value="{{ $role->id }}">
                                                            {{ $role->etiquette }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault01">Nom</label>
                                            <input type="text" class="form-control" id="validationDefault01"
                                                placeholder="Nom" name="nom" required>
                                            @error('nom')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault02">Prénoms</label>
                                            <input type="text" class="form-control" id="validationDefault02"
                                                placeholder="Prénoms" name="prenoms">
                                            @error('prenoms')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault03">Email</label>
                                            <input type="email" class="form-control" id="validationDefault03"
                                                placeholder="Email" name="email" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault04">Mot de passe</label>
                                            <input type="password" class="form-control" id="validationDefault04"
                                                placeholder="Mot de passe" name="password" required>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault05">Contact</label>
                                            <input type="text" class="form-control" id="validationDefault05"
                                                placeholder="Contact" name="contact">
                                            @error('contact')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault06">Adresse</label>
                                            <input type="text" class="form-control" id="validationDefault06"
                                                placeholder="Adresse" name="adresse">
                                            @error('adresse')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="genre">Genre</label>
                                            <br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="genre"
                                                    id="genre_homme" value="Masculin" checked>
                                                <label class="form-check-label" for="genre_homme">
                                                    Homme
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="genre"
                                                    id="genre_femme" value="Feminin">
                                                <label class="form-check-label" for="genre_femme">
                                                    Femme
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3 justify-content-end">
                                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-md-12 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Liste des Utilisateurs
                                @if (Str::lower(auth()->user()->role->etiquette) == 'manager' &&
                                        Str::lower(auth()->user()->departement->nom) == 'commercial')
                                    du Service Commercial
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="user" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Prénoms</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Adresse</th>
                                            <th>Genre</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Str::lower(auth()->user()->role->etiquette) == 'manager' &&
                                                Str::lower(auth()->user()->departement->nom) == 'commercial')
                                            @foreach ($users->where('departement_id', auth()->user()->departement->id) as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->nom }}</td>
                                                    <td>{{ $user->prenoms }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->contact }}</td>
                                                    <td>{{ $user->adresse }}</td>
                                                    <td>{{ $user->genre }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-sm bg-warning-light"
                                                                style="margin-right: 10%;" data-toggle="modal"
                                                                href="#edit_user_details_{{ $user->id }}">
                                                                <i class="fe fe-edit"></i>
                                                            </a>
                                                            @if ($user->id !== auth()->user()->id)
                                                                <a class="btn btn-sm bg-danger-light"
                                                                    style="margin-right: 10%;" data-toggle="modal"
                                                                    href="#delete_user_confirmation_{{ $user->id }}">
                                                                    <i class="fe fe-trash"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="edit_user_details_{{ $user->id }}"
                                                    aria-hidden="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier l'Utilisateur</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('utilisateurs.update', ['utilisateur' => $user->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="roles">Rôle</label>
                                                                            <select id="roles" name="role_id"
                                                                                class="form-control">
                                                                                @foreach ($roles as $role)
                                                                                    @php
                                                                                        $lowerRole = Str::lower($role->etiquette);
                                                                                        $selected = $user->role_id == $role->id ? 'selected' : '';
                                                                                    @endphp
                                                                                    @if ($user->role->etiquette !== 'administrateur')
                                                                                        @if ($lowerRole == 'employé' || $lowerRole == 'manager')
                                                                                            <option
                                                                                                value="{{ $role->id }}"
                                                                                                {{ $selected }}>
                                                                                                {{ $role->etiquette }}
                                                                                            </option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $role->id }}"
                                                                                            {{ $selected }}>
                                                                                            {{ $role->etiquette }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="departements">Département</label>
                                                                            <select id="departements"
                                                                                name="departement_id"
                                                                                class="form-control">
                                                                                @foreach ($departements as $departement)
                                                                                    @php
                                                                                        $lowerDepartement = Str::lower($departement->nom);
                                                                                        $selected = $user->departement_id == $departement->id ? 'selected' : '';
                                                                                    @endphp
                                                                                    @if ($user->role->etiquette !== 'administrateur')
                                                                                        @if ($lowerDepartement == 'commercial')
                                                                                        <option
                                                                                            value="{{ $departement->id }}"
                                                                                            {{ $selected}}>
                                                                                            {{ $departement->nom }}
                                                                                        </option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $departement->id }}"
                                                                                            {{ $selected}}>
                                                                                            {{ $departement->nom }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="nom">Nom</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nom" name="nom"
                                                                                value="{{ $user->nom }}">
                                                                            @error('nom')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="prenoms">Prénoms</label>
                                                                            <input type="text" class="form-control"
                                                                                id="prenoms" name="prenoms"
                                                                                value="{{ $user->prenoms }}">
                                                                            @error('prenoms')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" class="form-control"
                                                                                id="email" name="email"
                                                                                value="{{ $user->email }}">
                                                                            @error('email')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="contact">Contact</label>
                                                                            <input type="text" class="form-control"
                                                                                id="contact" name="contact"
                                                                                value="{{ $user->contact }}">
                                                                            @error('contact')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="adresse">Adresse</label>
                                                                            <input type="text" class="form-control"
                                                                                id="adresse" name="adresse"
                                                                                value="{{ $user->adresse }}">
                                                                            @error('adresse')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="genre">Genre</label>
                                                                            <select id="genre" name="genre"
                                                                                class="form-control">
                                                                                <option value="Masculin"
                                                                                    {{ $user->genre === 'Masculin' ? 'selected' : '' }}>
                                                                                    Homme</option>
                                                                                <option value="Feminin"
                                                                                    {{ $user->genre === 'Feminin' ? 'selected' : '' }}>
                                                                                    Femme</option>
                                                                            </select>
                                                                            @error('genre')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Fermer</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Modifier</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="delete_user_confirmation_{{ $user->id }}"
                                                    aria-hidden="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmer la Suppression</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Êtes-vous sûr de vouloir supprimer l'utilisateur
                                                                    "{{ $user->nom }}"?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('utilisateurs.destroy', ['utilisateur' => $user->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Supprimer</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif (Str::lower(auth()->user()->role->etiquette) != 'manager')
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->nom }}</td>
                                                    <td>{{ $user->prenoms }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->contact }}</td>
                                                    <td>{{ $user->adresse }}</td>
                                                    <td>{{ $user->genre }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-sm bg-warning-light"
                                                                style="margin-right: 10%;" data-toggle="modal"
                                                                href="#edit_user_details_{{ $user->id }}">
                                                                <i class="fe fe-edit"></i>
                                                            </a>
                                                            @if ($user->id !== auth()->user()->id)
                                                                <a class="btn btn-sm bg-danger-light"
                                                                    style="margin-right: 10%;" data-toggle="modal"
                                                                    href="#delete_user_confirmation_{{ $user->id }}">
                                                                    <i class="fe fe-trash"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="edit_user_details_{{ $user->id }}"
                                                    aria-hidden="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier l'Utilisateur</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('utilisateurs.update', ['utilisateur' => $user->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="roles">Rôle</label>
                                                                            <select id="roles" name="role_id"
                                                                                class="form-control">
                                                                                @foreach ($roles as $role)
                                                                                    <option value="{{ $role->id }}"
                                                                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                                        {{ $role->etiquette }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="departements">Département</label>
                                                                            <select id="departements"
                                                                                name="departement_id"
                                                                                class="form-control">
                                                                                @foreach ($departements as $departement)
                                                                                    <option value="{{ $departement->id }}"
                                                                                        {{ $user->departement_id == $departement->id ? 'selected' : '' }}>
                                                                                        {{ $departement->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="nom">Nom</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nom" name="nom"
                                                                                value="{{ $user->nom }}">
                                                                            @error('nom')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="prenoms">Prénoms</label>
                                                                            <input type="text" class="form-control"
                                                                                id="prenoms" name="prenoms"
                                                                                value="{{ $user->prenoms }}">
                                                                            @error('prenoms')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" class="form-control"
                                                                                id="email" name="email"
                                                                                value="{{ $user->email }}">
                                                                            @error('email')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="contact">Contact</label>
                                                                            <input type="text" class="form-control"
                                                                                id="contact" name="contact"
                                                                                value="{{ $user->contact }}">
                                                                            @error('contact')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="adresse">Adresse</label>
                                                                            <input type="text" class="form-control"
                                                                                id="adresse" name="adresse"
                                                                                value="{{ $user->adresse }}">
                                                                            @error('adresse')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="genre">Genre</label>
                                                                            <select id="genre" name="genre"
                                                                                class="form-control">
                                                                                <option value="Masculin"
                                                                                    {{ $user->genre === 'Masculin' ? 'selected' : '' }}>
                                                                                    Homme</option>
                                                                                <option value="Feminin"
                                                                                    {{ $user->genre === 'Feminin' ? 'selected' : '' }}>
                                                                                    Femme</option>
                                                                            </select>
                                                                            @error('genre')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Fermer</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Modifier</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="delete_user_confirmation_{{ $user->id }}"
                                                    aria-hidden="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmer la Suppression</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Êtes-vous sûr de vouloir supprimer l'utilisateur
                                                                    "{{ $user->nom }}"?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('utilisateurs.destroy', ['utilisateur' => $user->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Supprimer</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
