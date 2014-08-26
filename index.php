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
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */

$options = get_option( 'kerf_theme_inputs_options' );

get_header(); ?>
    <!-- Home Page Content -->
    <div class="pre-articles">
        <div class="hero-container">
            <div class="hero hero-preview-filter">
                <a id="play-hero-video-btn" href="javascript:void(0);" class="play-video-btn">
                </a>
                <!-- Video Hero -->
                <video id="hero-video-preview" preload autoplay loop>
                    <source src="<?php echo esc_url( $options['herowebmlink'] ); ?>" type="video/webm">
                    <source src="<?php echo esc_url( $options['heromp4link'] ); ?>" type="video/mp4">
                Your browser does not support the video tag.
                </video>
                <iframe id="hero-video-player" src="//player.vimeo.com/video/100356706?api=1&player_id=hero-video-player&title=0&byline=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <!-- End Video Hero -->
            </div>
        </div>

    </div>
    <main class="main clearfix">
        <a id="process"></a>
        <article>
            <header>
                <!-- After Hero Header -->
                <h1><?php echo $options['processheader'];?></h1>
                <p><?php echo $options['processdescription'];?></p>
                <!-- End After Hero Header -->
            </header>

            <!-- Featured Posts Sections -->
            <?php
            $sticky = get_option('sticky_posts');

            $counter = 0;
            if (!empty($sticky)) {
                $loop = new WP_Query( array( 'post__in' => $sticky, 'category_name' => 'Home') );
                if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post(); global $post;
                    $image = '<img src=' . wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] . '>';
                    $title = '<h2>' . get_the_title() . '</h2>';
                    $readmore = esc_attr( get_post_meta( $post->ID, 'custom_read_more', true ) );
                    $readmore = ($readmore) ? $readmore : "Read More...";

                    $text = $post->post_content;

                    $maxTextSize = 1200;
                    if (strlen($text) > $maxTextSize) {
                        $text = tokenTruncate($text,$maxTextSize);
                        $text = trim($text) . '...';
                    }

                    $post_text = '<p class="post-text">' . $text . '</p><p><a class="big-underline" href="'. get_permalink( $post->ID ) .'">' . $readmore . '</a></p>';

                    $featuredHighlightColor = esc_attr( get_post_meta( $post->ID, 'kerf_featured_highlight_title', true ) );
                    $featured_style = 'style="background-color: ' . $featuredHighlightColor .';"';


                    echo '<section>';

                    /*
                     *  Image for home sticky post
                     */
                    if ($counter % 2 == 0) {
                        echo '<div class="section-first featured-image post-' . ($counter+1) . '" ' . $featured_style . '>' . $image;

                    } else {
                        echo '<div class="section-second featured-image post-' . ($counter+1) . '" ' . $featured_style . '>' . $image;

                    }
                    echo '</div>';

                    /*
                     *  Content for home sticky post
                     */
                    if ($counter % 2 == 0) {
                        echo '<div class="section-second">';
                        echo '<div class="content-container">' . $title . $post_text;

                    } else {
                        echo '<div class="section-first">';
                        echo '<div class="content-container">' . $title . $post_text;

                    }
                    echo '</div></div>';
                    echo '</section>';

                    $counter++;
                endwhile; endif;

            }
            ?>
            <!-- End Featured Post Sections -->

            <!-- Featured Image Slider -->
            <a id="work"></a>
            <section class="footer-featured">
                <div id="slider-viewport" class="slideshow-viewport">
                    <ul class="slideshow-direction-nav">
                        <li><a class="slideshow-prev" href="javascript:void(0);"></a></li>
                        <li><a class="slideshow-next" href="javascript:void(0);"></a></li>
                    </ul>

                    <ul id="image-sliders">
                        <!-- Image Slider Data -->
                        <?php
                            $args = array(
                                'post_type' => 'kerf_sliders',
                                'posts_per_page' => '-1',
                                'orderby' => 'menu_order',
                                'order' => 'ASC'
                            );
                            $loop = new WP_Query( $args );
                            if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post(); global $post;
                                echo '<li class="slideshow-slide" data-src="' . wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] . '"></li>';
                            endwhile; endif;

                        ?>
                        <!-- End Image Slider Data -->
                    </ul>
                </div>
                <div class="slideshow-info">
                    <ul id="info-sliders">
                        <!-- Slideshow Info -->
                        <?php
                            if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post(); global $post;
                                $readmore = esc_attr( get_post_meta( $post->ID, 'custom_read_more', true ) );
                                $text = $post->post_content;
                                $maxTextSize = 80;
                                if (strlen($text) > $maxTextSize) {
                                    $text = tokenTruncate($text,$maxTextSize);
                                    $text = trim($text) . '...';
                                }
                                $text = '"'.$text.'"';
                                $readmore = ($readmore) ? $readmore : "See More Of This Project";

                                echo '<li style="display:none"><h3 class="post-title">' . get_the_title() . '</h3><p class="post-text">' . $text . '</p><p><a class="big-underline" href="'. get_permalink( $post->ID ) .'">'. $readmore .'</a></p></li>';
                            endwhile; endif; wp_reset_query();

                        ?>
                        <!-- End Slideshow Info -->
                    </ul>
                </div>
            </section>
            <!-- End Featured Image Slider -->

            <a id="about"></a>
            <footer>
                <div class="footer-left-about">
                    <!-- Footer About -->
                    <h2>About Kerf</h2>
                    <p><?php echo $options['aboutkerf'];?></p>
                    <!-- End Footer About -->
                </div>
                <div class="footer-right">
                    <div class="staff">
                        <!-- Staff List -->
                        <?php
                            $args = array(
                                'post_type' => 'kerf_staff',
                                'posts_per_page' => '5',
                                'orderby' => 'menu_order',
                                'order' => 'ASC'
                            );
                            $counter = 0;
                            $loop = new WP_Query( $args );
                            if ($loop->have_posts() ): while ( $loop->have_posts() ): $loop->the_post();
                                $caption = esc_attr( get_post_meta( $post->ID, 'staff_info_title', true ) );
                                $portrait_url = esc_attr( get_post_meta( $post->ID, 'staff_portait_image', true ) );
                                $caption = nl2br($caption);
                                global $post;
                                echo '<div class="staff-member staff-' . ($counter+1) . '">';
                                echo '<img src="' . $portrait_url . '">';
                                echo '<div class="staff-info"><span class="staff-title">' . get_the_title() . '</span><span class="staff-caption">' . $caption . '</span></div></div>';
                                $counter++;
                            endwhile; endif;

                        ?>
                        <!-- End Staff List -->
                    </div>
                </div>
                <div class="footer-left-connect">
                    <h3 class="soc-med-header">Follow Us</h3>
                    <div class="social-media-btns">
                        <ul>
                            <!-- Social Media -->
                            <li>
                                <a href="#" class='smedia-fbook-btn'></a>
                            </li>
                            <li>
                                <a href="#" class='smedia-instagram-btn'></a>
                            </li>
                            <li>
                                <a href="#" class='smedia-pinterest-btn'></a>
                            </li>
                            <li>
                                <a href="#" class='smedia-houzz-btn'></a>
                            </li>
                            <!-- End Social Media -->
                        </ul>
                    </div>
                    <h3>Sign Up For Our Email Newsletter</h3>
                    <div class="email-input">
                        <form>
                            <input type="text" placeholder="Email Address">
                            <input type="button" value="Go!">
                        </form>
                    </div>
                </div>
                <div class="footer-bottom wrapper">
                    <!-- Footer Text -->
                    <h1>Ready to work with Us?</h1>
                    <p><?php echo $options['contactkerf'];?></p>
                    <!-- End Footer Text -->
                </div>
                <!-- Footer Contact Button -->
                <a href="javascript:void(0);" class="footer-bottom-btn black-hover big-underline"><span class="big-underline-white">Tell Us About Your Project!</span></a>
                <!-- End Footer Contact Button -->
            </footer>
        </article>
    </main> <!-- main -->
    <!-- End Home Page Content -->

<?php get_footer(); ?>
