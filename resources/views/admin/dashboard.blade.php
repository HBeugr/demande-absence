@extends('admin.template')
@section('content')
    @php
        $comUser = $user
            ->where('departement_id', $user->departement_id)
            ->get();
        $currentUserId = auth()->user()->id;

        $currentMonth = now()->month;

        //Employé
        $emplAbsence = $absences->filter(function ($absence) use ($currentUserId) {
            return $absence->user_id === $currentUserId;
        });

        $emplCommande = App\Models\Commande::whereMonth('created_at', $currentMonth)
            ->where('user_id', $currentUserId)
            ->get();
        $emplLivraison = App\Models\Livraison::whereHas('commande', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
            ->whereMonth('created_at', $currentMonth)
            ->get();

        //Commercial
        $comAbsence = App\Models\Absence::whereHas('user', function ($query) use ($currentUserId) {
            $query->where('departement_id', auth()->user()->departement_id)->where('id', '!=', $currentUserId);
        })
            ->whereMonth('date_debut', $currentMonth)
            ->get();
        $comCommande = App\Models\Commande::whereMonth('created_at', $currentMonth)->get();
        $comLivraison = App\Models\Livraison::whereMonth('created_at', $currentMonth)->get();
    @endphp
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Bienvenue {{ Str::ucfirst($user->nom) }} {{ Str::ucfirst($user->prenoms) }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Tableau de bords</li>
                    </ul>
                    <ul class="breadcrumb">
                        Département {{ Str::ucfirst($user->departement->nom) }}
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            @if (Str::lower($user->role->etiquette) == 'administrateur')
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary">
                                    <i class="fe fe-users"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $users->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Employés</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary">
                                    <i class="fe fe-clock"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $absences->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Absences</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning">
                                    <i class="fe fe-building"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $departements->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Départements</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning">
                                    <i class="fe fe-lock"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $roles->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Postes</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success border-success">
                                    <i class="fe fe-cart"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $services->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Produits</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success border-success">
                                    <i class="fe fe-add-cart"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $commandes->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Commandes</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger">
                                    <i class="fe fe-paper-plane"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $livraisons->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Livraisons</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger">
                                    <i class="fe fe-money"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $factures->count() }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted">Factures</h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (Str::lower($user->role->etiquette) == 'employé')
                @if (Str::lower($user->departement->nom == 'informatique'))
                    informatique
                @elseif (Str::lower($user->departement->nom == 'commercial'))
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-dark border-dark">
                                        <i class="fe fe-clock"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $emplAbsence->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Mon Nombre de Demande d'absences du Mois</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-dark w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-success border-success">
                                        <i class="fe fe-cart"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $services->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">
                                        Nombre de Produits
                                        <br>
                                        <br>
                                    </h6>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-danger border-danger">
                                        <i class="fe fe-add-cart"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $emplCommande->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">
                                        Commande du Mois
                                        <br>
                                        <br>
                                    </h6>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fe fe-paper-plane"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $emplLivraison->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">
                                        Livraisons du Mois
                                        <br>
                                        <br>
                                    </h6>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (Str::lower($user->departement->nom == 'communication'))
                    communication
                @endif
            @elseif (Str::lower($user->role->etiquette) == 'manager')
                @if (Str::lower($user->departement->nom == 'informatique'))
                    informatique
                @elseif (Str::lower($user->departement->nom == 'commercial'))
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fe fe-users"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $comUser->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Membres du departement</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fe fe-users"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $comAbsence->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Demande d'absences Mensuel</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fe fe-users"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $comCommande->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Commandes du Mois</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fe fe-users"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{ $comLivraison->count() }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Livraisons du Mois</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (Str::lower($user->departement->nom == 'communication'))
                    communication
                @endif
            @endif
        </div>
        <div class="row">
            @if (Str::lower($user->role->etiquette) == 'administrateur')
                <div class="col-md-12 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Liste du Personnel</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="personnel" class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Noms</th>
                                            <th>Prenoms</th>
                                            <th>Genre</th>
                                            <th>Mails</th>
                                            <th>Contacts</th>
                                            <th>Départements</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->nom }}</td>
                                                <td>{{ $user->prenoms }}</td>
                                                <td>
                                                    {{ $user->genre == 'Masculin' ? 'M' : ($user->genre == 'Feminin' ? 'F' : '') }}
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->contact }}</td>
                                                <td>{{ $user->departement->nom }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Liste des clients</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="client" class="table table-hover table-center mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Noms</th>
                                            <th>Prenoms</th>
                                            <th>Téléphones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $client->nom }}</td>
                                                <td>{{ $client->prenoms }}</td>
                                                <td>{{ $client->telephone }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
