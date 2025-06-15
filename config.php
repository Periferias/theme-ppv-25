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

    'mailer.templates' => [
        'welcome' => [
            'title' => i::__("Bem-vindo(a) ao Mapas Culturais"),
            'template' => 'welcome.html'
        ],
        'last_login' => [
            'title' => i::__("Acesse a Mapas Culturais"),
            'template' => 'last_login.html'
        ],
        'new' => [
            'title' => i::__("Novo registro"),
            'template' => 'new.html'
        ],
        'update_required' => [
            'title' => i::__("Acesse a Mapas Culturais"),
            'template' => 'update_required.html'
        ],
        'compliant' => [
            'title' => i::__("Denúncia - Mapas Culturais"),
            'template' => 'compliant.html'
        ],
        'suggestion' => [
            'title' => i::__("Mensagem - Mapas Culturais"),
            'template' => 'suggestion.html'
        ],
        'seal_toexpire' => [
            'title' => i::__("Selo Certificador Expirando"),
            'template' => 'seal_toexpire.html'
        ],
        'seal_expired' => [
            'title' => i::__("Selo Certificador Expirado"),
            'template' => 'seal_expired.html'
        ],
        'opportunity_claim' => [
            'title' => i::__("Solicitação de Recurso de Oportunidade"),
            'template' => 'opportunity_claim.html'
        ],
        'request_relation' => [
            'title' => i::__("Solicitação de requisição"),
            'template' => 'request_relation.html'
        ],
        'start_registration' => [
            'title' => i::__("Inscrição iniciada"),
            'template' => 'start_registration.html'
        ],
        'start_data_collection_phase' => [
            'title' => i::__("Sua inscrição avaçou de fase"),
            'template' => 'start_data_collection_phase.html'
        ],
        'export_spreadsheet' => [
            'title' => i::__("Planilha disponível"),
            'template' => 'export_spreadsheet.html'
        ],
        'export_spreadsheet_error' => [
            'title' => i::__("Houve um erro com o arquivo"),
            'template' => 'export_spreadsheet_error.html'
        ],
        'send_registration' => [
            'title' => i::__("Inscrição enviada"),
            'template' => 'send_registration.html'
        ],
        'claim_form' => [
            'title' => i::__("Solicitação de recurso"),
            'template' => 'claim_form.html'
        ],
        'claim_certificate' => [
            'title' => i::__("Certificado de solicitação de recurso"),
            'template' => 'claim_certificate.html'
        ],

    ],

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
    ],

];
