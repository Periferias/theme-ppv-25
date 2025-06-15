<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    mc-link
');
?>
<nav v-if="viewport=='desktop'" class="panel-nav" :class="classes">
    <slot name='begin'></slot>
    <!--div class="panel-nav__left">
        <?php $this->applyTemplateHook("panel-nav-left-groups","before" )?>
        <template v-for="group in leftGroups" :key="group.id">
            <?php $this->applyTemplateHook("panel-nav-left-groups","begin" )?>
            <h3 v-if="group.label">{{group.label}}</h3>
            <ul v-if="group.items.length > 0">
                <li v-for="item in group.items" :key="`${group.id}:${item.route}`">
                    <mc-link :route="item.route" :params="item.params" :icon="item.icon" :class="{'active': active(item)}">{{item.label}}</mc-link>
                </li>
            </ul>
            <?php $this->applyTemplateHook("panel-nav-left-groups","end" )?>
        </template>
        <?php $this->applyTemplateHook("panel-nav-left-groups","after" )?>
        
        <?php $this->applyTemplateHook("panel-nav-left-sidebar","before" )?>
        <template v-if="sidebar">
            <?php $this->applyTemplateHook("panel-nav-left-sidebar","begin" )?>
            <div class="panel-nav__line"></div>
            <div class="panel-nav__right panel-nav__right--user">
                <li v-for="item in userGroup.items" :key="`user:${item.route}`">
                    <mc-link :route="item.route" :params="item.params" :icon="item.icon" :class="{'active': active(item)}">{{item.label}}</mc-link>
                </li>
            </div>
            <?php $this->applyTemplateHook("panel-nav-left-sidebar","end" )?>
        </template>
        <?php $this->applyTemplateHook("panel-nav-left-sidebar","after" )?>
    </div>
    <div v-if="!sidebar" class="vertical__line"></div-->
    <div v-if="!sidebar" class="panel-nav__right">
        <template v-for="group in rightGroups" :key="group.id">
            <h3 v-if="group.label">{{group.label}}</h3>
            <ul v-if="group.items.length > 0">
                <li v-for="item in group.items" :key="`${group.id}:${item.route}`">
                    <mc-link :route="item.route" :params="item.params" :icon="item.icon" :class="{'active': active(item)}">{{item.label}}</mc-link>
                </li>
            </ul>
        </template>
        <div class="panel-nav__line"></div>
        <div class="panel-nav__right panel-nav__right--user">
            <li><a target="_blank" href='https://interativo-mapadasperiferias.cidades.gov.br/nos-perifericos/meu-cadastro'>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class=" iconify iconify--fa-solid" width="1.25em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 640 512"><path fill="currentColor" d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32S80 82.1 80 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2M480 256c53 0 96-43 96-96s-43-96-96-96s-96 43-96 96s43 96 96 96m48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4c24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48c0-61.9-50.1-112-112-112"></path></svg>
              <?= i::__('Meu Perfil') ?>
            </a></li>
            <li v-for="item in userGroup.items" :key="`user:${item.route}`">
                <mc-link :route="item.route" :params="item.params" :icon="item.icon" :class="{'active': active(item)}">{{item.label}}</mc-link>
            </li>
        </div>
    </div>
</nav>

<nav v-if="viewport=='mobile'" class="panel-nav" :entity="entity" :class="classes">
    <template v-for="group in groupsColumn" :key="group.id">
        <h3 v-if="group.label">{{group.label}}</h3>
        <ul v-if="group.items.length > 0">
            <li v-for="item in group.items" :key="`${group.id}:${item.route}`">
                <mc-link :route="item.route" :params="item.params" :icon="item.icon" :class="{'active': active(item)}">{{item.label}}</mc-link>
            </li>
        </ul>
    </template>
    <div class="panel-nav">
        <li><a target="_blank" href='https://interativo-mapadasperiferias.cidades.gov.br/nos-perifericos/meu-cadastro'><?= i::__('Meu Perfil') ?></mc-a></li>
        <li><mc-link route='auth/logout' icon="logout"><?= i::__('Sair') ?></mc-link></li>
    </div>
</nav>