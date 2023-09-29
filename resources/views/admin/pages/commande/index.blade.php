@extends('admin.template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Commande</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('commandes.index') }}">Commandes</a></li>
                        <li class="breadcrumb-item active">Création de Commande</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Formulaire de Création de Commande</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('commandes.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="service_id">Produit</label>
                                    <select class="form-control" id="service_id" name="service_id" required>
                                        <option value="">Selectionnez un service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->nom }} {{ $service->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="client_id">Client</label>
                                    <select class="form-control" id="client_id" name="client_id" required>
                                        <option value="">Selectionnez un client</option>
                                        <!-- Option pour sélectionner un client -->
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="quantite">Quantité</label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" required>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-end">
                                <button class="btn btn-primary" type="submit">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-md-12 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <div class="row">
                                <div class="col d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title">Liste des Commandes</h4>
                                    </div>
                                    <div>
                                        <a class="btn btn-primary" id="filtre">Mes Commandes</a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="userCheck" value="{{ $user->id }}">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="commandes" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employé</th>
                                            <th>Service</th>
                                            <th>Quantité</th>
                                            <th>Client</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Str::lower(auth()->user()->role->etiquette) == 'manager' &&
                                                Str::lower(auth()->user()->departement->nom) == 'commercial')
                                            @foreach ($commandes->where('user.departement_id', auth()->user()->departement->id) as $commande)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input type="hidden" id="userCmd"
                                                            value="{{ $commande->user->id }}">
                                                        {{ $commande->user->nom }} {{ $commande->user->prenom }}
                                                    </td>
                                                    <td>
                                                        @foreach ($commande->services as $service)
                                                            {{ $service->nom }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($commande->services as $service)
                                                            {{ $service->pivot->quantite }}
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $commande->client->nom }} {{ $commande->client->prenom }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-sm bg-warning-light"
                                                                style="margin-right: 10%;" data-toggle="modal"
                                                                href="#edit_commande_details_{{ $commande->id }}">
                                                                <i class="fe fe-edit"></i> Editer
                                                            </a>
                                                            <a class="btn btn-sm bg-success-light"
                                                                style="margin-right: 10%;"
                                                                href="{{ route('facture.show', ['id' => $commande->id]) }}">
                                                                <i class="fe fe-print"></i> Exporter
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="edit_commande_details_{{ $commande->id }}"
                                                    aria-hidden="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier la Commande</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Formulaire de modification de commande -->
                                                                <form
                                                                    action="{{ route('commandes.update', ['commande' => $commande->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $commande->user_id }}">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $commande->id }}">
                                                                    <input type="hidden" name="client_id"
                                                                        value="{{ $commande->client_id }}">
                                                                    <div class="form-row">
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="clients">Client</label>
                                                                            <select id="clients" name="client_id"
                                                                                class="form-control" disabled>
                                                                                @foreach ($clients as $client)
                                                                                    <option value="{{ $client->id }}"
                                                                                        {{ $commande->client_id == $client->id ? 'selected' : '' }}>
                                                                                        {{ $client->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="services">Service</label>
                                                                            <select id="services" name="service_id"
                                                                                class="form-control">
                                                                                @foreach ($services as $service)
                                                                                    <option value="{{ $service->id }}"
                                                                                        {{ $commande->service_id == $service->id ? 'selected' : '' }}>
                                                                                        {{ $service->nom }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="quantite">Quantité</label>
                                                                            <input type="number" class="form-control"
                                                                                id="quantite" name="quantite"
                                                                                @foreach ($commande->services as $service)
                                                                        value="{{ $service->pivot->quantite }}" @endforeach>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Ajoutez d'autres champs de modification ici -->
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
                                            @endforeach
                                        @elseif (Str::lower(auth()->user()->role->etiquette) != 'manager')
                                            @foreach ($commandes as $commande)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input type="hidden" id="userCmd"
                                                            value="{{ $commande->user->id }}">
                                                        {{ $commande->user->nom }} {{ $commande->user->prenom }}
                                                    </td>
                                                    <td>
                                                        @foreach ($commande->services as $service)
                                                            {{ $service->nom }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($commande->services as $service)
                                                            {{ $service->pivot->quantite }}
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $commande->client->nom }} {{ $commande->client->prenom }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-sm bg-warning-light"
                                                                style="margin-right: 10%;" data-toggle="modal"
                                                                href="#edit_commande_details_{{ $commande->id }}">
                                                                <i class="fe fe-edit"></i> Editer
                                                            </a>
                                                            <a class="btn btn-sm bg-success-light"
                                                                style="margin-right: 10%;"
                                                                href="{{ route('facture.show', ['id' => $commande->id]) }}">
                                                                <i class="fe fe-print"></i> Exporter
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Modal de modification de commande -->
                                                <div class="modal fade" id="edit_commande_details_{{ $commande->id }}"
                                                    aria-hidden="true" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier la Commande</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Formulaire de modification de commande -->
                                                                <form
                                                                    action="{{ route('commandes.update', ['commande' => $commande->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $commande->user_id }}">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $commande->id }}">
                                                                    <input type="hidden" name="client_id"
                                                                        value="{{ $commande->client_id }}">
                                                                    <div class="form-row">
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="clients">Client</label>
                                                                            <select id="clients" name="client_id"
                                                                                class="form-control" disabled>
                                                                                @foreach ($clients as $client)
                                                                                    <option value="{{ $client->id }}"
                                                                                        {{ $commande->client_id == $client->id ? 'selected' : '' }}>
                                                                                        {{ $client->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="services">Service</label>
                                                                            <select id="services" name="service_id"
                                                                                class="form-control">
                                                                                @foreach ($services as $service)
                                                                                    <option value="{{ $service->id }}"
                                                                                        {{ $commande->service_id == $service->id ? 'selected' : '' }}>
                                                                                        {{ $service->nom }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="quantite">Quantité</label>
                                                                            <input type="number" class="form-control"
                                                                                id="quantite" name="quantite"
                                                                                @foreach ($commande->services as $service)
                                                                        value="{{ $service->pivot->quantite }}" @endforeach>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Ajoutez d'autres champs de modification ici -->
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
