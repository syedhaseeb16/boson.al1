<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

{!! Assets::renderHeader(['core']) !!}

<link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/themes/default.css') }}?v={{ get_cms_version() }}">

<link rel="stylesheet" href="{{ asset('vendor/core/plugins/marketplace/fonts/Linearicons/Font/demo-files/demo.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/marketplace/css/style.css') }}?v=1.0">

@if (BaseHelper::siteLanguageDirection() == 'rtl')
    <link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/rtl.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('vendor/core/plugins/marketplace/css/rtl.css') }}?v=1.0">
@endif
