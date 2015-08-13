<?php
class Belief_Theme_Nav_Menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $li_attributes = '';
            $class_names = $value = '';
            $haschildren = false;

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;

            //Add class and attribute to LI element that contains a submenu UL.
            if (is_object($args) && property_exists($args,'has_children')) {
                $haschildren = true;
                $classes[]      = 'dropdown';
                $li_attributes .= 'data-dropdown="dropdown"';
            }
            $classes[] = 'menu-item-' . $item->ID;
            //If we are on the current page, add the active class to that menu item.
            $classes[] = ($item->current) ? 'active' : '';

            //Make sure you still add all of the WordPress classes.
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names = ' class="' . esc_attr( $class_names ) . '"';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

            //Add attributes to link element.
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ($haschildren) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

            $item_output = (is_object($args)) ? $args->before : '';
            $item_output .= '<a class="big-underline-nav"'. $attributes .'>';
            $item_output .= (is_object($args)) ? $args->link_before : '';
            $item_output .= apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= (is_object($args)) ? $args->link_after : '';
            $item_output .= ($haschildren) ? ' <b class="caret"></b> ' : '';
            $item_output .= '</a>';
            $item_output .= (is_object($args)) ? $args->after : '';

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
}
