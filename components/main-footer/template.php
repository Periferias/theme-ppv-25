<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    theme-logo
');
$config = $app->config['social-media'];
?>
<?php $this->applyTemplateHook("main-footer", "before") ?>
<div v-if="globalState.visibleFooter" class="main-footer grid-12">
    <?php $this->applyTemplateHook("main-footer", "begin") ?>
    <div class="main-footer__content col-6">
            <a class="theme-logo" href="/">
                <?php $image_url = $app->view->asset('img/logos-oficiais.png', false); ?>
                <img src="<?= $image_url ?>" alt="Logos" />
            </a>
    </div>

    <div class="main-footer__contact col-6">
        <p>Contato</p>
        <p><a href="mailto:premio.periferiaviva@cidades.gov.br">premio.periferiaviva@cidades.gov.br</a></p>
    </div>

    <?php $this->applyTemplateHook("main-footer-reg", "before") ?>
    <div class="main-footer__reg">
        <?php $this->applyTemplateHook("main-footer-reg", "begin") ?>
        <div class="main-footer__reg-content">
            <p>
                <?php i::_e("plataforma criada pela comunidade") ?>
                <span class="mapas"> <mc-icon name="map"></mc-icon><?php i::_e("mapas culturais"); ?> </span>
                <?php i::_e("e desenvolvida por "); ?><strong>hacklab<span style="color: red">/</span></strong>
            </p>

            <a class="link" href="https://github.com/mapasculturais">
                <?php i::_e("Conheça o repositório") ?>
                <mc-icon name="github"></mc-icon>
            </a>
        </div>
        <?php $this->applyTemplateHook("main-footer-reg", "end") ?>
    </div>
    <?php $this->applyTemplateHook("main-footer-reg", "after") ?>
    <?php $this->applyTemplateHook("main-footer", "end") ?>
</div>
<?php $this->applyTemplateHook("main-footer", "after") ?>