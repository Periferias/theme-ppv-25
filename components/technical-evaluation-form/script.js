app.component('technical-evaluation-form', {
    template: $TEMPLATES['technical-evaluation-form'],

    setup() {
        const messages = useMessages();
        const text = Utils.getTexts('technical-evaluation-form');
        return { text, messages };
    },

    props: {
        entity: {
            type: Object,
            required: true
        },

        editable: {
            type: Boolean,
            default: true
        },

        formData: {
            type: Object,
            required: true
        }
    },

    created() {
        this.formData.data = this.evaluationData || this.skeleton();
        this.handleCurrentEvaluationForm();
    },

    mounted() {
        window.addEventListener('responseEvaluation', this.processResponse);
        window.addEventListener('processErrors', this.validateErrors);
    },

    data() {
        return {
            obs: '',
            viability: null,
            isEditable: true,
        };
    },

    computed: {
        enableViability() {
            return $MAPAS.config.technicalEvaluationForm.enableViability;
        },
        sections() {
            return Object.values($MAPAS.config.technicalEvaluationForm.sections || {});
        },
        userId() {
            return $MAPAS.userId;
        },
        evaluationData() {
            return $MAPAS.config.technicalEvaluationForm.currentEvaluation?.evaluationData;
        },
        currentEvaluation() {
            return $MAPAS.config.technicalEvaluationForm.currentEvaluation;
        },

        notesResult() {
            let result = 0;
            for (let section of this.sections) {
                for (let criterion of section.criteria) {
                    const value = this.formData.data[criterion.id];
                    if (value !== null && value !== undefined) {
                        result += parseFloat(value) * (criterion.weight || 1);
                    }
                }
            }
            return parseFloat(result.toFixed(2));
        },

        totalMaxScore() {
            let total = 0;
            for (let section of this.sections) {
                if (section.criteria && Array.isArray(section.criteria)) {
                    total += section.criteria.reduce(
                        (acc, criterion) => acc + ((criterion.max || 0) * (criterion.weight || 1)),
                        0
                    );
                }
            }
            return parseFloat(total.toFixed(2));
        }
    },

    methods: {
        handleInput(sectionIndex, criterionId) {
            let value = this.formData.data[criterionId];
            const criterion = this.sections[sectionIndex].criteria.find(c => c.id === criterionId);
            const max = criterion ? criterion.max : null;

            if (value === null || value === undefined || value === '') {
                this.messages.error(this.text('mandatory-note'));
                return;
            }
        
            if (value > max) {
                this.messages.error(this.text('note-higher-configured'));
                this.formData.data[criterionId] = max;
            } else if (value < 0) {
                this.formData.data[criterionId] = 0;
            }
        },

        subtotal(sectionIndex) {
            let subtotal = 0;
            const section = this.sections[sectionIndex];
            for (let criterion of section.criteria) {
                const value = this.formData.data[criterion.id];
                if (value !== null && value !== undefined) {
                    subtotal += parseFloat(value) * (criterion.weight || 1);
                }
            }
            return parseFloat(subtotal.toFixed(2));
        },

        validateErrors() {
            let isValid = false;
            const global = useGlobalState();

            for (let sectionIndex in this.sections) {
                for (let crit of this.sections[sectionIndex].criteria) {
                    let sectionName = this.sections[sectionIndex].name;
                    let value = this.formData.data[crit.id];
                    
                    if (value === null || value === undefined || value === '') {
                        this.messages.error(`${this.text('on_section')} ${sectionName}, ${this.text('the_field')} ${crit.title} ${this.text('is_required')}`);
                        isValid = true;
                    }
                }
            }
            
            if (!this.formData.data.obs) {
                this.messages.error(this.text('technical-mandatory'));
                isValid = true;
            }

            if (this.enableViability && !this.formData.data.viability) {
                this.messages.error(this.text('technical-checkViability'));
                isValid = true;
            }

            global.validateEvaluationErrors = isValid;
            
            return isValid;
        },

        processResponse(data) {
            if (data.detail.response.status > 0) {
                this.isEditable = false;
            }

            if (data.detail.response.status == 0) {
                this.isEditable = true;
            }
        },

        handleCurrentEvaluationForm() {
            this.isEditable = this.currentEvaluation?.status > 0 ? false : this.editable;
        },
        
        skeleton() {
            return {
                uid: this.userId,
            };
        },

        formatNumber(value) {
            // Converte float para string com no máximo 2 decimais
            if (value === null || value === undefined) return '';
            if (Number.isInteger(value)) return value.toString();
            // Remove zeros finais se existirem (ex: 2.50 -> 2.5)
            return value.toFixed(2).replace(/\.?0+$/, '').replace('.', ',');
        }
    }
});
