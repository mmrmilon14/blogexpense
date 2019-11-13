<?php 
/*
* Template Name: Expense
*/
get_header(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Expense</title>
</head>
<body>
  <div class="table-area">
    <table class="table" style="width:1024px;margin:50px auto 0;">
      <thead class="thead-light">
        <tr>
          <th>Expense Name</th>
          <th>Category</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total_cost = 0;
        $args = array(
          'post_type' => 'expense',
          'posts_per_page' => '-1',
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();         
          $num = get_the_excerpt();
          $int = (int)$num;
          $total_cost = $total_cost + $int; ?>

        <tr>
          <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
          <td>
          <?php
            $terms = get_the_terms( $post->ID , 'expense-category' );
            foreach ( $terms as $term ) {
            echo $term->name;
            }
          ?>
          </td>
          <td><?php the_excerpt(); ?></td>
        </tr>

        <?php endwhile; endif; 
        wp_reset_postdata(); ?>

        <tr>
          <td></td>
          <td>Total</td>
          <td><?php echo $total_cost; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>

<?php get_footer(); ?>