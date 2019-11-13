<?php get_header(); ?>

<!-- main -->
<section class="main">
   <div class="container">
      <div class="col-md-8 title">

         <?php
         if (have_posts()) : while (have_posts()) : the_post(); ?>

               <h2><?php the_title(); ?></h2>
               <span>category: <?php the_category(', '); ?> </span>
               <span>Tags:
                  <?php
                        $post_tags = get_the_tags();
                        if (!empty($post_tags)) :
                           foreach ($post_tags as $post_tag) : ?>
                        <a href="<?php echo get_tag_link($post_tag); ?>"><?php echo $post_tag->name; ?></a>
                  <?php endforeach;
                        endif; ?>
               </span>
               <span>Date:
                  <?php
                        $archive_year  = get_the_time('Y');
                        $archive_month = get_the_time('m');
                        $archive_day   = get_the_time('d');
                        ?>
                  <a href="<?php echo esc_url(get_day_link($archive_year, $archive_month, $archive_day)); ?>"><?php echo get_the_date(); ?></a>
               </span>
               <p><?php the_content(); ?></p>

         <?php endwhile;
         endif; ?>

         <div class="next-previous">
            <span>Previous post:</span><?php previous_post_link(); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>Next post:</span><?php next_post_link(); ?>
         </div>
      </div>
      <div class="col-md-offset-1 col-md-3 section-right">
         <h4>Most commented post</h4>
         <ul>
            <?php
            $args = array(
               'post_type' => 'post',
               'posts_per_page' => '3',
               'ignore_sticky_posts' => '1',
               'orderby' => 'comment_count',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

                  <li>
                     <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                     (<?php comments_number('0 comment', '1 comment', '% comments'); ?>)
                  </li>

            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>
         </ul>
         <h4>Older post</h4>
         <ul>

            <?php
            $args = array(
               'post_type' => 'post',
               'posts_per_page' => '3',
               'ignore_sticky_posts' => '1',
               'order' => 'ASC',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

                  <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>

            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>
         </ul>
         <h4>Most used category (category name) post</h4>
         <ul>
            <a href="">
               <li>Lorem ipsum dolor sit amet.</li>
            </a>
            <a href="">
               <li>Lorem ipsum dolor sit amet consectetur.</li>
            </a>
            <a href="">
               <li>Lorem ipsum dolor sit amet, consectetur adipisicing.</li>
            </a>
         </ul>
         <h4>Most used category</h4>
         <ul class="used-category">

            <?php

            $args = array(
               'orderby' => 'count',
               'number' => 3,
               'order' => 'DESC'
            );
            $categories = get_categories($args);

            foreach ($categories as $category) : ?>
               <li><a href="<?php echo get_category_link($category->cat_ID) ?>"><?php echo $category->name; ?></a></li>
            <?php endforeach; ?>
         </ul>
         <h4>Most used tag</h4>
         <ul>
            <?php

            $args = array(
               'orderby' => 'count',
               'number' => 3,
               'order' => 'DESC'
            );
            $tags = get_tags($args);

            foreach ($tags as $tag) : ?>
               <li><a href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo $tag->name; ?></a></li>
            <?php endforeach; ?>
         </ul>
         <h4>Less used category </h4>
         <ul>
            <?php

            $args = array(
               'orderby' => 'count',
               'number' => 3,
               'order' => 'ASC'
            );
            $categories = get_categories($args);

            foreach ($categories as $category) : ?>
               <li><a href="<?php echo get_category_link($category->cat_ID) ?>"><?php echo $category->name; ?></a></li>
            <?php endforeach; ?>
         </ul>
         <h4>Less used tags </h4>
         <ul>
            <?php

            $args = array(
               'orderby' => 'count',
               'number' => 3,
               'order' => 'ASC'
            );
            $tags = get_tags($args);

            foreach ($tags as $tag) : ?>
               <li><a href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo $tag->name; ?></a></li>
            <?php endforeach; ?>
         </ul>
      </div>
      <div class="col-md-8">
         <div class="col-md-6">
            <h6>Related post</h6>
            <ul>
               <?php

               $related = get_posts(
                  array(
                     'category__in' => wp_get_post_categories($post->ID),
                     'numberposts' => 5,
                     'post__not_in' => array($post->ID)
                  )
               );
               if ($related) foreach ($related as $post) {
                  setup_postdata($post); ?>
                  <li>
                     <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                  </li>
               <?php }
               wp_reset_postdata(); ?>

            </ul>
         </div>
         <div class="col-md-6">
            <h6>You may also like (not related)</h6>
            <ul>
               <?php

               $related = get_posts(
                  array(
                     'category__not_in' => wp_get_post_categories($post->ID),
                     'numberposts' => 5,
                     'post__not_in' => array($post->ID)
                  )
               );
               if ($related) foreach ($related as $post) {
                  setup_postdata($post); ?>
                  <li>
                     <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                  </li>
               <?php }
               wp_reset_postdata(); ?>

            </ul>
         </div>
         <div class="col-md-6">
            <h6>Partially Related post</h6>
            <ul>
               <?php
               $tags = wp_get_post_tags($post->ID);
               if ($tags) {
                  $first_tag = $tags[0]->term_id;
                  $args = array(
                     'tag__in' => array($first_tag),
                     'post__not_in' => array($post->ID),
                     'posts_per_page' => 5,
                     'caller_get_posts' => 1
                  );
                  $my_query = new WP_Query($args);
                  if ($my_query->have_posts()) {
                     while ($my_query->have_posts()) : $my_query->the_post(); ?>

                     <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

                  <?php endwhile; }
                  wp_reset_postdata();
               }
               ?>

            </ul>
         </div>
      </div>
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
</section>

<?php get_footer(); ?>