<?php
/**
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the view/page-plugin.twig template.
 *
 * 
 * @package BeliefWP Framework
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.2
 * 
 */
$context['content'] = ob_get_contents();
ob_end_clean();
$templates = array('default.twig');
Timber::render($templates, $context);