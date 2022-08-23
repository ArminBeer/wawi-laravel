@extends('layouts.email_layout')

@section('preview')
Sie wurden erfolgreich als Benutzer des Strizzi Warenwirtschaftsystems freigeschalten.
@endsection

@section('content')
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Hallo {{$user['name']}},</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Sie wurden erfolgreich als Benutzer des Strizzi Warenwirtschaftsystems freigeschalten. Mit dem nachstehenden Link können Sie ein Passwort für Ihren Account definieren, um sich in Zukunft mit Ihren Zugangsdaten einloggen zu können:</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Ihre Zugangsdaten lauten:
    <ul style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">
        <li style="list-style-position: inside;margin-left: 5px;">Link: {{$url_db}}</li>
        <li style="list-style-position: inside;margin-left: 5px;">E-Mail-Adresse: {{$user['email']}}</li>
        <li style="list-style-position: inside;margin-left: 5px;">Passwort: <i>von Ihnen definiert</i></li>
    </ul>
    </p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Bitte <a href="{{$url}}" style="color: #3498db;text-decoration: underline;">klicken Sie auf diesen Link</a>, um ein Passwort zu setzen.</p>
    <p style="font-family: sans-serif;font-size: 14px;font-weight: normal;margin: 0;margin-bottom: 15px;">Ihr Team von Strizzi</p>
@endsection
