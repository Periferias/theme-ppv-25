<?php

namespace PeriferiaViva25;

use MapasCulturais\App;
use Apps;

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
            $app = App::i();
            $user = $app->user;
            if ($user && $user->is('avaliador')) {
                echo <<<HTML
<script>
  (function(d,t) {
    var BASE_URL="https://chatwoot.mapadasperiferias.com";
    var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=BASE_URL+"/packs/js/sdk.js";
    g.async = true;
    s.parentNode.insertBefore(g,s);
    g.onload=function(){
      window.chatwootSDK.run({
        websiteToken: 'ndHpWpzAyEa6mLToTg7epqkv',
        baseUrl: BASE_URL
      })
    }
  })(document,"script");
</script>
HTML;
            }
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

        //forçando a abrir arquivos no browser em caso de pdf
        $app->hook('GET(file.privateFile).headers', function(&$headers) {
            $hash = bin2hex(random_bytes(16));

            $headers['Content-Disposition'] = 'inline; filename="' . $hash . '"';
        });

        // define o JWT como Auth Provider caso venha um header authorization
        $app->hook('app.register:after', function () {
            /** @var App $this */
            if($token = $this->request->headers->get('authorization')){
                $this->_auth = new Apps\JWTAuthProvider(['token' => $token]);
            }
        });
    }
}
