<?php
class Make_options_page {

    public function init() {

        add_action('admin_init', array($this, 'call_register_settings'));
        add_action('admin_menu', array($this, 'register_pages'));
        add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
    }

    public function register_pages() {
        add_menu_page('Настройка шаблона', 'Настройки сайта', 'manage_options', 'theme_options', 'build_page', get_template_directory_uri() . '/img/admin-page-icon.png', 3);

    }

    public function register_scripts() {
        wp_enqueue_media();
        wp_register_script('admin.js', get_template_directory_uri() . '/js/admin.js', array('jquery'));
        wp_enqueue_script('admin.js');
        wp_enqueue_style('admin.css', get_template_directory_uri() . '/css/admin.css');
    }

    public function build_sections_page() {
        //проверяем, для какой страницы строить секции настроек.
        $page = $_GET['page'];
        if (!isset($page)) {
            return;
        }
        if (preg_match('|/|', $page)) {
            $clean_slug = preg_replace('|/|', '_', $page);
            settings_fields($clean_slug);
        } else {
            settings_fields($page);
        }
        $array_of_classes_for_section = new Get_classes();
        //перебираем массив настроек для админики как название страницы и название секции
        foreach ($array_of_classes_for_section->scan_directory() as $class_section) {

            $class = new $class_section();
           if ((!isset($class->page) && (!method_exists($class, 'b')))){
               continue;
            }
            $classes_page = $class->page;
            //тут сверяем uri страницы и массив настроек 
            if ($classes_page === $page) {
                $class->b();
            }
        }
    }

    private function get_settings() {
        $get_classes = new Get_classes();
        $clean_array_of_settings = array();
        foreach ($get_classes->scan_directory() as $class) {
            $temp_class = new $class();
            if (method_exists($temp_class, 's')) {
                $clean_array_of_settings +=$temp_class->s();
            }
        }
        return $this->clean_page_names($clean_array_of_settings);
    }

    private function clean_page_names($array) {
        foreach ($array as &$value) {
            if (preg_match('|/|', $value)) {
                $value = preg_replace('|/|', '_', $value);
            }
        }
        return $array;
    }

    public function call_register_settings() {
        foreach ($this->get_settings() as $setting => $group_name) {
            register_setting($group_name, $setting);
        }
        return;
    }

    public function update_settings() {
        if (!isset($_REQUEST['settings-updated'])) {
            $_REQUEST['settings-updated'] = false;
        }
        if (false !== $_REQUEST['settings-updated']):
            ?>
            <div id="message" class="updated"><p><strong>Настройки сохранены</strong></p></div>   
            <?php
        endif;
    }

}
