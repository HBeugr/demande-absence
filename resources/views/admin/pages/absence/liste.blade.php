@extends('admin.template')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Liste de toutes les Demandes d'Absence</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bords</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('absences.index') }}">Demandes d'Absence</a></li>
                        <li class="breadcrumb-item active">Liste de Demande d'absences</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
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
                                    @if (Str::lower(auth()->user()->role->etiquette) == 'manager' &&
                                            Str::lower(auth()->user()->departement->nom) == 'commercial')
                                        @foreach ($absences->where('user.departement_id', auth()->user()->departement->id) as $absence)
                                            @if ($absence->user->id !== auth()->user()->id)
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
                                                            @if (is_null(($absence->cancelled_at && $absence->cancelled_by) || $absence->reponse))
                                                                <a class="btn btn-sm bg-warning-light" data-toggle="modal"
                                                                    href="#edit_absence_details_{{ $absence->id }}"
                                                                    title="reponse">
                                                                    <i class="fe fe-pocket"></i>
                                                                </a>
                                                            @else
                                                                <a class="btn btn-sm bg-warning-light"
                                                                    style="margin-right: 10%;" data-toggle="modal"
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
                                                                    action="{{ route('responseAbsence', ['absence' => $absence->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group">
                                                                        <label for="nom">Demande de l'employé</label>
                                                                        <br>
                                                                        <label for="nom">{{ $absence->user->nom }}
                                                                            {{ $absence->user->prenoms }}</label>
                                                                        <input id="nom" type="hidden" name="user_id"
                                                                            class="form-control"
                                                                            value="{{ $absence->user->id }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="statut_absence_id">Statut de
                                                                            l'Absence</label>
                                                                        <select id="statut_absence_id"
                                                                            name="statut_absence_id" class="form-control">
                                                                            @foreach ($statuts as $statut)
                                                                                <option value="{{ $statut->id }}"
                                                                                    {{ $statut->id == $absence->statut_absence_id ? 'selected' : '' }}>
                                                                                    {{ $statut->nom }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="motif_absence_id">Motif de
                                                                            l'Absence</label>
                                                                        <input id="motif_absence_id" type="hidden"
                                                                            name="motif_absence_id" class="form-control"
                                                                            value="{{ $absence->motif_absence_id }}">
                                                                        <select id="motif_absence_id"
                                                                            name="motif_absence_id" class="form-control"
                                                                            disabled>
                                                                            @foreach ($motifs as $motif)
                                                                                <option
                                                                                    value="{{ $motif->id }}"{{ $motif->id == $absence->motif_absence_id ? 'selected' : '' }}>
                                                                                    {{ $motif->nom }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="date_debut">Date de Début</label>
                                                                        <input id="date_debut" type="date"
                                                                            name="date_debut" class="form-control"
                                                                            value="{{ $absence->date_debut }}" disabled>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="date_fin">Date de Fin</label>
                                                                        <input id="date_fin" type="date" name="date_fin"
                                                                            class="form-control"
                                                                            value="{{ $absence->date_fin }}" disabled>
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
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Details la Demande d'absence</h5>
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
                                                                    <div class="form-row">
                                                                        <div class="col-md-3">
                                                                            <label for="statut_absence_id">Statut de l'Absence</label>
                                                                            <input id="statut_absence_id" type="text"
                                                                                name="statut_absence_id" class="form-control"
                                                                                value="{{ $absence->statutAbsence->nom }}" disabled>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="motif_absence_id">Motif de l'Absence</label>
                                                                            <input id="motif_absence_id" type="text"
                                                                                name="motif_absence_id" class="form-control"
                                                                                value="{{ $absence->motifAbsence->nom }}" disabled>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="date_debut">Date de Début</label>
                                                                            <input id="date_debut" type="date"
                                                                                name="date_debut" class="form-control"
                                                                                value="{{ $absence->date_debut }}" disabled>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="date_fin">Date de Fin</label>
                                                                            <input id="date_fin" type="date"
                                                                                name="date_fin" class="form-control"
                                                                                value="{{ $absence->date_fin }}" disabled>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif (Str::lower(auth()->user()->role->etiquette) != 'manager')
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
                                                            class="badge badge-pill bg-primary inv-badge">{{ $absence->statutAbsence->nom }}</span>
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
                                                        <a class="btn btn-sm bg-warning-light" data-toggle="modal"
                                                            href="#edit_absence_details_{{ $absence->id }}">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
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
                                                                action="{{ route('updateAbsence', ['absence' => $absence->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="form-group">
                                                                    <label for="nom">Demande de l'employé</label>
                                                                    <br>
                                                                    <label for="nom">{{ $absence->user->nom }}
                                                                        {{ $absence->user->prenoms }}</label>
                                                                    <input id="nom" type="hidden" name="user_id"
                                                                        class="form-control"
                                                                        value="{{ $absence->user->id }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="statut_absence_id">Statut de
                                                                        l'Absence</label>
                                                                    <select id="statut_absence_id"
                                                                        name="statut_absence_id" class="form-control">
                                                                        @foreach ($statuts as $statut)
                                                                            @if ($statut->nom !== 'En Attente')
                                                                                <option value="{{ $statut->id }}"
                                                                                    {{ $statut->id == $absence->statut_absence_id ? 'selected' : '' }}>
                                                                                    {{ $statut->nom }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="motif_absence_id">Motif de
                                                                        l'Absence</label>
                                                                    <select id="motif_absence_id" name="motif_absence_id"
                                                                        class="form-control" disabled>
                                                                        @foreach ($motifs as $motif)
                                                                            <option
                                                                                value="{{ $motif->id }}"{{ $motif->id == $absence->motif_absence_id ? 'selected' : '' }}>
                                                                                {{ $motif->nom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="date_debut">Date de Début</label>
                                                                    <input id="date_debut" type="date"
                                                                        name="date_debut" class="form-control"
                                                                        value="{{ $absence->date_debut }}" disabled>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="date_fin">Date de Fin</label>
                                                                    <input id="date_fin" type="date" name="date_fin"
                                                                        class="form-control"
                                                                        value="{{ $absence->date_fin }}" disabled>
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
