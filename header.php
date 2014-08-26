<?php
/**
 * The template for displaying the header
 *
 * Contains header content and the opening of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <script type="text/javascript" src="//use.typekit.net/twm3wuo.js"></script>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body>


<!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="scroll-nav">
</div>
<div class="header-container">
    <header class="wrapper clearfix">
        <a href="/">
            <!--  Site Logo -->
            <div class="site-logo"></div>
            <!-- End Site Logo -->
        </a>
        <nav class="primary-navigation">
            <?php
                wp_nav_menu( array( 'theme_location' => 'anchored', 'menu_class' => 'nav-menu', 'container' => false, 'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new Anchored_Nav_Menu ) );
            ?>
        </nav>
        <nav class="primary-aside-navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'walker' => new Kerf_Nav_Menu ) ); ?>
        </nav>
    </header>
</div>

<div class="main-container">
