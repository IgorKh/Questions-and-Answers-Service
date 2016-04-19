<?php

class JustDoIt
{

    static function f($Page = '', $section = '')
    {
        $Page = trim($Page);
        $section=trim($section);

        if (empty($Page)) {
            return;
        }

        $get_classes = new Get_classes();

        if (in_array($Page, $get_classes->scan_directory())) {
            $class = new $Page();
            if (method_exists($class, 'f')) {
                $class->f($section);
            }
        }
        return;
    }

}
