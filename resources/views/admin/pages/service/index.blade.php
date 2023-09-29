@extends('admin.template')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Service</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item active">Service</li>
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
                                <form action="{{ route('services.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault01">Nom</label>
                                            <input type="text" class="form-control" id="validationDefault01"
                                                placeholder="Nom" name="nom" required>
                                            @error('nom')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault02">Description</label>
                                            <input type="text" class="form-control" id="validationDefault02"
                                                placeholder="Description" name="description" required>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault02">Prix</label>
                                            <input type="number" class="form-control" id="validationDefault02"
                                                placeholder="Prix" name="prix" required>
                                            @error('prix')
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
                            <h4 class="card-title">Liste des Services</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="service" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Noms</th>
                                            <th>Description</th>
                                            <th>Prix</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->nom }}</td>
                                                <td>{{ $service->description }}</td>
                                                <td>{{ $service->prix }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm bg-warning-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#edit_service_details_{{ $service->id }}">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#delete_service_confirmation_{{ $service->id }}">
                                                            <i class="fe fe-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="edit_service_details_{{ $service->id }}"
                                                aria-hidden="true" service="dialog">
                                                <div class="modal-dialog modal-dialog-centered" service="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modifier le service</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('services.update', ['service' => $service->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="nom">Nom</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nom" name="nom"
                                                                        value="{{ $service->nom }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <input type="text" class="form-control"
                                                                        id="description" name="description"
                                                                        value="{{ $service->description }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="prix">Prix</label>
                                                                    <input type="number" class="form-control"
                                                                        id="prix" name="prix"
                                                                        value="{{ $service->prix }}">
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
                                            <div class="modal fade" id="delete_service_confirmation_{{ $service->id }}"
                                                aria-hidden="true" service="dialog">
                                                <div class="modal-dialog modal-dialog-centered" service="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Deletion</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Êtes-vous sur de vouloir supprimer le service
                                                                "{{ $service->nom }} {{ $service->prenoms }}"?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('services.destroy', ['service' => $service->id]) }}"
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
