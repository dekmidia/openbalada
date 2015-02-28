<?php
/**
 * @package WordPress
 * @subpackage OpenBalaada
 * @since OpenBalada 0.12
 * Template Name: Pagina sem Comentários
 */
?>
<?php get_header();?>    
<section class="row clearfix margin-right-none"> 
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo-page"><?php get_the_title(); ?></h1>
  </div>       
  <div class="col-md-8 column">
    <div class="row">
      <div class="col-md-12 column descricao-pageevento">
        <?php if (have_posts()): while (have_posts()) : the_post();?>
          <h2 class="color-red text-uppercase"><strong><?php the_title();?></strong></h2>
            <?php the_content(); ?>
          <?php endwhile; else:?>
        <?php endif;?> 
        <?php comments_template(); ?>
      </div>
    </div>
  </div>
  <div class="col-md-4 column">
    <div class="row">
      <div class="sidebar">
      </div>
    </div>
  </div>
    
</section>                 
</div><!-- /container -->
<?php get_footer();?>