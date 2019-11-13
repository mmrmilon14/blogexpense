<?php get_header();


if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div style="width:1024px;margin:50px auto 0;">
  <h1><?php the_title(); ?></h1>
  <h2>
    <?php
      $terms = get_the_terms( $post->ID , 'expense-category' );
      foreach ( $terms as $term ) {
      echo $term->name;
      }
    ?>
  </h2>
  <h3><?php echo get_the_date(); ?></h3>
  <?php the_content(); ?>
</div>

<?php endwhile; endif; 
wp_reset_postdata(); ?>

<div style="width:1024px;margin:50px auto 0;">
  <h3><a href="http://localhost/wpcamel/expense/">Back to Expense Page</a></h3> 
</div>

<?php get_footer(); ?>