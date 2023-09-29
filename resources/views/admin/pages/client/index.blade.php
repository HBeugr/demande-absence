@extends('admin.template')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Client</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item active">Client</li>
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
                                <form action="{{ route('clients.store') }}" method="POST">
                                    @csrf
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
                                            <label for="validationDefault02">Prenoms</label>
                                            <input type="text" class="form-control" id="validationDefault02"
                                                placeholder="Prenoms" name="prenoms" required>
                                            @error('prenoms')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault02">Mail</label>
                                            <input type="text" class="form-control" id="validationDefault02"
                                                placeholder="Mail" name="email" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault02">N° de Téléphone</label>
                                            <input type="text" class="form-control" id="validationDefault02"
                                                placeholder="N° de Téléphone" name="telephone" required>
                                            @error('telephone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                            <h4 class="card-title">Liste des Clients</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="client" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Noms</th>
                                            <th>Prenoms</th>
                                            <th>Mails</th>
                                            <th>Téléphones</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::ucfirst($client->nom) }}</td>
                                                <td>{{ Str::ucfirst($client->prenoms) }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ Str::ucfirst($client->telephone) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm bg-warning-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#edit_client_details_{{ $client->id }}">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#delete_client_confirmation_{{ $client->id }}">
                                                            <i class="fe fe-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="edit_client_details_{{ $client->id }}"
                                                aria-hidden="true" client="dialog">
                                                <div class="modal-dialog modal-dialog-centered" client="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modifier le client</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('clients.update', ['client' => $client->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="nom">Nom</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nom" name="nom"
                                                                        value="{{ $client->nom }}" required>
                                                                    @error('nom')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="prenoms">Prénoms</label>
                                                                    <input type="text" class="form-control"
                                                                        id="prenoms" name="prenoms"
                                                                        value="{{ $client->prenoms }}">
                                                                    @error('prenom')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="email" name="email"
                                                                        value="{{ $client->email }}">
                                                                    @error('email')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="telephone">Téléphone</label>
                                                                    <input type="text" class="form-control"
                                                                        id="telephone" name="telephone"
                                                                        value="{{ $client->telephone }}" required>
                                                                    @error('telephone')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
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
                                            <div class="modal fade" id="delete_client_confirmation_{{ $client->id }}"
                                                aria-hidden="true" client="dialog">
                                                <div class="modal-dialog modal-dialog-centered" client="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Deletion</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Êtes-vous sur de vouloir supprimer le client
                                                                "{{ $client->nom }} {{ $client->prenoms }}"?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('clients.destroy', ['client' => $client->id]) }}"
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
