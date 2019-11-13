<?php

function theme_setup() {
  load_theme_textdomain('blog', get_template_directory() . '/languages');
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'search-form' ) );
  add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_setup' );

register_nav_menus( array(
  'primary' => __( 'Primary Menu', 'blognew' ),
) );

function add_theme_scripts() {
 
  wp_enqueue_style( 'Bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
  wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/style.css', array(), '1.1', 'all');

}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

function wpdocs_excerpt_more( $more ) {
  return ' ';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

function wpdocs_custom_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );


function blog_custom_post_type() {  
  
  // Expense - Start
  $expense_slug = 'expense';
  $expenses = esc_html__('Expense', 'blog');

  // Register custom post type - expense
  register_post_type('expense',
    array(
      'labels' => array(
        'name' => $expenses,
        'singular_name' => sprintf(esc_html__('%s Post', 'blog' ), $expenses),
        'all_items' => sprintf(esc_html__('%s', 'blog' ), $expenses),
        'add_new' => esc_html__('Add New', 'blog') ,
        'add_new_item' => sprintf(esc_html__('Add New %s', 'blog' ), $expenses),
        'edit' => esc_html__('Edit', 'blog') ,
        'edit_item' => sprintf(esc_html__('Edit %s', 'blog' ), $expenses),
        'new_item' => sprintf(esc_html__('New %s', 'blog' ), $expenses),
        'view_item' => sprintf(esc_html__('View %s', 'blog' ), $expenses),
        'search_items' => sprintf(esc_html__('Search %s', 'blog' ), $expenses),
        'not_found' => esc_html__('Nothing found in the Database.', 'blog') ,
        'not_found_in_trash' => esc_html__('Nothing found in Trash', 'blog') ,
        'parent_item_colon' => ''
      ) ,
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 20,
      'menu_icon' => 'dashicons-portfolio',
      'rewrite' => array(
        'slug' => $expense_slug,
        'with_front' => false
      ),
      'has_archive' => 'expense-category',
      'capability_type' => 'post',
      'hierarchical' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'excerpt'
      )
    )
  );
  // expense - End 
  
  register_taxonomy('expense-category', 'expense', 
    array(
      'labels' => array(
        'name' => 'Category',
        'add_new_item' => 'Add New Category'
      ),
      'public' => true,
      'hierarchical' => true,
    )
  );
  

}
add_action('init', 'blog_custom_post_type');