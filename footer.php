<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */
?>
        </div> <!-- .main-container-->
    
       <!-- Footer Info -->
        <a id="contact"></a>
        <div class="footer-container">
            <footer class="wrapper">
                <div class="footer-contact">
                    <ul>
                        <?php
                        if ( !isset($options) ) {
                            $options = get_option( 'kerf_theme_inputs_options' );
                        }
                        $address = nl2br($options['kerfaddress']);
                        $email = $options['kerfemail'];
                        $phone = $options['kerfphone'];

                        ?>
                        <li class="contact-title">Kerf Design Inc</li>
                        <li class="contact-address"><a href="#"><?php echo $address; ?></a></li>
                        <li class="contact-email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
                        <li class="contact-phone"><?php echo $phone; ?></li>
                    </ul>
                </div>
                <div class="footer-tagline">
                    &#64;2014 Kerf Design, all rights reserved.
                </div>
            </footer>
        </div>
        <!-- End Footer Info -->

        <!-- Trailing Scripts -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/lib/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
        <!-- End Trailing Scripts -->

        <?php wp_footer(); ?>
    </body>
</html>
