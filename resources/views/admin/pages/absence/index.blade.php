@extends('admin.template')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Formulaire Demande d'Absence</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('absences.index') }}">Demandes d'Absence</a></li>
                        <li class="breadcrumb-item active">Nouvelle Demande</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Formulaire de Demande d'Absence</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <form action="{{ route('absences.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group form-row col-md-4" style="display: none;">
                                        <label for="statut_absence_id">Statut de l'Absence</label>
                                        <select id="statut_absence_id" name="statut_absence_id" class="form-control">
                                            @foreach ($statuts as $statut)
                                                @if ($statut->nom == 'En Attente')
                                                    <option value="{{ $statut->id }}">{{ $statut->nom }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('statut_absence_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="motif_absence_id">Motif de l'Absence</label>
                                            <select id="motif_absence_id" name="motif_absence_id" class="form-control">
                                                @foreach ($motifs as $motif)
                                                    <option value="{{ $motif->id }}">{{ $motif->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('motif_absence_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="date_debut">Date de début</label>
                                            <input id="date_debut" type="date" name="date_debut" class="form-control"
                                                required>
                                            @error('date_debut')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="date_fin">Date de fin</label>
                                            <input id="date_fin" type="date" name="date_fin" class="form-control"
                                                required>
                                            @error('date_fin')
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Liste des Absences</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="absences" class="table table-hover table-center mb-0" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Utilisateur</th>
                                        <th>Statut de l'Absence</th>
                                        <th>Motif de l'Absence</th>
                                        <th>Date de Début</th>
                                        <th>Date de Fin</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $absence)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $absence->user->nom }}</td>
                                            <td>
                                                @if ($absence->statutAbsence->nom === 'En Attente')
                                                    <span
                                                        class="badge badge-pill bg-warning inv-badge">{{ $absence->statutAbsence->nom }}</span>
                                                @elseif ($absence->statutAbsence->nom === 'Approuvée')
                                                    <span
                                                        class="badge badge-pill bg-success inv-badge">{{ $absence->statutAbsence->nom }}</span>
                                                @elseif ($absence->statutAbsence->nom === 'Refusée')
                                                    <span
                                                        class="badge badge-pill bg-danger inv-badge">{{ $absence->statutAbsence->nom }}</span>
                                                @elseif ($absence->statutAbsence->nom === 'Annulée')
                                                    <span
                                                        class="badge badge-pill bg-dark inv-badge">{{ $absence->statutAbsence->nom }}</span>
                                                @else
                                                    {{ $absence->statutAbsence->nom }}
                                                @endif
                                            </td>
                                            <td>{{ $absence->motifAbsence->nom }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($absence->date_debut)->formatLocalized('%e %b. %Y') }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($absence->date_fin)->formatLocalized('%e %b. %Y') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if (is_null($absence->cancelled_at) && is_null($absence->cancelled_by) && is_null($absence->reponse))
                                                        <a class="btn btn-sm bg-dark-light cancel-absence-button"
                                                            style="margin-right: 10%;"
                                                            data-absence-id="{{ $absence->id }}">
                                                            <i class="fe fe-close"></i>
                                                        </a>
                                                        <a class="btn btn-sm bg-warning-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#edit_absence_details_{{ $absence->id }}">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#delete_absence_confirmation_{{ $absence->id }}">
                                                            <i class="fe fe-trash"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-sm bg-warning-light" style="margin-right: 10%;"
                                                            data-toggle="modal"
                                                            href="#show_absence_confirmation_{{ $absence->id }}">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="edit_absence_details_{{ $absence->id }}"
                                            aria-hidden="true" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modifier la Demande d'absence</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('absences.update', ['absence' => $absence->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="statut_absence_id">Statut de l'Absence</label>
                                                                <select id="statut_absence_id" name="statut_absence_id"
                                                                    class="form-control" disabled>
                                                                    @foreach ($statuts as $statut)
                                                                        @if ($statut->nom == 'Annulée')
                                                                            <option value="{{ $statut->id }}" selected>
                                                                                {{ $statut->nom }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="motif_absence_id">Motif de l'Absence</label>
                                                                <select id="motif_absence_id" name="motif_absence_id"
                                                                    class="form-control">
                                                                    @foreach ($motifs as $motif)
                                                                        <option value="{{ $motif->id }}">
                                                                            {{ $motif->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="date_debut">Date de Début</label>
                                                                <input id="date_debut" type="date" name="date_debut"
                                                                    class="form-control"
                                                                    value="{{ $absence->date_debut }}" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="date_fin">Date de Fin</label>
                                                                <input id="date_fin" type="date" name="date_fin"
                                                                    class="form-control" value="{{ $absence->date_fin }}"
                                                                    required>
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
                                        <div class="modal fade" id="show_absence_confirmation_{{ $absence->id }}"
                                            aria-hidden="true" role="dialog">
                                            @php
                                                $jsonData = $absence->reponse;
                                                $data = json_decode($jsonData);
                                                $superieurId = $data->superieurId;
                                                $userApprouve = \App\Models\User::find($superieurId);
                                            @endphp
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reponse à votre Demande d'Autorisation
                                                            d'Absence</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="col-md-3">
                                                                <label for="statut_absence_id">Statut de
                                                                    l'Absence</label>
                                                                <input id="statut_absence_id" type="text"
                                                                    name="statut_absence_id" class="form-control"
                                                                    value="{{ $absence->statutAbsence->nom }}" disabled>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="motif_absence_id">Motif de
                                                                    l'Absence</label>
                                                                <input id="motif_absence_id" type="text"
                                                                    name="motif_absence_id" class="form-control"
                                                                    value="{{ $absence->motifAbsence->nom }}" disabled>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="date_debut">Date de Début</label>
                                                                <input id="date_debut" type="date" name="date_debut"
                                                                    class="form-control"
                                                                    value="{{ $absence->date_debut }}" disabled>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="date_fin">Date de Fin</label>
                                                                <input id="date_fin" type="date" name="date_fin"
                                                                    class="form-control" value="{{ $absence->date_fin }}"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <small>Repondu par
                                                            @if ($userApprouve->genre == 'Masculin')
                                                                M.
                                                            @else
                                                                Mme / Mlle
                                                            @endif
                                                             <strong>
                                                                {{ Str::ucfirst($userApprouve->nom) }}
                                                                {{ Str::ucfirst($userApprouve->prenoms) }}
                                                            </strong>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="delete_absence_confirmation_{{ $absence->id }}"
                                            aria-hidden="true" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" absence="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Deletion</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            Êtes-vous sur de vouloir supprimer cette demande d'absence pour
                                                        </p>
                                                        <p>
                                                            la période du
                                                            "{{ \Carbon\Carbon::parse($absence->date_debut)->formatLocalized('%e %b. %Y') }}
                                                            au
                                                            {{ \Carbon\Carbon::parse($absence->date_fin)->formatLocalized('%e %b. %Y') }}"?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form
                                                            action="{{ route('absences.destroy', ['absence' => $absence->id]) }}"
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
@endsection
