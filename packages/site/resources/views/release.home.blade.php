<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, interactive-widget=resizes-content">

    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <link rel="icon" href="/favicon.png" type="image/x-icon">

    <title>{{ config('app.name', 'Spack') }}</title>

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    {{ vite_tags('vendor/site', 5203, 'main.ts') }}
</head>
<body>
    <x-hero/>
    <x-features :features="$features"/>
    <x-pricing :plans="$plans"/>
    <x-faq :faqs="$faqs"/>
    <x-footer/>
</body>
</html>
