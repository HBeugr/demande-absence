@extends('admin.template')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Role</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item active">Role</li>
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
                                <form action="{{ route('roles.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault01">Etiquette</label>
                                            <input type="text" class="form-control" id="validationDefault01"
                                                placeholder="Etiquette" name="etiquette" required>
                                            @error('etiquette')
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
                            <h4 class="card-title">Liste des Roles</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="role" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Etiquettes</th>
                                            <th>Descriptions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::ucfirst($role->etiquette) }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm bg-warning-light" style="margin-right: 10%;" data-toggle="modal" href="#edit_role_details_{{ $role->id }}">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light" style="margin-right: 10%;" data-toggle="modal" href="#delete_role_confirmation_{{ $role->id }}">
                                                            <i class="fe fe-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="edit_role_details_{{ $role->id }}" aria-hidden="true" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modifier le Role</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="etiquette">Etiquette</label>
                                                                    <input type="text" class="form-control" id="etiquette" name="etiquette" value="{{ $role->etiquette }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <input type="text" class="form-control" id="description" name="description" value="{{ $role->description }}">
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
                                            <div class="modal fade" id="delete_role_confirmation_{{ $role->id }}" aria-hidden="true" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Deletion</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Êtes-vous sur de vouloir supprimer le role "{{ $role->etiquette }}"?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST">
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
