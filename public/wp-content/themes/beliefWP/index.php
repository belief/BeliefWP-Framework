<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 *
 * @package WordPress
 * @subpackage Belief Theme
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.1
 */

$options = get_option( 'kerf_theme_inputs_options' );

get_header(); ?>
    <main class="main clearfix">
        <header>
        </header>
        <article>
            <header>
            </header>
            <section>
            </section>
            <section>
                OK
            </section>
            <footer>
            </footer>
        </article>
        <footer>
        </footer>
    </main> <!-- main -->

<?php get_footer(); ?>
