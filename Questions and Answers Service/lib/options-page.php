<?php
$back_end_build = new Make_options_page();
$back_end_build->init();

function build_page()
{
    global $back_end_build;
    $back_end_build->update_settings();
    ?>
    <div class="wrap kht-admin">
        <form method="post" action="options.php">
            <?php
            $back_end_build->build_sections_page();
            ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Сохранить настройки"/>
        </form>
    </div>
<?php
}
