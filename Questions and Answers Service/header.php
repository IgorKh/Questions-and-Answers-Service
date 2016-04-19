<?php
?>
<!DOCTYPE html>
<html>
<head <?php language_attributes(); ?>>
    <meta charset="UTF-8">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body>
<div id="ad-1">
    <p class="dummy-ad">Рекламный блок</p>
</div>
<div id="wrapper">
    <aside id="sidebar">
        <?php
        get_sidebar();
        ?>
    </aside>
    <div id="wrapper-content-area">
        <nav role="navigation" class="top">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'navigation-top',
                    'menu_class' => 'top',
                    'container' => false,
                    'menu_id' => 'top-nav'
                )
            );
            get_search_form();
            ?>
        </nav>
        <div id="wrapper-content">
            <div id="content" class="<?php
            if (is_home()) {
                echo ' ' . 'home-page' . ' ';
            } elseif (is_category(get_option('qa_category'))) {
                echo ' ' . 'qa-page' . ' ';
            } elseif (is_search()) {
                echo ' ' . 'search-page' . ' ';
            } elseif (is_single()) {
                detect_qa_post(get_the_ID());
            }
            ?>">