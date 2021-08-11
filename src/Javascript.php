<?php

namespace Sophia;

class Javascript
{
    static $ss = [];
    static function add($n, $h)
    {
        self::$ss[$n] = ['href' => $h, 'ext' => is_array($h) ? url_strip($h[0]) : url_strip($h)];
    }
    static function page($d)
    {
        foreach ($d['script'] as $s)
            $ss[] = self::$ss[$s];
        foreach ($ss as $s)
            if (is_array($s['href']))
                foreach ($s['href'] as $b)
                    $e[] = $s['ext'] ? $b :  uncache($b);
            else
                $e[] = $s['ext'] ? $s['href'] :  uncache($s['href']);
        $e[] = getFile('/assets/sophia/js/' . $d['view'] . '.js');
        $e[] = getFile('/assets/sophia/js/' . $d['view'] . '/' . $d['page'] . '.js');
        echo PHP_EOL;
        foreach ($e as $s)
            if ($s !== false) echo '<script src="' . $s . '"></script>' . PHP_EOL;
    }
}
