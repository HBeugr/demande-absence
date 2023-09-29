@extends('admin.template')

@section('content')
    <style>
        body {
            background: #ccc;
            padding: 30px;
        }

        .container {
            width: 21cm;
            min-height: 26cm;
        }

        .invoice {
            background: #fff;
            width: 100%;
            padding: 50px;
        }

        .logo {
            width: 2.5cm;
        }

        .document-type {
            text-align: right;
            color: #444;
        }

        .conditions {
            font-size: 0.7em;
            color: #666;
        }

        .bottom-page {
            font-size: 0.7em;
        }

        #generate_pdf {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 20%;
            margin-left: 40%;
            margin-top: 20px;
        }

        #generate_pdf:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container">
        <input type="hidden" name="infoFacture" id="infoFacture" value="Facture-Client-{{ str_replace(' ', '-', $facture->commande->client->nom) }}-{{ str_replace(' ', '-', $facture->commande->client->prenoms) }}">

        <div class="invoice">
            <div class="row">
                <div class="col-7">
                    <strong>
                        <h1 class="document-type display-4 text-left">{{ env('APP_NAME') }}</h1>
                    </strong>
                </div>
                <div class="col-5">
                    <h1 class="document-type display-4">FACTURE</h1>
                    <p class="text-center">
                        <strong>N° <br></strong>
                        <strong style="margin-left: -12%"> {{ $facture->numero_facture }}</strong>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <p>
                        <strong>Abidjan, Côte d'Ivoire</strong><br>
                        PGI<br>
                        Angré, Mahou
                    </p>
                </div>
                <div class="col-5">
                    <br><br><br>
                    <p>
                        <strong>Client</strong><br>
                        Réf. <em>{{ $facture->commande->client->nom }} {{ $facture->commande->client->prenoms }}</em><br>
                        {{ $facture->commande->client->email }} <br> {{ $facture->commande->client->telephone }}
                    </p>
                </div>
            </div>
            <br>
            <br>
            <h6> <strong>Mode de Payement:</strong> En espèce <br>
                <strong>Emis le:</strong>
                {{ \Carbon\Carbon::parse($facture->date_facture)->formatLocalized('%e %b. %Y') }}
            </h6>
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Description</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Prix Unitaire</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facture->commande->services as $service)
                        <tr>
                            <td>{{ $service->nom }}</td>
                            <td>{{ $service->description }}</td>
                            <td class="text-right">{{ $service->pivot->quantite }}</td>
                            <td class="text-center">{{ $service->prix }} F CFA</td>
                            <td class="text-right">
                                {{ $service->pivot->quantite * $service->prix }} F CFA
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4">
                    <table class="table table-sm text-right">
                        {{-- <tr>
                            <td><strong>Total HT</strong></td>
                            <td class="text-right">3 700,00€</td>
                        </tr>
                        <tr>
                            <td>TVA 20%</td>
                            <td class="text-right">740,00€</td>
                        </tr> --}}
                        <tr>
                            <td class="text-center"><strong>Montant Total</strong></td>
                            <td class="text-center">{{ $facture->montant_facture }} F CFA</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p class="conditions">
                Pour votre gestion d'absence et vos services clients,
                <br>
                Nous vous remercions de votre confiance.
                <br><br>
            </p>

            <br>
            <br>
            <br>
            <br>

            <p class="bottom-page text-right">
                Votre Société de Gestion d'Absence et de Clientèle <br>
                Adresse de Votre Entreprise *Côte d'Ivoire, Abidjan, Angré Mahou - Code Postal Ville - Numéro de Téléphone -
                www.pgi.com <br>
            </p>

        </div>
        <button id="generate_pdf">
            <i class="fe fe-print"></i> Exporter</button>
    </div>

@endsection
