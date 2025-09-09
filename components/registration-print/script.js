/**
 * /src/modules/Opportunities/components/registration-print/script.js
 */

app.component('registration-print', {
    template: $TEMPLATES['registration-print'],

    props: {
        registration: {
            type: Entity,
            required: true,
        },
    },

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        print() {
            if (this.loading) return;
            
            this.loading = true;
            const iframe = this.$refs.printIframe;
            
            // Criar URL de impressão
            const printUrl = Utils.createUrl('registration', 'registrationPrint', [this.registration.id]);
            
            // Configurar handler de carga
            const loadHandler = () => {
                iframe.removeEventListener("load", loadHandler);
                
                // Pequeno atraso para garantir que o conteúdo esteja renderizado
                setTimeout(() => {
                    try {
                        iframe.contentWindow.print();
                    } catch (e) {
                        console.error('Erro ao imprimir:', e);
                    } finally {
                        this.loading = false;
                    }
                }, 800); // Aumentado para garantir renderização completa
            };
            
            iframe.addEventListener("load", loadHandler);
            iframe.src = printUrl;
        }
    }
});