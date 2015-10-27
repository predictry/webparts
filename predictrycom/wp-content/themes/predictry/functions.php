<?php 

add_theme_support( 'post-thumbnails' );
add_image_size( 'homepage_promo', 130, 92, true );
add_image_size( 'psychic_loop', 180, 110, true );
add_image_size( 'psychic_single', 456, 342, true );
add_image_size( 'psychic_small', 80, 9999 );
add_image_size( 'blog', 848, 410, true );
add_image_size( 'blog_small', 228, 110, true );

register_nav_menus(
array(
'top'=>__('Header Menu'),
'top_homepage'=>__('Header Menu Homepage'),
'footer1'=>__('Footer Menu 1'),
'footer2'=>__('Footer Menu 2')
)
);

function answer($atts, $content='') {
 extract(shortcode_atts(array(), $atts));
     return '<div class="answer">'.do_shortcode($content).'</div>';
}
add_shortcode('answer', 'answer');

if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '<div class="widget">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>'
));

?>