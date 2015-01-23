<?php
/**
 * The template for displaying the header
 *
 * Contains header content and the opening of the #main and #page div elements.
 *
 *
 * @package WordPress
 * @subpackage Belief Theme
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.1
 */

$seo_title = ( isset($seo_title)) ? $seo_title : '';
$seo_description = ( isset($seo_description)) ? $seo_description : '';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $seo_title; ?></title>
        <meta name="description" content="<?php echo $seo_description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body>


<!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php include('app/views/partials/_header.php'); ?>

<div class="main-container">
