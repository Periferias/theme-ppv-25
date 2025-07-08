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

<div>
    <div class="field col-6">
        <label class="field__title">
            <?= i::__('Estado') ?>
        </label>
        <select v-model="selectedState" @change="loadCities($event)">
            <option value="" disabled><?= i::esc_attr_e("Selecione"); ?></option>
            <option v-for="state in states" :key="state.sigla" :value="state.sigla">{{state.nome}}</option>
        </select>
    </div>
    
    <div v-if="selectedState" class="field col-6">
        <label class="field__title">
            <?= i::__('Município') ?>
        </label>
        <select v-model="selectedCity" @change="selectCity($event)">
            <option value="" disabled><?= i::esc_attr_e("Selecione"); ?></option>
            <option v-for="city in cities" :key="city.nome" :value="city.nome">{{city.nome}}</option>
        </select>
    </div>
</div>
