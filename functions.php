<?php
function loadScriptSite(){
    /*
     * get_template_directory_uri()
     * Получает URL текущей темы. Учитывает SSL. Не учитывает наличие дочерней темы. Не содержит закрывающий слэш.
     * https://wp-kama.ru/function/get_template_directory_uri
     */
    $version = false;
    wp_register_style(
        'WWWKalipso-font-awesome', //$handle
        get_template_directory_uri().'/css/font-awesome.min.css', // $src
        array(), //$deps,
        $version // $ver
    );
    wp_register_style(
        'WWWKalipso-core', //$handle
        get_template_directory_uri().'/css/core.css', // $src
        array(), //$deps,
        $version // $ver
    );

    $mod = get_theme_mod("wwwkalipso_my_color_settings");
    $color = "red";

    if( "item_2" == $mod ) {

        $color = "blue";

    } elseif ( "item_3" == $mod ){

        $color = "green";

    } elseif ( "item_4" == $mod ){

        $color = "orange";

    }


    wp_register_style(
        'WWWKalipso-skins', //$handle
        get_template_directory_uri().'/css/skins/'.$color.'.css', // $src
        array(), //$deps,
        $version // $ver
    );
    wp_register_style(
        'WWWKalipso-custom', //$handle
        get_template_directory_uri().'/css/custom.css', // $src
        array(), //$deps,
        $version // $ver
    );
    wp_enqueue_style('WWWKalipso-font-awesome');
    wp_enqueue_style('WWWKalipso-core');
    wp_enqueue_style('WWWKalipso-skins');
    wp_enqueue_style('WWWKalipso-custom');
    wp_register_script(
        'WWWKalipso-main', //$handle
        get_template_directory_uri().'/js/main.js', //$src
        array(
            'jquery'
        ), //$deps
        $version, //$ver
        true //$$in_footer
    );

    wp_enqueue_script('WWWKalipso-main');

    wp_register_script(
        'WWWKalipso-google', //$handle
        get_template_directory_uri().'/js/google-script.js', // $src
        array(), //$deps,
        $version // $ver

    );
    wp_enqueue_script('WWWKalipso-google');


    wp_enqueue_script('WWWKalipso-google-place',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyDtJOCNcAEta51HBHPMnLTLe3lxX6QQj1o&libraries=places&callback=initMap',
    '', '', true);
}
add_action( 'wp_enqueue_scripts', 'loadScriptSite');

function registerNavMenu() {
    register_nav_menu( 'primary',  __('Primary Menu', WWWKALIPSO_THEME_TEXTDOMAIN)  );
}
 add_action( 'after_setup_theme', 'registerNavMenu', 100);

define("WWWKALIPSO_THEME_TEXTDOMAIN", 'wwwkalipso-development-theme');

/**
+ * Загрузка Text Domain
+ */
function themeLocalization(){
    load_theme_textdomain(WWWKALIPSO_THEME_TEXTDOMAIN, get_template_directory() . '/languages/');
}
add_action('after_setup_theme', 'themeLocalization');

//post-formats
add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
//post-thumbnails
add_theme_support( 'post-thumbnails' );

add_theme_support( 'custom-header', array(
    'video' => true,
) );

add_theme_support( 'automatic-feed-links' );


add_theme_support('custom-logo');

add_action('admin_menu', 'addAdminMenu');

function addAdminMenu(){

    $mainMenuPage = add_menu_page(
        _x('WWWKalipso theme', 'admin menu page', WWWKALIPSO_THEME_TEXTDOMAIN ),
        _x('WWWKalipso theme', 'admin menu page', WWWKALIPSO_THEME_TEXTDOMAIN ),
         'manage_options',
          WWWKALIPSO_THEME_TEXTDOMAIN,
         'renderMainMenu',
         get_template_directory_uri() .'/images/main-menu.png'
     );
    $subMenuPage = add_submenu_page(
        WWWKALIPSO_THEME_TEXTDOMAIN,
        _x('Sub WWWKalipso theme', 'admin menu page', WWWKALIPSO_THEME_TEXTDOMAIN ),
        _x('Sub WWWKalipso theme', 'admin menu page', WWWKALIPSO_THEME_TEXTDOMAIN),
        'manage_options',
        'wwwkalipso_theme_control_sub_menu',
        'renderSubMenu' );
    $themeMenuPage = add_theme_page(
        __('Sub theme WWWKalipso', WWWKALIPSO_THEME_TEXTDOMAIN),
        __('Sub theme WWWKalipso', WWWKALIPSO_THEME_TEXTDOMAIN),
        'read','wwwkalipso_theme_control_sub_theme_menu',
        'renderThemeMenu');
 }

 function renderMainMenu(){
     _e('WWWKalipso theme page', WWWKALIPSO_THEME_TEXTDOMAIN);
 }

function renderSubMenu(){
    _e('WWWKalipso theme page', WWWKALIPSO_THEME_TEXTDOMAIN);
}
function renderThemeMenu(){
    _e('Sub theme wwwkalipso', WWWKALIPSO_THEME_TEXTDOMAIN);
}

function register_my_widgets(){
    register_sidebar( array(
        'name' => "Правая боковая панель сайта",
        'id' => 'right-sidebar',
        'description' => 'Эти виджеты будут показаны с правой колонке сайта',
        'before_title' => '<h1>',
        'after_title' => '</h1>') );
}
 add_action( 'widgets_init', 'register_my_widgets' );

function true_remove_default_widget() {
    unregister_widget('WP_Widget_Archives'); // Архивы
    unregister_widget('WP_Widget_Calendar'); // Календарь
    unregister_widget('WP_Widget_Categories'); // Рубрики
    unregister_widget('WP_Widget_Meta'); // Мета
    unregister_widget('WP_Widget_Pages'); // Страницы
    unregister_widget('WP_Widget_Recent_Comments'); // Свежие комментарии
    unregister_widget('WP_Widget_Recent_Posts'); // Свежие записи
    unregister_widget('WP_Widget_RSS'); // RSS
    unregister_widget('WP_Widget_Search'); // Поиск
    unregister_widget('WP_Widget_Tag_Cloud'); // Облако меток
    unregister_widget('WP_Widget_Text'); // Текст
    unregister_widget('WP_Nav_Menu_Widget'); // Произвольное меню
}

add_action( 'widgets_init', 'true_remove_default_widget', 20 );

require get_template_directory().'/widgets/WWWKalipsoExampleWidget.php';
add_action('widgets_init', create_function('', 'return register_widget("widgets\WWWKalipsoExampleWidget");'));

require get_template_directory().'/widgets/WWWKalipsoGooglePlaceWidget.php';
add_action('widgets_init', create_function('', 'return register_widget("widgets\WWWKalipsoGooglePlaceWidget");'));

add_action('customize_register','my_customize_register');
function my_customize_register( $wp_customize ) {
        //var_dump('<pre>', $wp_customize ,'</pre>');
        /*$wp_customize->add_panel();
     $wp_customize->get_panel();
     $wp_customize->remove_panel();

     $wp_customize->add_section();
     $wp_customize->get_section();
     $wp_customize->remove_section();

     $wp_customize->add_setting();
     $wp_customize->get_setting();
     $wp_customize->remove_setting();

     $wp_customize->add_control();
     $wp_customize->get_control();
     $wp_customize->remove_control();*/

        // Section
        $wp_customize->add_section('wwwkalipso_my_section', array(
                'title' => __('My section title', WWWKALIPSO_THEME_TEXTDOMAIN),
                'priority' => 30,
                'description' => __('My section description', WWWKALIPSO_THEME_TEXTDOMAIN),
            ));

        // Setting
        $wp_customize->add_setting("wwwkalipso_my_settings", array(
                "default" => "Lorem ipsum dolor",
                "transport" => "postMessage",
            ));

        // Control
        $wp_customize->add_control(new WP_Customize_Control(
                    $wp_customize,
                    "wwwkalipso_my_settings",
         array(
                        "label" => __("Title", WWWKALIPSO_THEME_TEXTDOMAIN),
                        "section" => "wwwkalipso_my_section",
                        "settings" => "wwwkalipso_my_settings",
                        "type" => "textarea",
                    )
            ));

     // Setting
     $wp_customize->add_setting("wwwkalipso_my_test_settings", array(
            "default" => "",
             "transport" => "postMessage",
         ));

     // Control
     $wp_customize->add_control( 'wwwkalipso_my_test_settings', array(
             'label'       => __("Label", WWWKALIPSO_THEME_TEXTDOMAIN),
             'section'     => 'wwwkalipso_my_section',
             'type'        => 'input',
             'description' =>  __("Description", WWWKALIPSO_THEME_TEXTDOMAIN)
            ) );

     // Setting
    /* $wp_customize->add_setting("wwwkalipso_my_img_settings", array(
             "default" => "",
             "transport" => "postMessage",
         ));

     // Control
     /*$wp_customize->add_control(
             new WP_Customize_Image_Control(
                     $wp_customize,
                     'wwwkalipso_my_img_settings',
             array(
                         'label'      => __( 'Upload a logo', WWWKALIPSO_THEME_TEXTDOMAIN),
                         'section'    => 'wwwkalipso_my_section',
                        'settings'   => 'wwwkalipso_my_img_settings',
                         //'context'    => 'your_setting_context'
                     )
             )
     );*/


     // Setting
    /* $wp_customize->add_setting("wwwkalipso_my_upload_settings", array(
             "default" => "",
             "transport" => "postMessage",
         ));*/

     // Control
    /* $wp_customize->add_control(
             new WP_Customize_Upload_Control(
                     $wp_customize,
                     'wwwkalipso_my_upload_settings',
             array(
                         'label'      => __( 'Upload', WWWKALIPSO_THEME_TEXTDOMAIN),
                         'section'    => 'wwwkalipso_my_section',
                         'settings'   => 'wwwkalipso_my_upload_settings'
                         )
             )
     );*/

     // Setting
     $wp_customize->add_setting("wwwkalipso_my_color_settings", array(
             "default" => "item_1",
            // "transport" => "postMessage",
         ));

     // Control
     $wp_customize->add_control(
             //new WP_Customize_Color_Control(
                    // $wp_customize,
                     'wwwkalipso_my_color_settings',
             array(
                        'type' => 'radio',
                         'label'      => __( 'Color', WWWKALIPSO_THEME_TEXTDOMAIN),
                         'section'    => 'wwwkalipso_my_section',
                         //'settings'   => 'wwwkalipso_my_color_settings',
                         'choices' => array(
                             'item_1' => 'red',
                             'item_2' => 'blue',
                             'item_3' => 'green',
                             'item_4' => 'orange',
                            ),
                         )
             //)
     );

 }

add_action( 'customize_preview_init', 'my_customizer_script' );
function my_customizer_script() {
        wp_enqueue_script('my-customizer-script',
                get_template_directory_uri().'/js/my-customizer-script.js', //$src,
         array( 'jquery', 'customize-preview' )
        );
 }