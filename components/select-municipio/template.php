<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    mc-select
');
?>

<div class="select-municipio">
    <div class="field col-6">
        <label class="field__title">
            <?= i::__('Estado') ?>
        </label>
        <template v-if="!isSafari">
            <mc-select placeholder="<?= i::esc_attr_e("Selecione"); ?>" :value="selectedState" @input="loadCities($event)" show-filter>
                <option v-for="state in states" :key="state.value" :value="state.value">{{state.nome}}</option>
            </mc-select>
        </template>
        <template v-else>
            <select class="form-control" v-model="selectedState" @change="loadCities($event.target.value)">
                <option value="" disabled selected><?= i::__('Selecione') ?></option>
                <option v-for="state in states" :key="state.value" :value="state.value">{{state.nome}}</option>
            </select>
        </template>
    </div>
    
    <div v-if="selectedState" class="field col-6">
        <label class="field__title">
            <?=i::__('Município') ?>
        </label>
        <template v-if="!isSafari">
            <mc-select placeholder="<?= i::esc_attr_e("Selecione"); ?>" :value="selectedCity" @input="selectCity($event)" show-filter>
                <option v-for="city in cities" :key="city.value" :value="city.value">{{city.nome}}</option>
            </mc-select>
        </template>
        <template v-else>
            <select class="form-control" v-model="selectedCity" @change="selectCity($event.target.value)">
                <option value="" disabled selected><?= i::__('Selecione') ?></option>
                <option v-for="city in cities" :key="city.value" :value="city.value">{{city.nome}}</option>
            </select>
        </template>
    </div>
</div>
