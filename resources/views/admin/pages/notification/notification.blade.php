@php
    $nouvelDemande = $notifications->where('type', 'App\Notifications\NouvelDemande');
    $nouvelReponse = $notifications->where('type', 'App\Notifications\NouvelReponse');
@endphp
<li class="nav-item dropdown noti-dropdown">
    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
        <i class="fe fe-bell"></i> <span class="badge badge-pill">
            @php
                $nbMessage = $nouvelDemande->count()+$nouvelReponse->count()
            @endphp
            {{$nbMessage}}
        </span>
    </a>
    <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
            <span class="notification-title">Notifications</span>
            <a href="javascript:void(0)" class="clear-noti"> Tout marqué comme lu </a>
        </div>
        <div class="noti-content">
            <ul class="notification-list">
                @if ($nouvelDemande->count() > 0)
                    @foreach ($nouvelDemande as $notifDemande)
                        @php
                            $user = \App\Models\User::find($notifDemande->data['user_id']);
                            $statuts = \App\Models\StatutAbsence::all();
                            $motifs = \App\Models\MotifAbsence::all();
                            $absence = \App\Models\Absence::where('user_id', $user->id)
                                ->where('statut_absence_id', $notifDemande->data['statut_absence_id'])
                                ->where('motif_absence_id', $notifDemande->data['motif_absence_id'])
                                ->where('date_debut', $notifDemande->data['date_debut'])
                                ->where('date_fin', $notifDemande->data['date_fin'])
                                ->where('created_at', $notifDemande->data['created_at'])
                                ->first();
                        @endphp
                        <li class="notification-message">
                            <a id="contactMark" href="{{ route('absences.show', ['absence' => $absence->id]) }}"
                                class="dropdown-item" data-absence-id="{{ $absence->id }}"
                                data-id="{{ $notifDemande->id }}">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title">{{ Str::ucfirst($user->nom) }}
                                                {{ Str::ucfirst($user->prenoms) }}</span>
                                            @if (Str::lower(auth()->user()->role->etiquette) == 'administrateur')
                                                ({{ $user->departement->description }})
                                            @endif <br>
                                            <span class="noti-title"> a fait une demande d'absence.</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">
                                                {{ $notifDemande->created_at->format('d-m-Y à H:i') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @elseif ($nouvelReponse->count() > 0)
                    @foreach ($nouvelReponse as $notifReponse)
                        @php
                            $user = \App\Models\User::find($notifReponse->data['user_id']);
                            $statuts = \App\Models\StatutAbsence::all();
                            $motifs = \App\Models\MotifAbsence::all();
                            $absence = \App\Models\Absence::where('user_id', $user->id)
                                ->where('statut_absence_id', $notifReponse->data['statut_absence_id'])
                                ->where('motif_absence_id', $notifReponse->data['motif_absence_id'])
                                ->where('date_debut', $notifReponse->data['date_debut'])
                                ->where('date_fin', $notifReponse->data['date_fin'])
                                ->where('created_at', $notifReponse->data['created_at'])
                                ->first();
                            $jsonData = $notifReponse->data['reponse'];
                            $data = json_decode($jsonData);
                            $superieurId = $data->superieurId;
                            $userApprouve = \App\Models\User::find($superieurId);
                        @endphp
                        <li class="notification-message">
                            <a id="contactMark" href="{{ route('showResponse', ['absence' => $absence->id]) }}"
                                class="dropdown-item" data-absence-id="{{ $absence->id }}"
                                data-id="{{ $notifReponse->id }}">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details"><span
                                                class="noti-title">{{ Str::ucfirst($userApprouve->nom) }}
                                                {{ Str::ucfirst($userApprouve->prenoms) }}</span>
                                            <span class="noti-title"> a donné suite <br> à votre une demande
                                                d'absence.</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">
                                                {{ $notifReponse->created_at->format('d-m-Y à H:i') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                <p class="dropdown-item">Il n'y a pas de nouvelles notifications</p>
                @endif
            </ul>
        </div>
        <div class="topnav-dropdown-footer">
            <a href="#">View all Notifications</a>
        </div>
    </div>
</li>
