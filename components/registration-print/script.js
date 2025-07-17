/**
 * /src/modules/Opportunities/components/registration-print/script.js
 * Fixed to prevent double modal and handle print properly
 */

app.component('registration-print', {
    template: $TEMPLATES['registration-print'],

    emits: ['namesDefined'],

    props: {
        registration: {
            type: Entity,
            required: true,
        },
    },

    data() {
        return {
            loading: false,
            isPrinting: false, // Prevent double triggers
        }
    },

    methods: {
        print() {
            const self = this;

            // Prevent double execution
            if (self.isPrinting) {
                return;
            }

            self.isPrinting = true;
            self.loading = true;

            const iframe = this.$refs.printIframe;

            // Remove any existing listeners
            if (this.handleIframeLoad) {
                iframe.removeEventListener("load", this.handleIframeLoad);
            }

            // Create new load handler
            this.handleIframeLoad = function () {
                // Only process once
                iframe.removeEventListener("load", self.handleIframeLoad);

                setTimeout(() => {
                    try {
                        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                        if (iframeDoc) {
                            // Inject print fixes
                            const style = iframeDoc.createElement('style');
                            style.textContent = `
                                @media all {
                                    /* Hide scrollbars */
                                    * {
                                        -ms-overflow-style: none !important;
                                        scrollbar-width: none !important;
                                    }
                                    *::-webkit-scrollbar {
                                        display: none !important;
                                    }
                                    
                                    /* Let content flow naturally */
                                    html, body {
                                        overflow: hidden !important;
                                        height: auto !important;
                                        width: 100% !important;
                                    }
                                    
                                    /* Fix iframes */
                                    iframe {
                                        overflow: hidden !important;
                                        border: none !important;
                                    }
                                    
                                    /* Fix v1-embed-tool */
                                    v1-embed-tool {
                                        overflow: hidden !important;
                                        display: block !important;
                                        height: auto !important;
                                    }
                                }
                                
                                @media print {
                                    /* Prevent blank pages at end */
                                    body > *:last-child,
                                    main > *:last-child,
                                    .section:last-child {
                                        page-break-after: avoid !important;
                                        margin-bottom: 0 !important;
                                        padding-bottom: 0 !important;
                                    }
                                    
                                    /* Remove empty elements */
                                    *:empty:not(br):not(hr):not(img):not(input):not(iframe) {
                                        display: none !important;
                                    }
                                }
                            `;
                            // Remove the last section if it's nearly empty
                            setTimeout(() => {
                                const lastSection = iframeDoc.querySelector('.section:last-child');
                                if (lastSection && lastSection.textContent.trim().length < 50) {
                                    lastSection.style.display = 'none';
                                }
                            }, 800);
                            if (iframeDoc.head) {
                                iframeDoc.head.appendChild(style);
                            }

                            // Fix overflow on all elements
                            const allElements = iframeDoc.querySelectorAll('*');
                            allElements.forEach(el => {
                                if (el.style && (el.style.overflow === 'auto' || el.style.overflow === 'scroll')) {
                                    el.style.overflow = 'hidden';
                                }
                            });

                            // Remove empty trailing elements
                            self.removeTrailingEmptyElements(iframeDoc);

                            // Wait a bit more for rendering
                            setTimeout(() => {
                                self.loading = false;

                                // Don't auto-print here to prevent double modal
                                // The browser will handle the print when iframe loads

                                // Reset printing flag after a delay
                                setTimeout(() => {
                                    self.isPrinting = false;
                                }, 2000);
                            }, 500);
                        }
                    } catch (e) {
                        console.warn('Could not modify iframe:', e);
                        self.loading = false;
                        self.isPrinting = false;
                    }
                }, 500);
            };

            // Add listener and set source
            iframe.addEventListener("load", this.handleIframeLoad);

            // Set the iframe source - this will trigger the browser's print dialog
            iframe.src = Utils.createUrl('registration', 'registrationPrint', [this.registration.id]);
        },

        removeTrailingEmptyElements(doc) {
            // Start from the last child of body and work backwards
            let lastChild = doc.body.lastElementChild;

            while (lastChild) {
                // Check if element is effectively empty
                const text = lastChild.textContent.trim();
                const hasContent = lastChild.querySelector('img, iframe, video, audio, canvas, input, select, textarea');

                if (!text && !hasContent) {
                    const previous = lastChild.previousElementSibling;
                    lastChild.remove();
                    lastChild = previous;
                } else {
                    // Stop when we find content
                    break;
                }
            }

            // Also check sections
            const sections = doc.querySelectorAll('.section');
            sections.forEach(section => {
                if (!section.textContent.trim() && !section.querySelector('img, iframe, video')) {
                    section.style.display = 'none';
                }
            });
        }
    },

    mounted() {
        // Set iframe attributes on mount
        if (this.$refs.printIframe) {
            this.$refs.printIframe.setAttribute('scrolling', 'no');
            this.$refs.printIframe.style.overflow = 'hidden';
        }
    },

    beforeUnmount() {
        // Clean up
        if (this.$refs.printIframe && this.handleIframeLoad) {
            this.$refs.printIframe.removeEventListener("load", this.handleIframeLoad);
        }
        this.isPrinting = false;
    }
});
