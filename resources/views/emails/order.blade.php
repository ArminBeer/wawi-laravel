@extends('layouts.email_layout')

@section('preview')
Zutatennachbestellung Restaurant Strizzi
@endsection

@section('content')
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Hallo {{$bestellung->lieferant()->first()->ansprechpartner}},</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Wir würden bei Ihnen gerne folgende Produkte nachbestellen:</p>
    <ul style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">
        @foreach ($bestellung->zutaten()->with('einheit')->get()->toArray() as $zutat)
            <li style="list-style-position: inside;margin-left: 5px;">{{$zutat['name'] . ' ' . $zutat['pivot']['bestellmenge'] . ' ' . $zutat['einheit']['name'] }}</li>
        @endforeach
    </ul>
    </p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;margin-top: 15px">Diese Bestellung ist bei uns hinterlegt unter folgender Bestellnummer: {{ $bestellung->id }}</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;margin-top: 15px">{!! nl2br($bestellung->bestellnotiz) !!}</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;">Vielen Dank,</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Ihr Team von Strizzi</p>
@endsection
