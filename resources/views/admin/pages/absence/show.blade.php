@extends('admin.template')
@section('content')
    <div class="content container-fluid">
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
                        <h5 class="card-title">Demande d'autorisation d'Absence</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('responseAbsence', ['absence' => $absence->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <strong for="nom">Demande de l'employé</strong>:
                                <label for="nom">{{ Str::ucfirst($absence->user->nom) }}
                                    {{ Str::ucfirst($absence->user->prenoms) }}</label>
                                <input id="nom" type="hidden" name="user_id" class="form-control"
                                    value="{{ $absence->user->id }}" required>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="statut_absence_id">Statut de
                                        l'Absence</label>
                                    <select id="statut_absence_id" name="statut_absence_id" class="form-control">
                                        @foreach ($statuts as $statut)
                                            <option value="{{ $statut->id }}"
                                                {{ $statut->id == $absence->statut_absence_id ? 'selected' : '' }}>
                                                {{ $statut->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="motif_absence_id">Motif de
                                        l'Absence</label>
                                    <input id="motif_absence_id" type="hidden" name="motif_absence_id" class="form-control"
                                        value="{{ $absence->motif_absence_id }}">
                                    <select id="motif_absence_id" name="motif_absence_id" class="form-control" disabled>
                                        @foreach ($motifs as $motif)
                                            <option
                                                value="{{ $motif->id }}"{{ $motif->id == $absence->motif_absence_id ? 'selected' : '' }}>
                                                {{ $motif->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="date_debut">Date de Début</label>
                                    <input id="date_debut" type="date" name="date_debut" class="form-control"
                                        value="{{ $absence->date_debut }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label for="date_fin">Date de Fin</label>
                                    <input id="date_fin" type="date" name="date_fin" class="form-control"
                                        value="{{ $absence->date_fin }}" disabled>
                                </div>
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
    </div>
@endsection
