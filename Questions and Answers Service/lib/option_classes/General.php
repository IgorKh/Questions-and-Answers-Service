<?php

class General
{
//admin page init
    public $page = 'theme_options';

    //settings to register
    public $settings = array(
        'qa_category' => 'qa_category',
    );

//send settings to register
    public function s()
    {
        $output = array();
        foreach ($this->settings as $value) {
            $output[$value] = $this->page;
        }
        return $output;
    }

//build admin page
    public function b()
    {
        ?>
        <h1 class="page-header">
            Общие настройки сайта <span class="tip">(Стоит также ознакомиться и дозаполнить <a
                    href="/wp-admin/options-general.php">эту</a> страницу)</span>
        </h1>
        <div class="section">
            <p class="section-label">
                Главные настройки
            </p>


            <p class="section-sub-label">
                Какая рубрика для вопросов?
            </p>

            <p class="section-mix-label">
                <span>Нужная рубрика: </span>
                <?php
                wp_dropdown_categories(
                    array(
                        'name' => 'qa_category',
                        'echo' => 1,
                        'show_option_none' => 'Выбрать Категорию',
                        'option_none_value' => '0',
                        'selected' => get_option($this->settings['qa_category'])
                    )
                );
                ?>
            </p>
        </div>
    <?php
    }

//build front-end
    public function f($section)
    {
    }

}
