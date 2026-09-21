{{-- Comprehensive SEO Meta Tags --}}
@php
    $defaultTitle = 'Rani Matrimonial | Find Your Perfect Partner - 100% Verified Matchmaking';
    $pageTitle = trim(View::yieldContent('title')) ? View::yieldContent('title') : $defaultTitle;
    $metaDescription = trim(View::yieldContent('meta_description')) ? View::yieldContent('meta_description') : 'Rani Matrimonial is India\'s most trusted matrimonial platform offering 100% verified profiles, Aadhar verification, privacy protection, and personalised matchmaking across all communities.';
    $metaKeywords = trim(View::yieldContent('meta_keywords')) ? View::yieldContent('meta_keywords') : 'matrimony, matrimonial site, indian matrimony, shaadi, verified brides grooms, marriage bureau, rani matrimonial, sumatra sales';
    $canonicalUrl = trim(View::yieldContent('canonical_url')) ? View::yieldContent('canonical_url') : url()->current();
    $ogType = trim(View::yieldContent('og_type')) ? View::yieldContent('og_type') : 'website';
    $ogImage = trim(View::yieldContent('og_image')) ? View::yieldContent('og_image') : asset('logo.png');
    $ogImageAlt = trim(View::yieldContent('og_image_alt')) ? View::yieldContent('og_image_alt') : 'Rani Matrimonial';
    $metaRobots = trim(View::yieldContent('meta_robots')) ? View::yieldContent('meta_robots') : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';

    $baseSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => url('/') . '/#organization',
                'name' => 'Rani Matrimonial',
                'legalName' => 'Sumatra Sales Private Limited',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    '@id' => url('/') . '/#logo',
                    'url' => asset('logo.png'),
                    'caption' => 'Rani Matrimonial Logo'
                ],
                'image' => asset('logo.png'),
                'description' => 'Rani Matrimonial is a premium matchmaking platform managed by Sumatra Sales Private Limited, helping genuine candidates find their life partners with trust, privacy, and authenticity.',
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'contactType' => 'Customer Support',
                    'availableLanguage' => ['English', 'Hindi', 'Bengali'],
                    'areaServed' => 'IN'
                ]
            ],
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '/#website',
                'url' => url('/'),
                'name' => 'Rani Matrimonial',
                'publisher' => [
                    '@id' => url('/') . '/#organization'
                ],
                'inLanguage' => 'en-IN'
            ]
        ]
    ];
@endphp

<!-- Basic Meta Tags -->
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="Sumatra Sales Private Limited - Rani Matrimonial">
<meta name="robots" content="{{ $metaRobots }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook / WhatsApp -->
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="Rani Matrimonial">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:secure_url" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $ogImageAlt }}">
<meta property="og:locale" content="en_IN">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:image:alt" content="{{ $ogImageAlt }}">

<!-- Base Organization & Website Schema -->
<script type="application/ld+json">
{!! json_encode($baseSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>

<!-- Page-Specific JSON-LD Schema -->
@yield('schema')
@stack('schema')
