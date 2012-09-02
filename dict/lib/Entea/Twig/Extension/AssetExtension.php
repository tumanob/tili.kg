<?php
/**
 * User: entea
 * Date: 11/19/11
 * Time: 11:12 PM
 */

namespace Entea\Twig\Extension;

class AssetExtension extends  \Twig_Extension {
    private $app;

    function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }


    public function getFunctions()
    {
        return array(
            'asset'    => new \Twig_Function_Method($this, 'asset'),
            'is_logged_in' => new \Twig_Function_Method($this, 'isLoggedIn'),
        );
    }

    public function asset($url) {
        return $this->app['request']->getBaseUrl().$url;
    }

    public function isLoggedIn()
    {
        return get_current_user_id() > 0;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'entea_asset';
    }
}
