<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="menu-title">
                <span>Principal</span>
            </li>

            @php
                $menuItems = [
                    ['route' => 'accueil', 'name' => 'accueil', 'label' => 'Tableau de Bords', 'icon' => 'fe fe-home', 'permission' => true],
                    ['route' => 'utilisateurs.index', 'name' => 'utilisateurs', 'label' => 'Employés', 'icon' => 'fe fe-users', 'permission' => true],
                    ['route' => 'clients.index', 'name' => 'clients', 'label' => 'Clients', 'icon' => 'fe fe-user', 'permission' => true],
                    ['route' => 'commandes.index', 'name' => 'commandes', 'label' => 'Commandes', 'icon' => 'fe fe-add-cart', 'permission' => true],
                    ['route' => 'services.index', 'name' => 'services', 'label' => 'Produits', 'icon' => 'fe fe-cart', 'permission' => in_array(Str::lower(auth()->user()->role->etiquette), ['administrateur', 'manager'])],
                    ['route' => 'departements.index', 'name' => 'departements', 'label' => 'Département', 'icon' => 'fe fe-building', 'permission' => Str::lower(auth()->user()->role->etiquette) == 'administrateur'],
                    ['route' => 'roles.index', 'name' => 'roles', 'label' => 'Role', 'icon' => 'fe fe-lock', 'permission' => Str::lower(auth()->user()->role->etiquette) == 'administrateur']
                ];
            @endphp

            @foreach ($menuItems as $item)
                @if ($item['permission'])
                    <li class="{{ request()->is($item['name'] .'*') ? 'active' : '' }}">
                        <a href="{{ route($item['route']) }}">
                            @if (isset($item['icon']))
                                <i class="fe {{ $item['icon'] }}"></i>
                            @endif
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
            @if (in_array(Str::lower(auth()->user()->role->etiquette), ['administrateur', 'manager']))
                <li class="submenu">
                    <a href="#"><i class="fe fe-document"></i> <span> Demande Absence</span> <span
                            class="menu-arrow"></span></a>
                    <ul
                        style="display:
            @if (request()->is('absences*') || request()->is('liste*') || request()->is('motifs*') || request()->is('statuts*')) block;
            @else none; @endif">
                        <li class="{{ request()->is('liste*') ? 'active' : '' }}"><a href="{{ route('liste') }}">Toutes
                                les demandes</a></li>
                        <li class="{{ request()->is('absences*') ? 'active' : '' }}"><a
                                href="{{ route('absences.index') }}">Mes Absences</a></li>
                        @if (Str::lower(auth()->user()->role->etiquette) !== 'manager')
                            {{-- Correction ici --}}
                            <li class="{{ request()->is('motifs*') ? 'active' : '' }}"><a
                                    href="{{ route('motifs.index') }}">Motifs Absences</a></li>
                            <li class="{{ request()->is('statuts*') ? 'active' : '' }}"><a
                                    href="{{ route('statuts.index') }}">Statuts Absences</a></li>
                        @endif
                    </ul>
                </li>
            @else
                <li class="{{ request()->is('absences*') ? 'active' : '' }}">
                    <a href="{{ route('absences.index') }}"><i class="fe fe-lock"></i> <span>Mes Absences</span></a>
                </li>
            @endif
        </ul>
    </div>
</div>
