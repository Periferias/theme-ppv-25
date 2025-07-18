<?php

use MapasCulturais\i;

$this->import('
    evaluation-actions
')
?>

<div class="tecnical-evaluation-form">
    <div class="tecnical-evaluation-form__header">
        <h4 class="semibold"><?php i::_e('Insira as notas nos campos abaixo') ?></h4>
    </div>
    <div class="tecnical-evaluation-form__content" v-for="(section, sectionIndex) in sections" :key="section.name">
        <h3>{{ section.name }}</h3>
        <div class="bold tecnical-evaluation-form__criterion" v-for="criterion in section.criteria" :key="criterion.id">
            <div class="field tecnical-evaluation-form__maxScore grid-12">
                <label> 
                    <strong>{{ criterion.title }}</strong>

                    <!-- Campo editável com nota de 0 até max em incrementos de 0.25 -->
                    <select
                        class="maxScore-input"
                        v-if="isEditable"
                        v-model="formData.data[criterion.id]"
                        @change="handleInput(sectionIndex, criterion.id)"
                    >
                        <option disabled value=""><?= i::__('Selecione uma nota') ?></option>
                        <option
                            v-for="i in Math.floor(criterion.max / 0.25) + 1"
                            :key="i"
                            :value="(i - 1) * 0.25"
                        >
                            {{ formatNumber((i - 1) * 0.25) }}
                        </option>
                    </select>

                    <!-- Campo não editável -->
                    <select
                        class="maxScore-input"
                        v-if="!isEditable"
                        :value="formData.data[criterion.id]"
                        disabled
                    >
                        <option disabled value=""><?= i::__('Selecione uma nota') ?></option>
                        <option
                            v-for="i in Math.floor(criterion.max / 0.25) + 1"
                            :key="i"
                            :value="(i - 1) * 0.25"
                        >
                            {{ formatNumber((i - 1) * 0.25) }}
                        </option>
                    </select>
                </label>
            </div>
            <div class="grid-12">
                <small class="col-8"><?= i::__('Nota máxima') ?>: <strong>{{formatNumber(criterion.max)}}</strong></small>
                <small class="col-4"><?= i::__('Peso') ?>: <strong>{{formatNumber(criterion.weight)}}</strong></small>
            </div>
        </div>
        <div class="tecnical-evaluation-form__content-subTotal">
            <h4 class="bold"><?php i::_e('Subtotal') ?>: {{ formatNumber(subtotal(sectionIndex)) }}</h4>
        </div>
    </div>

    <div class="tecnical-evaluation-form__textarea">
        <h4 class="bold"><?php i::_e('Parecer técnico') ?></h4>
        <p>
            <?php i::_e('O parecer técnico é de preenchimento obrigatório e ficará disponível para ser visualizado pela pessoa proponente na divulgação do resultado.') ?>
        </p>

        <!-- Campo editável com limite e contador -->
        <div v-if="isEditable">
            <textarea
                v-model="formData.data.obs"
                maxlength="600"
                @input="charCount = formData.data.obs.length"
            ></textarea>
            <small class="contchar">{{ charCount }}/600 caracteres</small>
        </div>

        <!-- Campo desabilitado -->
        <div v-if="!isEditable">
            <textarea disabled>{{ formData.data.obs }}</textarea>
            <small class="contchar">{{ formData.data.obs.length }}/600 caracteres</small>
        </div>
    </div>

    <div class="tecnical-evaluation-form__viability-radio-group" v-if="enableViability">
        <h4 class="bold"><?php i::_e('Exequibilidade orçamentária') ?></h4>
        <p><?php i::_e('Esta proposta está adequada ao orçamento apresentado? Os custos orçamentários estão compatíveis com os praticados no mercado?') ?></p>
        <label>
            <span v-if="isEditable">
                <input v-model="formData.data.viability" type="radio" name="confirmation" value='valid' />
                <?php i::_e('Sim') ?>
            </span>
            <span v-if="!isEditable">
                <input type="radio" name="confirmation" value="valid" disabled :checked="formData.data.viability == 'valid'" />
                <?php i::_e('Sim') ?>
            </span>
        </label>
        <label>
            <span v-if="isEditable">
                <input v-model="formData.data.viability" type="radio" name="confirmation" value='invalid' />
                <?php i::_e('Não') ?>
            </span>
            <span v-if="!isEditable">
                <input type="radio" name="confirmation" value="invalid" disabled :checked="formData.data.viability == 'invalid'" />
                <?php i::_e('Não') ?>
            </span>
        </label>
    </div>

    <div class="tecnical-evaluation-form__results">
        <div>
            <h4><?php i::_e('Pontuação total: ') ?><strong>{{ formatNumber(notesResult) }}</strong></h4>
        </div>
        <div>
            <h4><?php i::_e('Pontuação máxima: ') ?><strong>{{ formatNumber(totalMaxScore) }}</strong></h4>
        </div>
    </div>
</div>
