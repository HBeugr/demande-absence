@extends('admin.template')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Département</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item active">Département</li>
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
                                <form action="{{ route('departements.store') }}" method="POST">
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
                                            <label for="validationDefault02">Description</label>
                                            <input type="text" class="form-control" id="validationDefault02"
                                                placeholder="description" name="description" required>
                                            @error('description')
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
                            <h4 class="card-title">Liste des Départements</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="departement" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Noms</th>
                                            <th>Descriptions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departements as $departement)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::ucfirst($departement->nom) }}</td>
                                                <td>{{ $departement->description }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm bg-warning-light" style="margin-right: 10%;" data-toggle="modal" href="#edit_departement_details_{{ $departement->id }}">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light" style="margin-right: 10%;" data-toggle="modal" href="#delete_departement_confirmation_{{ $departement->id }}">
                                                            <i class="fe fe-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="edit_departement_details_{{ $departement->id }}" aria-hidden="true" departement="dialog">
                                                <div class="modal-dialog modal-dialog-centered" departement="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modifier le departement</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('departements.update', ['departement' => $departement->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="nom">nom</label>
                                                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $departement->nom }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <input type="text" class="form-control" id="description" name="description" value="{{ $departement->description }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete_departement_confirmation_{{ $departement->id }}" aria-hidden="true" departement="dialog">
                                                <div class="modal-dialog modal-dialog-centered" departement="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Deletion</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Êtes-vous sur de vouloir supprimer le departement "{{ $departement->nom }}"?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('departements.destroy', ['departement' => $departement->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-danger">Supprimer</button>
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
