<?php 
use \MapasCulturais\i;

return [
    'app.siteName' => 'Prêmio Periferia Viva 2025',
    /* 
    Define o nome do asset da imagem da logo do site - Substituirá a logo padrão

    ex: `img/meu-mapa-logo.jpg` (pasta assets/img/meu-mapa-logo.jpg do tema) 
    */
    'logo.image' => './img/logo-site.png',
    'logo.hideLabel' => env('LOGO_HIDELABEL', true),

    /* 
    Define o nome do asset da imagem do background e banner no header da home - Substituirá o background padrão
    ex: `img/meu-home-header-background.jpg` (pasta assets/img/meu-home-header-background.jpg do tema)
    */
    'homeHeader.background' => './img/home-header/home-header2.jpg',
    'auth.provider' => 'MapasCulturais\AuthProviders\OpauthAuthentik',
    'auth.config' => [
        'login_url' => 'https://dev-backend.100.28.135.68.sslip.io',
        'logout_url' => 'https://dev-backend.100.28.135.68.sslip.io/o/profile/',
        'redirect_uri' => 'https://ppv-25.mapadasperiferias.com/autenticacao/authentik/oauth2callback',
        'auth_endpoint' => '/o/authorize/',
        'token_endpoint' => '/o/token/',
        'user_info_endpoint' => '/o/userinfo/',
        'salt' => env('AUTH_SALT', 'SECURITY_SALT'),
        'timeout' => '24 hours',
        'client_id' => env('AUTH_AUTHENTIK_APP_ID', ''),
        'client_secret' => env('AUTH_AUTHENTIK_APP_SECRET', ''),
        'scope' => env('AUTH_AUTHENTIK_SCOPE', 'read write profile'),
    ]

];