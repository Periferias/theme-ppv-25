<?php 
// Desativar qualquer saída adicional
while (ob_get_level()) ob_end_clean();

use MapasCulturais\i;

$this->import('
    mc-summary-agent
    mc-summary-agent-info
    mc-summary-project
    mc-summary-spaces
    v1-embed-tool
    opportunity-phases-timeline
');

$entity = $entity->firstPhase;
?>

<main class="print-registration">
    <!-- Cabeçalho -->
    <section class="section">
        <div class="registration-header">
            <h1 class="text-center mb-0"><?= i::__('Comprovante de Inscrição') ?></h1>
            <div class="registration-meta">
                <div><strong><?= i::__('Inscrição') ?></strong> {{registration.number}}</div>
                <div><strong><?= i::__('Data') ?></strong> {{registration.sentTimestamp.date('2-digit year')}}</div>
                <div><strong><?= i::__('Categoria') ?></strong> {{registration.category}}</div>
                <div><strong><?= i::__('Status') ?></strong> {{registration.status}}</div>
            </div>
            <?php if ($entity->sentTimestamp): ?>
                <div class="text-center text-small">
                    <?= i::__('Inscrição realizada em') ?> {{registration.sentTimestamp.date('2-digit year')}} <?= i::__('às') ?> {{registration.sentTimestamp.time('long')}}
                </div>
            <?php endif; ?>
        </div>

        <div class="col-12">
            <opportunity-phases-timeline :entity-status="registration.status" center big></opportunity-phases-timeline>
        </div>
    </section>

    <!-- Dados do Proponente -->
    <section class="section">
        <div class="card">
            <h2><?= i::__('Dados do Proponente') ?></h2>
            <mc-summary-agent :entity="registration"></mc-summary-agent>
            <mc-summary-agent-info :entity="registration"></mc-summary-agent-info>
        </div>
    </section>

    <!-- Dados do formulário -->
    <section class="section">
        <div class="card">
            <h2><?= i::__('Dados Informados no Formulário') ?></h2>
            <mc-summary-spaces :entity="registration"></mc-summary-spaces>
            <mc-summary-project :entity="registration"></mc-summary-project>
        </div>
    </section>

    <!-- Fases -->
    <section class="section" v-for="(phase, index) in registration.phases" :key="phase.id">
        <div class="card">
            <h2>{{ phase.name }}</h2>
            <v1-embed-tool route="registrationview" :id="phase.id"></v1-embed-tool>
        </div>
    </section>

    <!-- Marcador para evitar páginas em branco -->
    <div class="end-of-document-marker"></div>
</main>

<style>
    /* Estilos normais da página - SEM ALTERAÇÕES */
    .print-registration {
        position: relative;
        overflow: visible !important;
        width: 100%;
        background: white;
    }

    .section {
        margin-bottom: 20px;
        page-break-inside: avoid;
    }

    .card {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        page-break-inside: avoid;
    }

    .registration-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .registration-meta {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
        flex-wrap: wrap;
    }

    .registration-meta > div {
        margin: 5px;
    }

    .end-of-document-marker {
        position: absolute;
        bottom: 0;
        height: 1px;
        width: 1px;
        z-index: -1000;
    }

    /* APENAS estilos de impressão - não afeta visualização normal */
    @media print {
        /* Configuração da página */
        @page {
            size: A4;
            margin: 15mm 15mm 10mm 15mm;
        }
        
        /* Forçar remoção COMPLETA de barras de rolagem */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        *::-webkit-scrollbar {
            display: none !important;
            width: 0px !important;
            height: 0px !important;
            background: transparent !important;
        }
        
        *::-webkit-scrollbar-track {
            display: none !important;
        }
        
        *::-webkit-scrollbar-thumb {
            display: none !important;
        }
        
        html, body {
            height: auto !important;
            overflow: hidden !important;
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 12pt !important;
            line-height: 1.4 !important;
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
            scrollbar-gutter: stable !important;
        }
        
        /* Ocultar TODOS os elementos exceto o conteúdo principal */
        body > * {
            display: none !important;
            visibility: hidden !important;
        }
        
        body > main.print-registration {
            display: block !important;
            visibility: visible !important;
        }
        
        /* Ocultar headers com máxima especificidade */
        html body header,
        html body .header,
        html body [role="banner"],
        html body .site-header,
        html body .page-header,
        html body .main-header,
        html body .top-header,
        html body #header,
        html body .masthead,
        html body nav,
        html body .nav,
        html body .navbar,
        html body .navigation,
        html body .menu,
        html body .toolbar,
        html body .actionbar,
        html body footer,
        html body .footer,
        html body .no-print,
        html body .hide-print,
        html body [data-print="false"],
        html body .breadcrumb,
        html body .pagination,
        html body .sidebar,
        html body .aside,
        html body [class*="header"],
        html body [id*="header"],
        html body [class*="nav"],
        html body [id*="nav"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            position: absolute !important;
            left: -9999px !important;
            top: -9999px !important;
            width: 0 !important;
            height: 0 !important;
        }
        
        /* Garantir que apenas o conteúdo principal apareça */
        .print-registration {
            position: static !important;
            width: 100% !important;
            height: auto !important;
            overflow: visible !important;
            background: white !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            left: auto !important;
            top: auto !important;
            z-index: 9999 !important;
        }
        
        /* Quebras de página otimizadas */
        .section {
            page-break-inside: avoid !important;
            margin-bottom: 20px !important;
        }
        
        .card {
            page-break-inside: avoid !important;
            margin-bottom: 15px !important;
            border: 1px solid #ccc !important;
        }
        
        h1, h2, h3 {
            page-break-after: avoid !important;
            margin-bottom: 10px !important;
            color: black !important;
        }
        
        /* Evitar páginas em branco */
        .section:last-child {
            page-break-after: avoid !important;
        }
        
        .end-of-document-marker {
            display: none !important;
        }
        
        /* Garantir que iframes sejam visíveis */
        .print-registration iframe {
            display: block !important;
            overflow: visible !important;
            height: auto !important;
            min-height: 200px !important;
            width: 100% !important;
            border: 1px solid #ddd !important;
            page-break-inside: avoid !important;
        }
        
        /* Ocultar elementos após body para remover resíduos */
        body:after {
            content: none !important;
            display: none !important;
        }
    }
    /* Estilos de impressão aprimorados para remoção completa de barras de rolagem */
@media print {
    /* Configuração da página */
    @page {
        size: A4;
        margin: 15mm 15mm 10mm 15mm;
    }
    
    /* REMOÇÃO RADICAL DE BARRAS DE ROLAGEM - Múltiplas abordagens */
    
    /* Abordagem 1: Seletores universais */
    *, *::before, *::after {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
        scrollbar-gutter: stable !important;
        overflow-x: visible !important;
        overflow-y: visible !important;
    }
    
    /* Abordagem 2: WebKit scrollbars - Máxima especificidade */
    html *::-webkit-scrollbar,
    body *::-webkit-scrollbar,
    div *::-webkit-scrollbar,
    iframe *::-webkit-scrollbar,
    *::-webkit-scrollbar {
        display: none !important;
        width: 0px !important;
        height: 0px !important;
        background: transparent !important;
        -webkit-appearance: none !important;
    }
    
    html *::-webkit-scrollbar-track,
    body *::-webkit-scrollbar-track,
    div *::-webkit-scrollbar-track,
    iframe *::-webkit-scrollbar-track,
    *::-webkit-scrollbar-track {
        display: none !important;
        background: transparent !important;
        -webkit-appearance: none !important;
    }
    
    html *::-webkit-scrollbar-thumb,
    body *::-webkit-scrollbar-thumb,
    div *::-webkit-scrollbar-thumb,
    iframe *::-webkit-scrollbar-thumb,
    *::-webkit-scrollbar-thumb {
        display: none !important;
        background: transparent !important;
        -webkit-appearance: none !important;
    }
    
    html *::-webkit-scrollbar-corner,
    body *::-webkit-scrollbar-corner,
    div *::-webkit-scrollbar-corner,
    iframe *::-webkit-scrollbar-corner,
    *::-webkit-scrollbar-corner {
        display: none !important;
        background: transparent !important;
    }
    
    /* Abordagem 3: Elementos específicos do HTML */
    html, body {
        height: auto !important;
        width: 100% !important;
        overflow: visible !important;
        overflow-x: visible !important;
        overflow-y: visible !important;
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
        font-size: 12pt !important;
        line-height: 1.4 !important;
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
        scrollbar-gutter: stable !important;
    }
    
    /* Abordagem 4: Containers e elementos de conteúdo */
    .print-registration,
    .print-registration-container,
    .section,
    .card,
    div, section, article, main {
        overflow: visible !important;
        overflow-x: visible !important;
        overflow-y: visible !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    
    /* Abordagem 5: iframes e elementos embed */
    iframe, embed, object, video {
        overflow: visible !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    
    iframe::-webkit-scrollbar,
    embed::-webkit-scrollbar,
    object::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    
    /* Abordagem 6: Elementos que podem conter scrollbars */
    .v1-embed-tool,
    [class*="embed"],
    [id*="embed"],
    .content,
    .wrapper,
    .container {
        overflow: visible !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    
    /* Ocultar TODOS os elementos exceto o conteúdo principal */
    body > *:not(.print-registration):not(.print-registration-container) {
        display: none !important;
        visibility: hidden !important;
    }
    
    body > .print-registration,
    body > .print-registration-container {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Ocultar headers e elementos de navegação */
    html body header,
    html body .header,
    html body [role="banner"],
    html body .site-header,
    html body .page-header,
    html body .main-header,
    html body .top-header,
    html body #header,
    html body .masthead,
    html body nav,
    html body .nav,
    html body .navbar,
    html body .navigation,
    html body .menu,
    html body .toolbar,
    html body .actionbar,
    html body footer,
    html body .footer,
    html body .no-print,
    html body .hide-print,
    html body [data-print="false"],
    html body .breadcrumb,
    html body .pagination,
    html body .sidebar,
    html body .aside,
    html body [class*="header"],
    html body [id*="header"],
    html body [class*="nav"],
    html body [id*="nav"],
    html body .registration-print__button {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        position: absolute !important;
        left: -9999px !important;
        top: -9999px !important;
        width: 0 !important;
        height: 0 !important;
    }
    
    /* Garantir que apenas o conteúdo principal apareça */
    .print-registration,
    .print-registration-container {
        position: static !important;
        width: 100% !important;
        height: auto !important;
        overflow: visible !important;
        background: white !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        left: auto !important;
        top: auto !important;
        z-index: 9999 !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }
    
    /* Quebras de página otimizadas */
    .section {
        page-break-inside: avoid !important;
        margin-bottom: 20px !important;
        overflow: visible !important;
    }
    
    .card {
        page-break-inside: avoid !important;
        margin-bottom: 15px !important;
        border: 1px solid #ccc !important;
        overflow: visible !important;
    }
    
    h1, h2, h3 {
        page-break-after: avoid !important;
        margin-bottom: 10px !important;
        color: black !important;
    }
    
    /* Evitar páginas em branco */
    .section:last-child {
        page-break-after: avoid !important;
    }
    
    .end-of-document-marker {
        display: none !important;
    }
    
    /* Garantir que iframes sejam visíveis e sem scroll */
    .print-registration iframe,
    .print-registration-container iframe {
        display: block !important;
        overflow: visible !important;
        height: auto !important;
        min-height: 200px !important;
        width: 100% !important;
        border: 1px solid #ddd !important;
        page-break-inside: avoid !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    
    /* Remover qualquer estilo após o body */
    body::after,
    body::before {
        content: none !important;
        display: none !important;
    }
    
    /* Força adicional para elementos problemáticos */
    [style*="overflow"],
    [style*="scroll"] {
        overflow: visible !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
}
</style>

<?php exit;