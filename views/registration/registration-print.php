<?php
/**
 * src/modules/Opportunities/views/registration/registration-print.php
 * Optimized template based on actual PDF output analysis
 */

use MapasCulturais\i;

$this->import('
    mc-summary-agent
    mc-summary-agent-info
    mc-summary-project
    mc-summary-spaces
    registration-info
    v1-embed-tool
    opportunity-phases-timeline
    mc-card
');

$entity = $entity->firstPhase;

$this->enqueueScript('app-v2', 'registration-print', 'js/registration-print.js');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
/* Reset and base styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    font-size: 11pt;
    line-height: 1.4;
    color: #333;
    background: white;
}

/* Compact layout */
.print-registration {
    max-width: 100%;
    padding: 15px;
}

/* Typography - compact spacing */
h1 { 
    font-size: 18pt; 
    font-weight: bold; 
    margin: 12px 0 8px 0;
    page-break-after: avoid;
}

h2 { 
    font-size: 16pt; 
    font-weight: bold; 
    margin: 10px 0 6px 0;
    page-break-after: avoid;
}

h3 { 
    font-size: 14pt; 
    font-weight: bold; 
    margin: 8px 0 5px 0;
    page-break-after: avoid;
}

h4 { 
    font-size: 12pt; 
    font-weight: bold; 
    margin: 6px 0 4px 0;
    page-break-after: avoid;
}

p {
    margin: 0 0 6px 0;
    orphans: 2;
    widows: 2;
}

/* Compact sections */
.section {
    margin-bottom: 12px;
}

.section:last-child {
    margin-bottom: 0;
}

/* Improved cards */
.card {
    padding: 10px;
    margin-bottom: 8px;
    border: 1px solid #ddd;
    border-radius: 3px;
    page-break-inside: avoid;
}

.card:last-child {
    margin-bottom: 0;
}

/* Compact columns */
.col-12 {
    width: 100%;
    margin-bottom: 8px;
}

.col-12:last-child {
    margin-bottom: 0;
}

/* Header info styling */
.registration-header {
    background: #f8f9fa;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}

.registration-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 10pt;
    margin-bottom: 8px;
}

.registration-meta > div {
    flex: 1;
    min-width: 120px;
}

.registration-meta strong {
    display: block;
    color: #495057;
    margin-bottom: 2px;
}

/* Form data styling */
.form-section {
    margin-bottom: 15px;
}

.form-field {
    margin-bottom: 8px;
    padding: 4px 0;
    border-bottom: 1px solid #f0f0f0;
}

.form-field:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.field-label {
    font-weight: bold;
    color: #495057;
    margin-bottom: 2px;
    font-size: 10pt;
}

.field-value {
    margin-left: 10px;
    font-size: 11pt;
}

/* Embed tool styling */
v1-embed-tool {
    display: block;
    width: 100%;
    margin: 8px 0;
    background: #fff;
}

/* Print-specific optimizations */
@media print {
    @page {
        size: A4;
        margin: 18mm 15mm 15mm 15mm;
    }
    
    body {
        font-size: 10pt;
        line-height: 1.3;
        margin: 0;
        padding: 0;
    }
    
    .print-registration {
        padding: 0;
        width: 100%;
    }
    
    /* Hide non-printable elements */
    .no-print,
    button,
    .registration-print__button,
    nav,
    header,
    footer,
    .print-button {
        display: none !important;
    }
    
    /* Compact print spacing */
    .section {
        margin-bottom: 10px;
    }
    
    .section:last-child {
        margin-bottom: 0 !important;
    }
    
    .card {
        padding: 8px;
        margin-bottom: 6px;
        border: 1px solid #999;
        border-radius: 0;
        page-break-inside: avoid;
    }
    
    .card:last-child {
        margin-bottom: 0;
    }
    
    /* Typography adjustments */
    h1 { 
        font-size: 16pt; 
        margin: 8px 0 6px 0;
    }
    
    h2 { 
        font-size: 14pt; 
        margin: 6px 0 4px 0;
    }
    
    h3 { 
        font-size: 12pt; 
        margin: 5px 0 3px 0;
    }
    
    h4 { 
        font-size: 11pt; 
        margin: 4px 0 2px 0;
    }
    
    p {
        margin: 0 0 4px 0;
    }
    
    /* Header styling for print */
    .registration-header {
        background: #f5f5f5 !important;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #999;
        page-break-inside: avoid;
    }
    
    .registration-meta {
        font-size: 9pt;
        gap: 10px;
        margin-bottom: 6px;
    }
    
    /* Form fields for print */
    .form-field {
        margin-bottom: 4px;
        padding: 2px 0;
        border-bottom: 1px solid #ddd;
        page-break-inside: avoid;
    }
    
    .field-label {
        font-size: 9pt;
        margin-bottom: 1px;
    }
    
    .field-value {
        font-size: 10pt;
        margin-left: 8px;
    }
    
    /* Column adjustments */
    .col-12 {
        margin-bottom: 4px;
    }
    
    .col-12:last-child {
        margin-bottom: 0;
    }
    
    /* Embed tools */
    v1-embed-tool {
        margin: 6px 0;
        page-break-inside: auto;
    }
    
    /* Timeline compact */
    opportunity-phases-timeline {
        margin: 6px 0;
    }
    
    /* Remove backgrounds and shadows */
    * {
        background: transparent !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }
    
    /* Specific background exceptions */
    .registration-header {
        background: #f5f5f5 !important;
    }
    
    /* Prevent orphaned content */
    .form-section {
        page-break-inside: avoid;
        margin-bottom: 8px;
    }
    
    /* Last section cleanup */
    .print-registration > *:last-child {
        margin-bottom: 0 !important;
        page-break-after: avoid !important;
    }
}

/* Utility classes */
.bold { font-weight: bold; }
.text-center { text-align: center; }
.text-small { font-size: 9pt; }
.mb-0 { margin-bottom: 0 !important; }
.mt-0 { margin-top: 0 !important; }

/* Clean up empty states */
.form-field:empty,
.field-value:empty {
    display: none;
}

/* Responsive adjustments */
@media screen and (max-width: 768px) {
    .registration-meta {
        flex-direction: column;
        gap: 8px;
    }
}
</style>
</head>
<body>

<main class="print-registration">
    <!-- Enhanced Header Section -->
    <section class="section">
        <div class="registration-header">
            <h1 class="text-center mb-0"><?= i::__('Comprovante de Inscrição') ?></h1>
            
            <div class="registration-meta">
                <div>
                    <strong><?= i::__('Inscrição') ?></strong>
                    {{entity.number}}
                </div>
                <div>
                    <strong><?= i::__('Data') ?></strong>
                    {{entity.sentTimestamp.date('2-digit year')}}
                </div>
                <div>
                    <strong><?= i::__('Categoria') ?></strong>
                    {{entity.category}}
                </div>
                <div>
                    <strong><?= i::__('Status') ?></strong>
                    {{entity.status}}
                </div>
            </div>
            
            <?php if($entity->sentTimestamp): ?>
            <div class="text-center text-small">
                <?= i::__('Inscrição realizada em') ?> {{entity.sentTimestamp.date('2-digit year')}} <?= i::__('às') ?> {{entity.sentTimestamp.time('long')}}
            </div>
            <?php endif; ?>
        </div>
        
        <div class="col-12">
            <opportunity-phases-timeline :entity-status="entity.status" center big></opportunity-phases-timeline>
        </div>
    </section>
    
    <!-- Agent Information -->
    <section class="section">
        <div class="card">
            <h2><?= i::__('Dados do Proponente') ?></h2>
            <mc-summary-agent :entity="entity"></mc-summary-agent>
            <mc-summary-agent-info :entity="entity"></mc-summary-agent-info>
        </div>
    </section>
    
    <!-- Form Data Section -->
    <section class="section">
        <div class="card">
            <h2><?= i::__('Dados Informados no Formulário') ?></h2>
            <div class="form-section">
                <mc-summary-spaces :entity="entity"></mc-summary-spaces>
            </div>
            <div class="form-section">
                <mc-summary-project :entity="entity"></mc-summary-project>
            </div>
        </div>
    </section>

    <?php 
    // Check for data collection phases
    $hasDataCollectionPhases = false;
    $tempEntity = $entity;
    while($tempEntity) {
        if($tempEntity->opportunity->isDataCollection) {
            $hasDataCollectionPhases = true;
            break;
        }
        $tempEntity = $tempEntity->nextPhase;
    }
    ?>
    
    <!-- Registration Forms -->
    <?php if($hasDataCollectionPhases): ?>
        <?php 
        $currentEntity = $entity;
        while($currentEntity): 
            $opportunity = $currentEntity->opportunity;
            if($opportunity->isDataCollection):
        ?>
        <section class="section">
            <div class="card">
                <h2>
                    <?php if($opportunity->isFirstPhase): ?>
                        <?= i::__('Formulário de Inscrição') ?>
                    <?php else: ?>
                        <?= $opportunity->name ?>
                    <?php endif; ?>
                </h2>

                <v1-embed-tool 
                    route="registrationview" 
                    :id="<?=$currentEntity->id?>">
                </v1-embed-tool>
            </div>
        </section>
        <?php 
            endif;
            $currentEntity = $currentEntity->nextPhase;
        endwhile; 
        ?>
    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Enhanced iframe setup
    function setupPrintableIframes() {
        document.querySelectorAll('iframe').forEach(function(iframe) {
            iframe.setAttribute('scrolling', 'no');
            iframe.style.border = 'none';
            iframe.style.overflow = 'hidden';
            iframe.style.width = '100%';
            iframe.style.display = 'block';
        });
    }
    
    // Clean up empty form fields
    function cleanupEmptyFields() {
        document.querySelectorAll('.field-value').forEach(function(field) {
            if (!field.textContent.trim()) {
                const parent = field.closest('.form-field');
                if (parent) {
                    parent.style.display = 'none';
                }
            }
        });
    }
    
    // Optimize for print
    function optimizeForPrint() {
        // Remove empty sections
        document.querySelectorAll('.section').forEach(function(section) {
            const hasVisibleContent = section.textContent.trim() || 
                                     section.querySelector('iframe, img, video, canvas, svg') ||
                                     section.querySelector('v1-embed-tool, mc-summary-agent, mc-summary-project');
            
            if (!hasVisibleContent) {
                section.style.display = 'none';
            }
        });
        
        // Ensure last section has no bottom margin
        const lastSection = document.querySelector('.section:last-child');
        if (lastSection) {
            lastSection.style.marginBottom = '0';
        }
    }
    
    // Initial setup
    setTimeout(function() {
        setupPrintableIframes();
        cleanupEmptyFields();
    }, 1000);
    
    // Before print optimizations
    window.addEventListener('beforeprint', function() {
        optimizeForPrint();
        setupPrintableIframes();
    });
    
    // Vue component handling
    setTimeout(function() {
        setupPrintableIframes();
        
        // Ensure embed tools display properly
        document.querySelectorAll('v1-embed-tool').forEach(function(tool) {
            tool.style.display = 'block';
            tool.style.width = '100%';
        });
        
        cleanupEmptyFields();
    }, 2500);
    
    // Final cleanup after all content loads
    window.addEventListener('load', function() {
        setTimeout(function() {
            optimizeForPrint();
            setupPrintableIframes();
        }, 1000);
    });
});
</script>

</body>
</html>