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
</main>

<style>
/* Estilos normais da página */
.print-registration {
    position: relative;
    overflow: visible !important;
    width: 100%;
    background: white;
}

.section {
    margin-bottom: 15px;
    page-break-inside: avoid;
}

.card {
    margin-bottom: 12px;
    padding: 12px;
    border: 1px solid #ddd;
    page-break-inside: avoid;
    border-radius: 4px;
}

.registration-header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.registration-meta {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
    margin: 15px 0;
}

.registration-meta > div {
    min-width: 120px;
    text-align: center;
}

/* ESTILOS DE IMPRESSÃO OTIMIZADOS - VERSÃO CORRIGIDA */
@media print {
    /* Configuração da página com margens otimizadas */
    @page {
        size: A4;
        margin: 10mm 8mm 5mm 8mm; /* Margens reduzidas */
        padding: 0;
        orphans: 3; /* Mínimo de linhas no final da página */
        widows: 3;  /* Mínimo de linhas no topo da página */
    }

    /* Reset geral para impressão */
    body, html {
        height: auto !important;
        width: 100% !important;
        overflow: visible !important;
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
        font-family: Arial, sans-serif !important;
        font-size: 9.5pt !important; /* Tamanho de fonte ligeiramente menor */
        line-height: 1.25 !important; /* Line-height mais compacto */
        color: #000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Container principal - crítico */
    .print-registration {
        position: static !important;
        width: 100% !important;
        height: auto !important;
        overflow: visible !important;
        background: white !important;
        display: block !important;
        visibility: visible !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }

    /* Cabeçalho otimizado */
    .registration-header {
        text-align: center !important;
        margin-bottom: 12px !important;
        padding: 8px 0 !important;
        border-bottom: 1px solid #ccc !important;
        page-break-after: avoid !important;
    }

    .registration-header h1 {
        font-size: 14pt !important;
        font-weight: bold !important;
        margin: 0 0 8px 0 !important;
        color: #000 !important;
    }

    /* Meta dados compactos */
    .registration-meta {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)) !important;
        gap: 6px 10px !important;
        margin: 8px 0 !important;
        padding: 6px !important;
        background-color: transparent !important;
        border: 1px solid #ddd !important;
        border-radius: 3px !important;
        font-size: 8.5pt !important;
        page-break-inside: avoid !important;
    }

    .registration-meta > div {
        margin: 0 !important;
        padding: 2px 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .registration-meta strong {
        font-weight: bold !important;
        color: #333 !important;
        display: block;
    }

    /* Texto de data compacto */
    .text-center.text-small {
        font-size: 8pt !important;
        color: #666 !important;
        margin-top: 3px !important;
        font-style: italic !important;
    }

    /* Seções com espaçamento reduzido */
    .section {
        margin-bottom: 8px !important;
        padding: 0 !important;
        page-break-inside: avoid !important;
        overflow: visible !important;
    }

    /* Cards compactos */
    .card {
        margin-bottom: 8px !important;
        padding: 8px !important;
        border: 1px solid #ccc !important;
        border-radius: 3px !important;
        background: white !important;
        page-break-inside: avoid !important;
        overflow: visible !important;
        box-shadow: none !important;
    }

    /* Títulos das seções compactos */
    .card h2, .section h2 {
        font-size: 11pt !important;
        font-weight: bold !important;
        color: #000 !important;
        margin: 0 0 6px 0 !important;
        padding-bottom: 2px !important;
        border-bottom: 1px solid #eee !important;
        page-break-after: avoid !important;
    }

    /* Parágrafos e textos compactos */
    p, li, td, span, div {
        margin: 3px 0 !important;
        padding: 0 !important;
        font-size: 9pt !important;
        line-height: 1.3 !important;
        word-break: break-word !important; /* Permite quebrar palavras longas */
        overflow-wrap: break-word !important;
        hyphens: auto !important;
    }

    /* Componentes específicos */
    .mc-summary-agent,
    .mc-summary-agent-info,
    .mc-summary-spaces,
    .mc-summary-project {
        margin: 4px 0 !important;
        padding: 4px !important;
        border-left: none !important;
        background-color: transparent !important;
        font-size: 9pt !important;
        page-break-inside: avoid !important;
    }

    /* Iframes otimizados - CRÍTICO */
    iframe {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        min-height: 100px !important;
        max-height: none !important;
        border: 1px solid #ddd !important;
        margin: 4px 0 !important;
        page-break-inside: avoid !important;
        overflow: visible !important;
    }

    /* Garantir que a última seção seja visível */
    .section:last-child {
        margin-bottom: 0 !important;
        page-break-after: avoid !important;
    }

    /* Ocultar elementos desnecessários */
    body > *:not(.print-registration) {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        width: 0 !important;
        overflow: hidden !important;
    }

    .registration-print__button,
    .no-print, .hide-print, [data-print="false"],
    header, .header, [role="banner"],
    nav, .nav, .navbar, .navigation,
    footer, .footer, .breadcrumb, .pagination,
    .sidebar, .aside {
        display: none !important;
        visibility: hidden !important;
        position: absolute !important;
        left: -9999px !important;
        top: -9999px !important;
        width: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
    }

    /* Prevenir quebras ruins em textos */
    p, li, div, span, td, th {
        orphans: 3 !important;
        widows: 3 !important;
    }

    /* Garantir que o conteúdo use toda a largura disponível */
    div, section, article {
        max-width: 100% !important;
        min-width: auto !important;
        width: 100% !important;
    }
    
    /* Correção para tabelas */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 4px 0 !important;
        font-size: 9pt !important;
        page-break-inside: auto !important;
    }
    
    th, td {
        padding: 3px 5px !important;
        border: 1px solid #ddd !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
        hyphens: auto !important;
    }
    
    /* Timeline compacta */
    .opportunity-phases-timeline {
        margin: 6px 0 !important;
        padding: 5px !important;
        font-size: 8.5pt !important;
    }
    
    /* Remover espaços em branco extras */
    .empty-field, .field-value:empty {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Forçar exibição de conteúdo cortado */
    v1-embed-tool, [class*="embed"] {
        display: block !important;
        overflow: visible !important;
        height: auto !important;
        page-break-inside: avoid !important;
    }
    
    /* Garantir que a última página não fique em branco */
    .end-of-document-marker {
        height: 1px;
        width: 1px;
        display: block;
        margin: 0;
        padding: 0;
        visibility: hidden;
        page-break-after: avoid !important;
    }
}
</style>

<?php exit; ?>