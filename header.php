<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <?php wp_head(); ?>
</head>

<body>
   <!-- Navs -->
   <header>
      <div class="top-header">
         <div class="container">
            <div class="logo col-md-12 text-center">
               <a href="">
                  <p>Logo</p>
               </a>
            </div>
         </div>
      </div>
      <div class="container">
         <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                  data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
               </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <?php
            wp_nav_menu( array(
              'theme_location'    => 'primary',
              'depth' => '1',
              'container'         => '',
              'menu_class'        => 'nav navbar-nav',
            ) );
            ?>

               <!-- <ul class="nav navbar-nav navbar-left">
                  <li><a href="#">Page 2</a></li>
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Menu 1</a></li>
                  <li><a href="#">Menu 2</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">Menu 3</a></li>
                  <li><a href="#">Menu 4</a></li>
                  <li><a href="#">Menu 5</a></li>
                  <li><a href="#">Page 3</a></li>
               </ul> -->
            </div>
         </nav>
      </div>
   </header>