<?php

namespace PeriferiaViva25;

use MapasCulturais\App;

class Theme extends \MapasCulturais\Themes\BaseV2\Theme {

    static function getThemeFolder()
    {
        return __DIR__;
    }

    function _init()
    {
        parent::_init();

        $app = App::i();

        $app->hook('template(<<*>>.head):end', function () {
            $this->part('google-analytics--script');
        });

        // Manifest do five icon
        $app->hook('GET(site.webmanifest)', function() use ($app) {
            /** @var \MapasCulturais\Controller $this */
            $this->json([
                'icons' => [
                    [ 'src' => $app->view->asset('img/favicon-192x192.png', false), 'type' => 'image/png', 'sizes' => '192x192' ],
                    [ 'src' => $app->view->asset('img/favicon-512x512.png', false), 'type' => 'image/png', 'sizes' => '512x512' ]
                ],
            ]);
        });

        $app->hook('GET(agent.single)', function() use ($app) {
          header('Location: https://interativo-mapadasperiferias.cidades.gov.br/nos-perifericos/meu-cadastro');
          exit;
        });

        $app->hook('before.save:registration', function(Registration $registration) {

            if (isset($registration->appliedPointReward['rules']) && is_array($registration->appliedPointReward['rules'])) {
                foreach ($registration->appliedPointReward['rules'] as &$rule) {
                    if (!isset($rule['percentage'])) {
                        $rule['percentage'] = 0;
                    }
                }
            }
        });
    }
}