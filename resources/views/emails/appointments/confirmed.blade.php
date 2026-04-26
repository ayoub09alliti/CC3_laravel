<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Confirmation de rendez-vous') }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #0f172a; line-height: 1.6;">
    <h2>{{ __('Bonjour :name,', ['name' => $appointment->patient->name]) }}</h2>

    <p>{{ __('Votre rendez-vous a ete confirme.') }}</p>

    <p>{{ __('Voici les informations de votre rendez-vous :') }}</p>

    <ul>
        <li><strong>{{ __('Medecin :') }}</strong> {{ $appointment->doctor->name }}</li>
        <li><strong>{{ __('Service :') }}</strong> {{ $appointment->service->name }}</li>
        <li><strong>{{ __('Date :') }}</strong> {{ $appointment->appointment_date->format('d/m/Y') }}</li>
        <li><strong>{{ __('Heure :') }}</strong> {{ \Illuminate\Support\Str::of($appointment->appointment_time)->limit(5, '') }}</li>
        <li><strong>{{ __('Statut :') }}</strong> {{ __('Confirme') }}</li>
    </ul>

    @if ($appointment->notes)
        <p><strong>{{ __('Notes :') }}</strong> {{ $appointment->notes }}</p>
    @endif

    <p>{{ __('Merci.') }}</p>
</body>
</html>
