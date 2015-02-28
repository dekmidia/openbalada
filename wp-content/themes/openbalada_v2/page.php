<?php get_header();?>    
<section class="row clearfix"> 
  <div class="col-md-8">
      <div class="col-md-12 column box">
        <?php if (have_posts()): while (have_posts()) : the_post();?>
            <h1 class="titulo-page"><?php the_title(); ?></h1>
            <div class="page-conteudo">                
                <?php the_content(); ?>
            </div>
          <?php endwhile; else:?>
        <?php endif;?> 
      </div>
  </div>
  <div class="col-md-4 column">
      <div class="col-md-12 box">
        <h2 class="titulo-page"><?php the_title(); ?></h2>
      </div>
  </div>
    
</section>                 
</div><!-- /container -->
<?php get_footer();?>