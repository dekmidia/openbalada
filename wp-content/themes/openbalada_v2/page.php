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
        <!-- <h2 class="titulo-page"><?php //the_title(); ?></h2> -->
        <div class="col-md-9 column adsense hidden-xs hidden-sm">            
          <script type="text/javascript">
            bb_bid = "1700590";
            bb_lang = "pt-BR";
            bb_name = "custom";
            bb_limit = "9";
            bb_format = "bbo";
          </script>
          <script type="text/javascript" src="http://static.boo-box.com/javascripts/embed.js"></script>    
        </div>
      </div>
  </div>
    
</section>                 
</div><!-- /container -->
<?php get_footer();?>