<?php
class Get_classes {
    private $classes_catalog = '/lib/option_classes/';
    
    public function scan_directory() {
        $class_names = array();
        $dir = scandir(get_template_directory() . $this->classes_catalog);
        foreach ($dir as $class_name) {
            if ($class_name !== '.' && $class_name !== '..') {
                $class_names[] = str_replace('.php', '', $class_name);
            }
        }
        return $class_names;
    }

}
