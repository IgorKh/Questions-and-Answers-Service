<div class="search">
    <span>
        Поиск по сайту:
    </span>

    <form role="search" method="get" class="form" action="<?php echo home_url('/'); ?>">
        <input
            type="search"
            placeholder="Поиск..."
            value="<?php if(get_search_query()){echo get_search_query();} ?>" name="s"
            title="Поиск..."/>
        <button type="submit"><span>Поиск</span></button>
    </form>
</div>