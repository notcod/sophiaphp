<?php

namespace Sophia;

class Core
{
    static function init($data = [])
    {
        $url = isset($_GET['sophia']) ? explode('/', filter_var(rtrim($_GET['sophia'] ?? [], '/'), FILTER_SANITIZE_URL)) : [];
        foreach ($data['css'] as $css)
            \Sophia\Stylesheet::add($css[0], $css[1]);

        foreach ($data['js'] as $js)
            \Sophia\Javascript::add($js[0], $js[1]);

        $Controller = 'Home';
        $Method = 'index';
        $Folder = 'Controllers';
        if (isset($url[0]) && !empty($url[0])) {
            $Controller = ucwords($url[0]);
            unset($url[0]);
            if ($Controller == 'Response') {
                $Folder = $Controller;
                $Controller = ucwords($url[1]);
                unset($url[1]);
            }
            if (count($url)) {
                $Method = current($url);
                array_shift($url);
            }
        }
        $Controller = '\\Sophia\\' . $Folder . '\\' . $Controller;
        if (!class_exists($Controller))
            return "404";
        $Controller =  new $Controller;
        if (!method_exists($Controller, $Method))
            return "404";
        $params = $url ? array_values($url) : [];
        return call_user_func_array([$Controller, $Method], $params);
    }
}