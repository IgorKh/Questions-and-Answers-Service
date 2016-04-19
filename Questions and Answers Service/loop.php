<?php

class Loop_setup
{
    function __construct()
    {

        $this->ci = get_option('qa_category');

        $this->qs = array(
            'cat' => $this->ci,
            'posts_per_page' => '30',
            'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
        );

        $this->q = new WP_Query($this->qs);

        $big = 999999999; // need an unlikely integer

        $this->p = array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $this->q->max_num_pages,
            'prev_text' => '« сюда',
            'next_text' => 'туда »',
        );

    }

    //category id (ci)
    public $ci;

    //query settings(qs)
    public $qs;

    //query (q)
    public $q;

    //pagination (p)
    public $p;
}

$lsc = new Loop_setup();
$counter = 0;

if (is_home() || is_category($lsc->ci)) {

//Loop setup class (lsc)

    if ($lsc->q->have_posts()) {
        if (is_category($lsc->ci)) {
            ?><h1><?php echo get_cat_name($lsc->ci); ?></h1><?php
        }
        ?>
        <ul><?php
        while ($lsc->q->have_posts()) {
            $lsc->q->the_post();
            ?>
            <?php
            if (is_new_day()) {
                ?><h2 class="date"><?php
                $date_unformat = the_date('j|n|Y', '', '', false);
                $date_format = explode('|', $date_unformat);

                echo $date_format[0] . ' ' . __translate_month($date_format[1]) . ' ' . $date_format[2];
                ?></h2><?php
            }
            if ($counter === 0) {
                ?>
                <div id="ad-2">
                    <p class="dummy-ad">Рекламный блок</p>
                </div>
                <?php
                $counter++;
            }
            ?>
            <li><a
                href="<?php echo get_permalink(); ?>"
                title="<?php the_title(); ?>"
                ><span class="time"><?php
                    the_time();
                    ?></span><span class="title"><?php
                    the_title();
                    ?></span></a></li><?php
        }
        ?></ul><?php
    } else {
        ?>
        <h4 class="not-found">Простите, но здесь ничего нет:( </h4>
        <p class="not-found">Но можно что-нибудь поискать :)</p>
        <div class="not-found">
        <?php
        get_search_form();
        ?></div><?php
    }
    if (is_home()) {
        ?>
        <a class="link-to-all-qa" href="<?php echo get_category_link($lsc->ci); ?> ">Посмотреть все вопросы</a>
    <?php
    } elseif (is_category($lsc->ci)) {
        ?>
        <div class="page-navigation">
            <?php echo paginate_links($lsc->p); ?>
        </div>
    <?php

    }
} elseif (is_search()) {
    global $query_string;

    $query_args = explode("&", $query_string);
    $search_query = array();

    foreach ($query_args as $key => $string) {
        $query_split = explode("=", $string);
        $search_query[$query_split[0]] = urldecode($query_split[1]);
    } // foreach

    $search = new WP_Query($search_query);
    $big = 999999;
    $nav_set = array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $search->max_num_pages,
        'prev_text' => '« сюда',
        'next_text' => 'туда »',
    );
    ?>
    <?php
    if ($search->have_posts()) :
        ?>
        <h1 class="page-title">Мы нашли то, что Вы искали:)</h1>
        <h2 class="found">Вы искали: <?php echo get_search_query(); ?></h2>
        <?php
        while ($search->have_posts()) : $search->the_post(); ?>
            <h3 class=""><a href="<?php get_permalink() ?>"><?php the_title(); ?></a></h3>
            <article><?php
                the_content();
                ?></article>

        <?php endwhile;
        ?>
        <div class="page-navigation"><?php echo paginate_links($nav_set); ?></div><?php


    else : ?><h4 class="not-found">Простите, но ничего не найдено:( </h4>
        <p class="not-found">Но можно попробовать еще раз поискать :)</p>
        <div class="not-found"><?php
        get_search_form();
        ?></div><?php endif;

} elseif (is_single() || is_page()) {
    the_post();
    ?>
    <h1 class="page-title"><?php the_title(); ?></h1>

    <article class="page-content"><?php the_content(); ?></article>
<?php
} elseif (is_404()) {
    ?><h4 class="not-found">Простите, но здесь ничего нет:( </h4>
    <p class="not-found">Но можно что-нибудь поискать :)</p>
    <div class="not-found">
    <?php
    get_search_form();
    ?></div><?php
}else{
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h1 class="page-title"><?php the_title ?></h1>
    <article class="page-content"><?php the_content() ?></article>

<?php endwhile; else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif;
}