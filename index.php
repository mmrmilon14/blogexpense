<?php get_header(); ?>

   <!-- main section -->
   <section class="main">
      <div class="container">
         <div class="col-md-8">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <div class="title">
               <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
               <span>Category:<?php the_category(', '); ?></span>
               <span>Tags:
                  <?php                  
                  $post_tags = get_the_tags();
                  if ( ! empty( $post_tags ) ) :
                  foreach( $post_tags as $post_tag ) : ?>
                  <a href="<?php echo get_tag_link( $post_tag ); ?>"><?php echo $post_tag->name; ?></a>
                  <?php endforeach; endif; ?>
               </span>
               <span>Author:
                  <a href=""><?php the_author(); ?></a>
               </span>
               <span>Date:
                  <?php 
                  $year  = get_the_time( 'Y' ); 
                  $month = get_the_time( 'm' ); 
                  $day   = get_the_time( 'd' ); 
                  ?>
                  <a href="<?php echo esc_url( get_day_link( $year, $month, $day ) ); ?>"><?php echo get_the_date(); ?></a>
               </span>
               <?php the_excerpt(); ?>
               <a class="readmore" href="<?php the_permalink(); ?>">Read More Content....</a>
            </div>

            <?php endwhile; endif; ?>

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
               $query = new WP_Query( $args );
               if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

               <li>
                  <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> 
                  (<?php comments_number('0 comment', '1 comment', '% comments'); ?>)
               </li>

               <?php endwhile; endif; 
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
               $query = new WP_Query( $args );
               if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

               <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>

               <?php endwhile; endif; 
               wp_reset_postdata(); ?>

            </ul>
            <h4>Most used category (category name) post</h4>
            <ul>
               <?php
                  $categories = get_categories(array (
                     'orderby' => 'count',
                     'number' => 3,
                     'order' => 'DESC'
                  ));
                  $category_name = $categories[0]->cat_name;
                  $category_name1 = $categories[1]->cat_name;
                  $category_name2 = $categories[2]->cat_name;

                  $i = 0;
                  $args = array (
                     'category_name' => $category_name,
                     'posts_per_page' => 3,
                  );
                  $get_posts = new WP_Query($args);
                  if ($get_posts->have_posts()) :
                     while ($get_posts->have_posts()) : $get_posts->the_post();

                     if($i>=3) break; ?> 
                     <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>

                  <?php $i++; endwhile; endif; 
                  wp_reset_postdata();
                  
                  // Second Loop

                  $args = array (
                     'category_name' => $category_name1,
                     'posts_per_page' => 3,
                  );
                  $get_posts = new WP_Query($args);
                  if ($get_posts->have_posts()) :
                     while ($get_posts->have_posts()) : $get_posts->the_post();
                     if($i>=3) break; ?> 

                     <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>

                  <?php $i++; endwhile; endif; 
                  wp_reset_postdata();

                  //Third Loop

                  $category_name2 = $categories[0]->cat_name;

                  $args = array (
                     'category_name' => $category_name2,
                     'posts_per_page' => 3,
                  );
                  $get_posts = new WP_Query($args);
                  if ($get_posts->have_posts()) :
                     while ($get_posts->have_posts()) : $get_posts->the_post();
                     if($i>=3) break; ?> 

                     <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>

                  <?php $i++; endwhile; endif; 
                  wp_reset_postdata();
               
               ?>

            </ul>
            <h4>Most used category</h4>
            <ul class="used-category">

            <?php
            
            $args = array (
               'orderby' => 'count',
               'number' => 3,
               'order' => 'DESC'
            );
            $categories = get_categories($args);

            foreach($categories as $category) : ?>
               <li><a href="<?php echo get_category_link($category->cat_ID) ?>"><?php echo $category->name; ?></a></li>
            <?php endforeach; ?>
            
            <!-- // $post_categories = wp_get_post_categories( get_the_ID() );
            // $args = array(
            //    'category__in'          => $post_categories, 
            //    'showposts'             => -1,
            //    'number'    => 3,
            // );
            // $get_posts = new WP_Query($args);
            // if($get_posts->have_posts()) {
            //   $cats = array();
            //   while($get_posts->have_posts()) : $get_posts->the_post();
            //       foreach($post_categories as $c) :
            //          $cat = get_category( $c );
            //          $cats[] = $cat->name;
            //       endforeach;
            //    endwhile; 
            //   $catResults = array_unique($cats);

            //   foreach($catResults as $catResult){
            //     echo '<li><a href="#" class="category">' . $catResult . '</a></li>';
            //   }
            // }
            
           // ?> -->
            </ul>
            <h4>Most used tag</h4>

            <?php

               $args = array (
                  'orderby' => 'count',
                  'number' => 3,
                  'order' => 'DESC'
               );
               $tags = get_tags($args);

               foreach($tags as $tag) : ?>
                  <li><a href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo $tag->name; ?></a></li>
               <?php endforeach; ?>
            
            <!-- // global $post;
            // $cats = wp_get_post_categories( $post->ID );
            // $args = array(
            //    'category__in'          => $cats, 
            //    'showposts'             => -1
            // );
            // $custom_query = new WP_Query($args );
            // if ($custom_query->have_posts()) :
            // while ($custom_query->have_posts()) : $custom_query->the_post();
            //    $posttags = get_the_tags();
            //    if ($posttags) {
            //       foreach($posttags as $tag) {
            //          $all_tags[] = $tag->term_id;
            //       }
            //    }
            // endwhile;
            // endif;

            // $tags_arr = array_unique($all_tags);
            // $tags_str = implode(",", $tags_arr);

            // $args = array(
            // 'smallest'  => 18,
            // 'largest'   => 18,
            // 'unit'      => 'px',
            // 'number'    => 3,
            // 'orderby'   => 'count',
            // 'order'     => 'DESC',
            // 'format'    => 'flat',
            // 'include'   => $tags_str
            // );
            // single_cat_title();
            // wp_tag_cloud($args); -->
            
            
            
            <h4>Less used category </h4>
            <ul>

               <?php

               $args = array (
                  'orderby' => 'count',
                  'number' => 3,
                  'order' => 'ASC'
               );
               $categories = get_categories($args);

               foreach($categories as $category) : ?>
                  <li><a href="<?php echo get_category_link($category->cat_ID) ?>"><?php echo $category->name; ?></a></li>
               <?php endforeach; ?>

            </ul>
            <h4>Less used tags </h4>

            <?php

            $args = array (
               'orderby' => 'count',
               'number' => 3,
               'order' => 'ASC'
            );
            $tags = get_tags($args);

            foreach($tags as $tag) : ?>
               <li><a href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo $tag->name; ?></a></li>
            <?php endforeach; ?>
            
         </div>
      </div>
   </section>
   <!-- category link -->
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="category-link">
               <span>Category:</span>

               <div class="category-list">
                  <?php $categories = get_categories( array(
                     'orderby' => 'name',
                     'parent'  => 0
                  ) );
                  
                  foreach ( $categories as $category ) {
                     printf( '<a href="%1$s">%2$s</a>',
                        esc_url( get_category_link( $category->term_id ) ),
                        esc_html( $category->name )
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
                  <?php $tags = get_tags( array(
                     'orderby' => 'name',
                     'parent'  => 0
                  ) );
                  
                  foreach ( $tags as $tag ) {
                     printf( '<a href="%1$s">%2$s</a>',
                        esc_url( get_tag_link( $tag->term_id ) ),
                        esc_html( $tag->name )
                     );
                  } ?>
               </div>
            </div>
         </div>
      </div>
   </div>

<?php get_footer(); ?>