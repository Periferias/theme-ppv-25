app.component('select-municipio', {
    template: $TEMPLATES['select-municipio'],
    emits: ['change'],

    props: {
        entity: {
            type: Entity,
            required: true
        },

        prop: {
            type: String,
            required: true
        },
    },

    data() {
        // Detecção robusta de Safari (iOS e macOS)
        const ua = navigator.userAgent;
        const isSafari = /^((?!chrome|android).)*safari/i.test(ua);
        return {
            ibge: $MAPAS.ibge,
            states: [], // [{ value: 'GO', nome: 'Goiás' }, ...]
            cities: [], // [{ value: 'Goiânia', nome: 'Goiânia' }, ...]
            selectedState: null,
            selectedCity: null,
            isSafari: isSafari
        }
    },

    methods: {
        loadStates() {
            // Padroniza para objetos
            this.states = Object.values(this.ibge).map(s => ({ value: s.sigla, nome: s.nome }));
        },

        loadCities(option) {
            let stateValue;
            if (this.isSafari && typeof option === 'string') {
                stateValue = option;
            } else if (option && typeof option === 'object' && option.value !== undefined) {
                stateValue = option.value;
            } else {
                stateValue = option;
            }
            
            this.selectedState = stateValue;
            const state = this.ibge[stateValue];
            this.cities = state ? state.municipios.map(c => ({ value: c.nome, nome: c.nome })) : [];
            this.selectedCity = null;
        },

        selectCity(option) {
            let cityValue;
            if (this.isSafari && typeof option === 'string') {
                cityValue = option;
            } else if (option && typeof option === 'object' && option.value !== undefined) {
                cityValue = option.value;
            } else {
                cityValue = option;
            }
            
            this.selectedCity = cityValue;
            // Emite sempre no formato "Cidade, Estado"
            this.$emit('change', `${cityValue}, ${this.selectedState}`);
        },

        loadData() {
            const existingValue = this.entity[this.prop] || '';

            if (existingValue) {
                const [city, state] = existingValue.split(',').map(s => s.trim());
                const stateData = Object.values(this.ibge).find(s => s.sigla === state);

                if (stateData) {
                    // Define selectedState como string (sigla do estado)
                    this.selectedState = state;
                    this.cities = stateData.municipios.map(c => ({ value: c.nome, nome: c.nome }));

                    const cityExists = this.cities.some(c => c.nome === city);

                    if (cityExists) {
                        // Define selectedCity como string (nome da cidade)
                        this.selectedCity = city;
                    }
                }
            }
        }
    },

    mounted() {
        this.loadStates();
        this.loadData();
    }
});
