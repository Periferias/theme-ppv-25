/**
 * /src/modules/Opportunities/components/registration-print/script.js
 * Simplified version to prevent content cropping while avoiding blank pages
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
            isPrinting: false,
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
                iframe.removeEventListener("load", self.handleIframeLoad);

                setTimeout(() => {
                    try {
                        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                        if (iframeDoc) {
                            // Inject MINIMAL print fixes - no content removal
                            const style = iframeDoc.createElement('style');
                            style.textContent = `
                                @media all {
                                    /* Basic overflow fixes */
                                    * {
                                        -ms-overflow-style: none !important;
                                        scrollbar-width: none !important;
                                    }
                                    *::-webkit-scrollbar {
                                        display: none !important;
                                    }
                                    
                                    html, body {
                                        overflow-x: hidden !important;
                                        width: 100% !important;
                                    }
                                    
                                    iframe {
                                        border: none !important;
                                        overflow: hidden !important;
                                    }
                                }
                                
                                @media print {
                                    /* ONLY target the document end to prevent blank pages */
                                    .print-registration > .section:last-of-type {
                                        margin-bottom: 0 !important;
                                        page-break-after: avoid !important;
                                    }
                                    
                                    /* Ensure proper page setup */
                                    @page {
                                        size: A4;
                                        margin: 20mm;
                                    }
                                    
                                    /* Basic print optimizations */
                                    * {
                                        background: transparent !important;
                                        box-shadow: none !important;
                                    }
                                }
                            `;

                            if (iframeDoc.head) {
                                iframeDoc.head.appendChild(style);
                            }

                            // Basic iframe fixes only
                            self.basicIframeFixes(iframeDoc);

                            // Minimal cleanup after content loads
                            setTimeout(() => {
                                self.loading = false;
                                
                                // Reset printing flag
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
                }, 300);
            };

            // Add listener and set source
            iframe.addEventListener("load", this.handleIframeLoad);
            iframe.src = Utils.createUrl('registration', 'registrationPrint', [this.registration.id]);
        },

        basicIframeFixes(doc) {
            try {
                // Only basic fixes - no content removal
                const iframes = doc.querySelectorAll('iframe');
                iframes.forEach(iframe => {
                    iframe.setAttribute('scrolling', 'no');
                    iframe.style.border = 'none';
                    iframe.style.overflow = 'hidden';
                });

                // Ensure v1-embed-tool displays properly
                const embedTools = doc.querySelectorAll('v1-embed-tool');
                embedTools.forEach(tool => {
                    tool.style.display = 'block';
                });

            } catch (e) {
                console.warn('Error in basicIframeFixes:', e);
            }
        }
    },

    mounted() {
        // Basic iframe setup
        if (this.$refs.printIframe) {
            const iframe = this.$refs.printIframe;
            iframe.setAttribute('scrolling', 'no');
            iframe.style.border = 'none';
            iframe.style.overflow = 'hidden';
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