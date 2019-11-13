<?php get_header(); ?>
<!-- Catagory -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="catagory text-center">

        <?php 
          if(is_category()){ ?>
            <a href="#0">Category:</a>
            <span><?php the_category(', '); ?></span>
          <?php
          } elseif(is_tag()){ ?>
            <a href="#0">Tag:</a>
            <span><?php the_tags( ' ', ', ', ' ' ); ?></span>
          <?php
          } elseif(is_date()){ ?>
            <a href="#0">Date:</a>
            <span><?php the_date(); ?></span>
          <?php
          } 
        ?>
        
      </div>
    </div>
  </div>
</div>
<!-- Title -->
<div class="container">
  <div class="row">

    <?php
    if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="col-md-6">
      <div class="title">
        <div class="col-md-12">
          <h2><?php the_title(); ?></h2>
        </div>
        <div class="col-md-6">
          <a href="">Author:</a>
          <span><?php the_author(); ?></span>
        </div>
        <div class="col-md-6">
          <span>Date:
            <?php 
            $archive_year  = get_the_time( 'Y' ); 
            $archive_month = get_the_time( 'm' ); 
            $archive_day   = get_the_time( 'd' ); 
            ?>
            <a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); ?>"><?php echo get_the_date(); ?></a>
          </span>
        </div>
        <div class="col-md-12">
          <?php the_excerpt(); ?>
        </div>
        <div class="col-md-12 read-more">
          <a href="<?php the_permalink(); ?>">Read More Content....</a>
        </div>
      </div>
      <div class="list">        
        <a href="#0">Category and Tag:</a>
        <ul>

          <?php

          $categories = get_the_terms( get_the_ID(), 'post-category' );
          foreach ( $categories as $category ) {
            $category_ids[] = $category->term_id;
          }

          $tags = get_the_terms( get_the_ID(), 'post-tags' );
          foreach ( $tags as $tag) {
            $tag_ids[] = $tag->term_id;
          }

          $args = array(
            'post_type' => 'post',
            'posts_per_page' => '3',
            'ignore_sticky_posts' => '1',
            'post__not_in'   => array( get_the_ID() ),
            'tax_query'      => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'post-category',
                'field'    => 'term_id',
                'terms'    => $category_ids,
              ),
              array(
                'taxonomy' => 'post-tags',
                'field'    => 'term_id',
                'terms'    => $tag_ids,
              ),
            ),
          );

          $query = new WP_Query($args);
          $related_all_posts = $query->posts;

          foreach($related_all_posts as $related_post){
            $related_post_tags = get_the_terms( $related_post->ID, 'post-tags' );
              foreach ( $related_post_tags as $related_post_tag ) {
                $related_tag_ids[] = $related_post_tag->term_id;
              }
            $related_posts_commonality[$related_post->ID] = count(array_intersect($related_tag_ids, $tag_ids));
          }

          $related_sorted = new WP_query(array(
            'post__in' => $related_posts_commonality,            
            // 'posts_per_page' => '3',
            'ignore_sticky_posts' => '1',
          ));

          if ($related_sorted->have_posts()) : while ($related_sorted->have_posts()) : $related_sorted->the_post(); ?>

            <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

          <?php endwhile; endif;
          wp_reset_postdata(); ?>

        </ul>

      </div>
    </div>

    <?php endwhile;
    endif; ?>

  </div>

  <!-- category link -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="category-link">
          <span>Category:</span>

          <div class="category-list">
            <?php $categories = get_categories(array(
              'orderby' => 'name',
              'parent'  => 0
            ));

            foreach ($categories as $category) {
              printf(
                '<a href="%1$s">%2$s</a>',
                esc_url(get_category_link($category->term_id)),
                esc_html($category->name)
              );
            } ?>
          </div>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tag">
          <span>Tag:</span>
          <div class="tag-list">
            <?php $tags = get_tags(array(
              'orderby' => 'name',
              'parent'  => 0
            ));

            foreach ($tags as $tag) {
              printf(
                '<a href="%1$s">%2$s</a>',
                esc_url(get_tag_link($tag->term_id)),
                esc_html($tag->name)
              );
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>