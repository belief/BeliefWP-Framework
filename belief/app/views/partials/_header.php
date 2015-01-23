<div class="header-container">
    <header class="wrapper clearfix">
        <a href="/">
            <!--  Site Logo -->
            <div class="site-logo"></div>
            <!-- End Site Logo -->
        </a>
        <nav class="primary-navigation">
            <?php
                $nav_args = array( 
                    'theme_location' => 'primary', 
                    'menu_class' => 'nav-menu', 
                    'container' => false, 
                    'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>', 
                    'walker' => new Belief_Theme_Nav_Menu );
                wp_nav_menu( $nav_args );
            ?>
        </nav>
    </header>
</div>