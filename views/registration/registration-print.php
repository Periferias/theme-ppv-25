<?php
/**
 * src/modules/Opportunities/views/registration/registration-print.php
 * Fixed to prevent blank pages and cropping
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

<style>
/* Inline critical styles for print */
@media print {
    /* Let content flow naturally */
    * {
        max-height: none !important;
        height: auto !important;
    }
    
    /* Hide scrollbars without restricting height */
    * {
        overflow: hidden !important;
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }
    
    *::-webkit-scrollbar {
        display: none !important;
    }
    
    .print-registration {
        transform: scale(0.90);
        transform-origin: top left;
        width: 111.11%; /* 100/0.90 */
    }
    
    /* Prevent orphaned content */
    .section {
        page-break-inside: avoid !important;
        widows: 3 !important;
        orphans: 3 !important;
    }
    
    /* Critical: prevent blank pages at end */
    body > *:last-child,
    main > *:last-child,
    .print-registration > *:last-child,
    .section:last-child,
    .section:last-child .card.owner,
    v1-embed-tool:last-child {
        page-break-after: avoid !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    
    /* Remove empty elements */
    .section:empty,
    .card.owner:empty,
    div:empty:not(.necessary) {
        display: none !important;
    }
    
    /* v1-embed-tool handling */
    v1-embed-tool {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        overflow: hidden !important;
        page-break-inside: auto !important;
    }
    
    /* Compact spacing */
    .col-12 {
        margin-bottom: 0.5rem !important;
    }
    
    h2, h3 {
        margin-top: 1rem !important;
        margin-bottom: 0.5rem !important;
        page-break-after: avoid !important;
    }
}

/* Hide scrollbars in normal view too */
.print-registration iframe,
v1-embed-tool iframe {
    overflow: hidden !important;
}
</style>

<script>
// Remove trailing empty elements and fix layout
document.addEventListener('DOMContentLoaded', function() {
    // Function to check if element has real content
    function hasContent(element) {
        // Check for text
        if (element.textContent.trim()) return true;
        
        // Check for meaningful child elements
        const meaningfulTags = ['IMG', 'IFRAME', 'VIDEO', 'AUDIO', 'CANVAS', 'INPUT', 'SELECT', 'TEXTAREA'];
        return element.querySelector(meaningfulTags.join(',')) !== null;
    }
    
    // Remove empty trailing elements
    function cleanupEmptyElements() {
        const container = document.querySelector('.print-registration');
        if (!container) return;
        
        // Work backwards from last child
        let lastChild = container.lastElementChild;
        while (lastChild && !hasContent(lastChild)) {
            const prev = lastChild.previousElementSibling;
            lastChild.remove();
            lastChild = prev;
        }
        
        // Clean up empty sections
        document.querySelectorAll('.section').forEach(section => {
            if (!hasContent(section)) {
                section.remove();
            }
        });
    }
    
    // Fix iframes
    function fixIframes() {
        document.querySelectorAll('iframe').forEach(iframe => {
            iframe.setAttribute('scrolling', 'no');
            iframe.style.overflow = 'hidden';
            iframe.style.border = 'none';
        });
    }
    
    // Run cleanup
    cleanupEmptyElements();
    fixIframes();
    
    // Run again after dynamic content loads
    setTimeout(() => {
        cleanupEmptyElements();
        fixIframes();
    }, 2000);
    
    // Before print cleanup
    window.addEventListener('beforeprint', () => {
        cleanupEmptyElements();
        fixIframes();
    });
});
</script>

<main class="print-registration grid-12">
    <mc-summary-agent :entity="entity" classes="col-12 print__side-registration-padding"></mc-summary-agent>
    <registration-info :registration="entity" classes="col-12 print__side-registration-padding"></registration-info>
    
    <?php if($entity->sentTimestamp): ?>
    <div class="col-12 bold"> 
        <?= i::__('Inscrição realizada em') ?> {{entity.sentTimestamp.date('2-digit year')}} <?= i::__('às') ?> {{entity.sentTimestamp.time('long')}} 
    </div>
    <?php endif; ?>
    
    <opportunity-phases-timeline :entity-status="entity.status" class="col-12" center big></opportunity-phases-timeline>
    <mc-summary-agent-info :entity="entity" classes="col-12"></mc-summary-agent-info>
    <h3 class="col-12 print__side-registration-padding"><?= i::__('Dados informados no formulário') ?></h3>
    <mc-summary-spaces style="justify-content: center;" :entity="entity" classes="col-12"></mc-summary-spaces>
    <mc-summary-project :entity="entity" classes="col-12"></mc-summary-project>

    <?php 
    // Check if there are any phases to display
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
    
    <?php if($hasDataCollectionPhases): ?>
    <section class="col-12 section">
        <div class="section__content">
            <div class="card owner">
                <?php 
                $currentEntity = $entity;
                while($currentEntity): 
                    $opportunity = $currentEntity->opportunity;
                    if($opportunity->isDataCollection):
                ?>
                    <?php if($opportunity->isFirstPhase):?>
                        <h2><?= i::__('Inscrição') ?></h2>
                    <?php else: ?>
                        <h2><?= $opportunity->name ?></h2>
                    <?php endif; ?>

                    <v1-embed-tool 
                        route="registrationview" 
                        :id="<?=$currentEntity->id?>"
                        style="overflow: hidden !important; display: block;">
                    </v1-embed-tool>
                <?php 
                    endif;
                    $currentEntity = $currentEntity->nextPhase;
                endwhile; 
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>
<style>
@media print {
    /* Force A4 size and margins */
    @page {
        size: A4;
        margin: 15mm;
    }
    
    /* Hide elements that shouldn't print */
    .no-print,
    button,
    .registration-print__button {
        display: none !important;
    }
    
    /* Ensure content fits */
    body {
        font-size: 11pt !important;
        line-height: 1.4 !important;
    }
    
    /* No page breaks in middle of sections */
    .section,
    .card {
        page-break-inside: avoid;
    }
    
    /* Compact spacing */
    * {
        margin-bottom: 0.5em !important;
    }
    
    h1, h2, h3 {
        margin-top: 1em !important;
        margin-bottom: 0.5em !important;
    }
}
</style>
<!-- Final cleanup script -->
<script>
// Ensure no trailing whitespace causes blank pages
window.addEventListener('load', function() {
    // Remove any trailing <br> or empty text nodes
    const main = document.querySelector('.print-registration');
    if (main) {
        // Remove trailing whitespace text nodes
        let lastChild = main.lastChild;
        while (lastChild && lastChild.nodeType === 3 && !lastChild.textContent.trim()) {
            main.removeChild(lastChild);
            lastChild = main.lastChild;
        }
    }
});
</script>
