<?php
use MapasCulturais\i;

$this->import('
    mc-summary-agent-info
    mc-summary-project
    mc-summary-spaces
    registration-info
    v1-embed-tool
    mc-card
');

$entity = $entity->firstPhase;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= i::__('Comprovante de Inscrição') ?></title>

    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: auto !important;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            background: white;
        }

        .print-registration {
            padding: 15px;
            max-width: 800px;
            margin: 0 auto;
        }

        .section {
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .card {
            border: 1px solid #ddd;
            padding: 6px;
            margin-bottom: 6px;
            page-break-inside: avoid;
        }

        .registration-phases-section {
            page-break-before: always;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        h2 {
            font-size: 12pt;
            margin: 6px 0 2px 0;
            padding-bottom: 2px;
            border-bottom: 1px solid #ddd;
            page-break-after: avoid;
        }

        h3 {
            font-size: 11pt;
            margin: 5px 0 3px 0;
        }

        .registration-timestamp {
            margin: 5px 0; 
            font-weight: bold;
            font-size: 9.5pt;
        }

        .embed-wrapper {
            width: 100%;
            position: relative;
            overflow: hidden;
            margin-top: 0 !important;
            margin-bottom: 6px;
        }

        v1-embed-tool {
            display: block;
            width: 100%;
            margin: 0 !important;
            padding: 0 !important;
        }

        v1-embed-tool iframe {
            width: 100%;
            border: none;
            display: block;
            min-height: 100px;
            transition: height 0.3s ease;
            margin: 0 !important;
            padding: 0 !important;
        }

        h2 + .embed-wrapper {
            margin-top: 0 !important;
        }

        /* PRINT STYLES */
        @media print {
            @page {
                size: A4;
                margin: 8mm;
            }

            body {
                font-size: 9pt;
                line-height: 1.2;
            }

            .print-registration {
                padding: 0;
                max-width: 100%;
            }

            .section {
                margin-bottom: 6px !important;
            }

            .section:last-child {
                margin-bottom: 0 !important;
                page-break-after: avoid !important;
            }

            .registration-phases-section {
                page-break-before: always !important;
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            .card {
                margin-bottom: 5px !important;
                padding: 5px !important;
                border: 1px solid #ccc !important;
            }

            .card:last-child {
                page-break-after: avoid !important;
                margin-bottom: 0 !important;
            }

            h2 {
                font-size: 10.5pt !important;
                margin: 5px 0 2px 0 !important;
                padding-bottom: 2px !important;
                page-break-after: avoid !important;
            }

            h3 {
                font-size: 9.5pt !important;
                margin: 4px 0 2px 0 !important;
            }
            
            .registration-timestamp {
                margin: 4px 0 !important;
                font-size: 9pt !important;
            }

            .embed-wrapper {
                margin-top: 0 !important;
                margin-bottom: 5px !important;
                padding: 0 !important;
            }

            v1-embed-tool {
                margin: 0 !important;
                padding: 0 !important;
            }

            v1-embed-tool iframe {
                max-height: none !important;
                page-break-inside: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            h2 + .embed-wrapper {
                margin-top: 0 !important;
            }

            table {
                page-break-inside: auto !important;
                break-inside: auto !important;
                margin-top: 0 !important;
            }

            td,
            th {
                word-break: keep-all !important;
                overflow-wrap: normal !important;
                hyphens: manual !important;
                padding: 2px !important;
                font-size: 8.5pt !important; 
            }

            .no-print,
            button {
                display: none !important;
            }

            .registration-meta {
                margin: 4px 0 !important;
                padding: 4px !important;
            }

            .section:first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            .mc-summary-agent-info {
                margin-bottom: 4px !important;
            }
        }
    </style>
</head>

<body>
    <main class="print-registration">
        <!-- Header Section - More Compact -->
        <section class="section">
            <registration-info :registration="entity"></registration-info>

            <?php if ($entity->sentTimestamp): ?>
                <div class="registration-timestamp">
                    <?= i::__('Inscrição realizada em') ?>
                    {{entity.sentTimestamp.date('2-digit year')}}
                    <?= i::__('às') ?>
                    {{entity.sentTimestamp.time('long')}}
                </div>
            <?php endif; ?>

        </section>

        <section class="section">
            <mc-summary-agent-info :entity="entity"></mc-summary-agent-info>
        </section>

        <section class="section">
            <h3><?= i::__('Dados informados no formulário') ?></h3>
            <mc-summary-spaces :entity="entity"></mc-summary-spaces>
            <mc-summary-project :entity="entity"></mc-summary-project>
        </section>

        <?php
        $currentEntity = $entity;
        $hasPhases = false;

        while ($currentEntity) {
            if ($currentEntity->opportunity->isDataCollection) {
                $hasPhases = true;
                break;
            }
            $currentEntity = $currentEntity->nextPhase;
        }

        if ($hasPhases):
            $currentEntity = $entity;
        ?>
            <section class="section registration-phases-section">
                <div class="card">
                    <?php while ($currentEntity && $currentEntity->opportunity->isDataCollection): ?>
                        <h2>
                            <?php if ($currentEntity->opportunity->isFirstPhase): ?>
                                <?= i::__('Inscrição') ?>
                            <?php else: ?>
                                <?= $currentEntity->opportunity->name ?>
                            <?php endif; ?>
                        </h2>

                        <div class="embed-wrapper">
                            <v1-embed-tool
                                route="registrationview"
                                :id="<?= $currentEntity->id ?>">
                            </v1-embed-tool>
                        </div>

                        <?php $currentEntity = $currentEntity->nextPhase; ?>
                    <?php endwhile; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <script>
        // Advanced iframe height adjustment with minimal spacing
        function adjustIframeHeights() {
            const iframes = document.querySelectorAll('v1-embed-tool iframe');

            iframes.forEach((iframe, index) => {
                iframe.onload = function() {
                    try {
                        const iframeDoc = this.contentDocument || this.contentWindow.document;

                        if (iframeDoc) {
                            // Remove ALL padding/margin from iframe body
                            if (iframeDoc.body) {
                                iframeDoc.body.style.margin = '0';
                                iframeDoc.body.style.padding = '0'; // No padding at all
                                iframeDoc.body.style.paddingTop = '0';
                            }

                            // Remove margins from all top-level elements
                            const children = iframeDoc.body.children;
                            for (let i = 0; i < children.length; i++) {
                                if (i === 0) {
                                    children[i].style.marginTop = '0';
                                }
                            }

                            // Find the actual content height
                            let contentHeight = 0;
                            const allElements = iframeDoc.body.getElementsByTagName('*');

                            // Find the bottom-most visible element
                            for (let el of allElements) {
                                if (el.offsetHeight > 0) {
                                    const bottom = el.offsetTop + el.offsetHeight;
                                    if (bottom > contentHeight) {
                                        contentHeight = bottom;
                                    }
                                }
                            }

                            // Minimal buffer
                            contentHeight += 5; // Very small buffer

                            // Set the iframe height to match content
                            this.style.height = contentHeight + 'px';

                            // Remove empty elements at the end
                            const body = iframeDoc.body;
                            const bodyChildren = Array.from(body.children);
                            let foundLastContent = false;

                            for (let i = bodyChildren.length - 1; i >= 0; i--) {
                                const child = bodyChildren[i];
                                const hasText = child.textContent && child.textContent.trim();
                                const hasVisibleContent = child.offsetHeight > 0;

                                if (!foundLastContent && !hasText && !hasVisibleContent) {
                                    child.remove();
                                } else if (hasText || hasVisibleContent) {
                                    foundLastContent = true;
                                }
                            }

                            // Recalculate after cleanup
                            const newHeight = iframeDoc.documentElement.scrollHeight;
                            this.style.height = Math.min(newHeight, contentHeight) + 'px';
                        }
                    } catch (e) {
                        // Cross-origin iframe - set a reasonable default
                        console.log('Cross-origin iframe, using default height');
                        this.style.height = '600px';
                    }
                };

                // Trigger load event if already loaded
                if (iframe.contentDocument && iframe.contentDocument.readyState === 'complete') {
                    iframe.onload();
                }
            });
        }

        // Remove trailing whitespace and empty elements
        function cleanupDocument() {
            const main = document.querySelector('.print-registration');
            if (!main) return;

            // Clean up trailing whitespace nodes
            let node = main.lastChild;
            while (node) {
                if (node.nodeType === 3 && !node.textContent.trim()) {
                    const prev = node.previousSibling;
                    node.remove();
                    node = prev;
                } else if (node.nodeType === 1) {
                    // Element node - check if empty
                    const hasContent = node.textContent.trim() ||
                        node.querySelector('img, iframe, video');
                    if (!hasContent) {
                        const prev = node.previousSibling;
                        node.remove();
                        node = prev;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }

            // Ensure last section doesn't cause page break
            const lastSection = main.querySelector('.section:last-child');
            if (lastSection) {
                lastSection.style.pageBreakAfter = 'avoid';
            }
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                adjustIframeHeights();
                cleanupDocument();
            });
        } else {
            adjustIframeHeights();
            cleanupDocument();
        }

        // Also run before print
        window.addEventListener('beforeprint', function() {
            adjustIframeHeights();
            cleanupDocument();

            // Extra cleanup for print with minimal spacing
            const iframes = document.querySelectorAll('v1-embed-tool iframe');
            iframes.forEach(iframe => {
                try {
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    if (iframeDoc && iframeDoc.body) {
                        // Remove any print-specific issues
                        iframeDoc.body.style.pageBreakAfter = 'avoid';
                        iframeDoc.body.style.margin = '0';
                        iframeDoc.body.style.padding = '0';

                        // Remove margins from first element
                        if (iframeDoc.body.firstElementChild) {
                            iframeDoc.body.firstElementChild.style.marginTop = '0';
                        }

                        // Remove extra whitespace at the end
                        const walker = iframeDoc.createTreeWalker(
                            iframeDoc.body,
                            NodeFilter.SHOW_TEXT,
                            null,
                            false
                        );

                        const textNodes = [];
                        let node;
                        while (node = walker.nextNode()) {
                            textNodes.push(node);
                        }

                        // Remove trailing empty text nodes
                        for (let i = textNodes.length - 1; i >= 0; i--) {
                            if (!textNodes[i].textContent.trim()) {
                                textNodes[i].remove();
                            } else {
                                break;
                            }
                        }
                    }
                } catch (e) {
                    // Cross-origin, can't modify
                }
            });
        });

        // Monitor for dynamic iframe loading
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeName === 'IFRAME' ||
                            (node.querySelector && node.querySelector('iframe'))) {
                            setTimeout(adjustIframeHeights, 100);
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
</body>

</html>