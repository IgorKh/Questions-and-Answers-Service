<?php


// Load style and script files - BEGIN
function load_files()
{

    wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css');


    wp_enqueue_script('jQuery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array(), '1.11.1', true);
    wp_enqueue_script('appScripts', get_template_directory_uri() . '/js/app.js', array(), '1.0.0', true);


}

add_action('wp_enqueue_scripts', 'load_files');
// Load style and script files - END

// Exclude WP things from <head></head> - BEGIN
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
// Exclude WP things from <head></head> - END


//Customize title - BEGIN
function site_title($title, $sep)
{
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    $title .= get_bloginfo('name', 'display');

    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf('Страница', max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'site_title', 10, 2);
//Customize title - END

//Register navigation - BEGIN
register_nav_menus(array(
    'navigation-top' => 'Главное меню',
));
//Register navigation - END

//Customize theme - BEGIN
function customize_theme($wp_customize)
{
    $wp_customize->add_section(
        'colors_tune',
        array(
            'title' => 'Настройка цвета',
            'priority' => 30,
        ));


    $wp_customize->add_setting(
        'background_color',
        array(
            'default' => '#ffffff',
            'transport' => 'refresh',
        ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'background_color',
        array(
            'label' => 'Фоновый цвет сайта',
            'section' => 'colors_tune',
            'settings' => 'background_color',
        )));


    $wp_customize->add_setting(
        'content_background_color',
        array(
            'default' => '#000000',
            'transport' => 'refresh',
        ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'content_background_color',
        array(
            'label' => 'Цвет фона контента',
            'section' => 'colors_tune',
            'settings' => 'content_background_color',
        )));


    $wp_customize->add_setting(
        'link_background_color',
        array(
            'default' => '#0eb7c4',
            'transport' => 'refresh',
        ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'content_background_color',
        array(
            'label' => 'Цыет ссылок и других элементов',
            'section' => 'colors_tune',
            'settings' => 'link_background_color',
        )));

}

add_action('customize_register', 'customize_theme');
//Customize theme - END

$args = array(
    'width' => 227,
    'height' => 100,
    'default-image' => get_template_directory_uri() . '/img/logo.png',
);
add_theme_support('custom-header', $args);


function customize_css()
{
    ?>
    <style type="text/css">
        html {
            background-color: rgb(<?php ac_hex2rgb(get_theme_mod('background_color')); ?>);
        }

        #sidebar,
        #wrapper-content {
            background-color: rgb(<?php ac_hex2rgb(get_theme_mod('content_background_color')); ?>);
        }

        #content.search-page h3 a {
            color: rgb(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>);
        }

        #content.search-page article {
            border-bottom: 3px solid rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .7);;
        }

        nav.top li.current-menu-item a,
        nav.top button,
        #content.home-page .link-to-all-qa,
        .page-navigation a,
        div.not-found .search button {
            background-color: rgb(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>);
        }

        nav.top a:hover,
        nav.top button:hover,
        #content.home-page .link-to-all-qa:hover,
        .page-navigation a:hover,
        div.not-found .search button:hover {
            background-color: rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .7);
        }

        nav.top .search,
        #content.qa-page .page-numbers.current {
            border: 1px solid rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .8);
        }

        div.not-found .search input {
            border: 2px solid rgb(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>);
            background-color: rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .11);
        }

        #content.qa-page ul .date,
        #content.home-page ul .date {
            background-color: rgb(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>);
        }

        #content.qa-single-page .block .message {
            background-color: rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .16);
        }
        #content.qa-single-page .block .message.agent::before{
            border-right-color: rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .16);
        }
        #content.qa-single-page .block .message.user::after{
            border-top-color: rgba(<?php ac_hex2rgb(get_theme_mod('link_background_color')); ?>, .16);
        }
    </style>
<?php
}

add_action('wp_head', 'customize_css');

function ac_hex2rgb($hex)
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }

    echo $r . ',' . $g . ',' . $b;
}

//Magic for Options page - BEGIN

//Call autoload classes
spl_autoload_register(function ($class_name) {
    if (file_exists(get_template_directory() . '/lib/' . $class_name . '.php')) {
        require_once get_template_directory() . '/lib/' . $class_name . '.php';
    } elseif (file_exists(get_template_directory() . '/lib/option_classes/' . $class_name . '.php')) {
        require_once get_template_directory() . '/lib/option_classes/' . $class_name . '.php';
    }
});

//Build Options page and other cool stuff about it
include_once('lib/options-page.php');

//Magic for Options page - END

function __translate_month($month)
{
    $month_str = array(
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    );
    return $month_str[($month - 1)];
}

function my_postie_post_function($post)
{
    $system_name = 'Система';
    $sysOp_name = 'Системный администратор';

    $content = $post['post_content'];

    $pattern_date = '/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/';

    $tag = array(
        'operator' => '<op>',
        'user' => '<us>',
        'message' => '<mes>'
    );

    $data = array();

    foreach ($tag as $key => $value) {
        $out = array();
        preg_match('/' . $value . '.*' . $value . '/', $content, $out);

        $data[$key] = preg_replace('/' . $value . '/', '', $out[0]);
    }

    //change date of post
    $message_date = array();
    preg_match($pattern_date, $data['message'], $message_date);
    $message_date = $message_date[0];
    $post['post_date'] = $message_date;

    //make array of message content
    $message_unformat = preg_split($pattern_date, $data['message']);
    $message_format = array();

    //for exclude one from message
    $key_of_first_user_message = '';

    //change post title
    foreach ($message_unformat as $key => $value) {
        if (preg_match('/' . $data['user'] . '/', $value)) {
            $post['post_title'] = preg_replace('/' . $data['user'] . ': /', '', $value);
            $key_of_first_user_message = $key;
            break;
        }
    }
    //format message and add html
    foreach ($message_unformat as $key => $value) {
        if ((!empty($value)) && ($key !== $key_of_first_user_message) && (!preg_match('/' . $system_name . '/', $value)) && (!preg_match('/' . $sysOp_name . '/', $value))) {

            $nickname = array();
            //put nickname to array
            preg_match('/.*: /', $value, $nickname);

            //delete ":/" stuff from name
            $nickname = preg_replace('/: /', '', $nickname[0]);

            //detect write user or agent
            $who = preg_match('/' . $data['user'] . '/', $nickname);

            //class name for user or agent
            $class = $who ? 'user' : 'agent';

            //build message to frontend
            if ($class === 'agent') {
                $message_block_header = '<span>Оператор</span><span>' . $nickname . '</span>';
            } else {
                $message_block_header = '';
            }

            $message_block = '<div class="' . $class . ' block">';

            $message_block .= '<div class="' . $class . ' icon">';
            $message_block .= '</div>';

            $message_block .= '<div class="' . $class . ' message">';
            $message_block .= $message_block_header;
            $message_block .= '<p>';
            //delete nickname from message
            $message_block .= preg_replace('/.*: /', '', $value);
            $message_block .= '</p>';
            $message_block .= '</div>';
            $message_block .= '</div>';

            $message_format[] = $message_block;
        }
    }

    $post['post_content'] = '';
    foreach ($message_format as $value) {
        $post['post_content'] .= $value;
    }

    $post['post_name'] = $post['post_title'];

    return $post;
}

add_filter('postie_post_before', 'my_postie_post_function');


function detect_qa_post($post_id)
{
    $cats = wp_get_post_categories($post_id);
    foreach ($cats as $cat) {
        if ($cat == get_option('qa_category')) {
            echo ' qa-single-page ';
        }
    }
}