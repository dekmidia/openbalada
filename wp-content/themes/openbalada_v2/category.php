<?php get_header();?>

<section class="row"> 
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo-page"><small>Eventos em  </small><br><?php "  ".single_cat_title();?></h1>
    <?php
      $categoria = get_query_var('cat'); 
    ?>
  </div>

<?php 
/*Seta o horário de Nova York, que é duas horas atrasado, para que
os eventos fiquem visíveis até duas horas da manhã no site*/
date_default_timezone_set("America/New_York"); 
//Pega a data atual do sistema
$dataSistema = date( 'Y-m-d' ); 
?>
  

<?php /* ------------- EVENTO PRINCIPAL ------------- */?>
  
  <?php
  $args=array(
    'showposts' => -1,
    'cat' => $categoria,
    'meta_key' => 'evento_tipo',
    'meta_value' => 'Principal',
    'meta_query' => array(
      array(
      'key' => 'evento-data',
      'value' => $dataSistema,
      'compare' => '>=',
      'type' => 'DATE'
      )
    ),
    'orderby' => 'evento-data',
    'order' => 'DESC',
    'post__in'  => get_option( 'sticky_posts' ),
    'ignore_sticky_posts' => 1
  );

  query_posts($args);
  if (have_posts()): while (have_posts()) : the_post();  
  
  //Recebe os valores de tipo de evento, data e se o evento é hoje */  
  $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);
  $eventoData = get_post_meta($post->ID,'evento-data',true);
  $eHoje = verificaQuando ($eventoData);
 ?>

  <article class="col-md-6 eventos">
    <a href="<?php the_permalink();?>" title="Clique para Mais Informações">
    <?php 
      if(has_post_thumbnail()) : the_post_thumbnail( 'large', array( 'class' => 'img-responsive center-block' ) ); 
      else : ?> <img src="http://openbalada.com.br/wp-content/themes/openbalada_v2/img/no-image.jpg" class="img-responsive center-block" alt="Imagem Não Disponível"><?php
      endif; 
    ?>
    <div class="detalhes">
      <div class="detalhes-bloco <?php echo $eHoje;?>">
        <div class="row">
          <div class="evento-descricao evento-descricao-principal col-md-9 col-sm-9 col-xs-9">
            <h2><?php the_title();?></h2>
            <?php $variavel = get_post_meta($post->ID,'evento-local',true); ?>
            <?php if (($variavel != "")||($variavel != null)) : ?>
              <?php $str = strip_tags($variavel);?>
              <h3><?php echo $str; ?></h3>
            <?php else : ?>
              <h3><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25); echo '...'; ?></h3>
            <?php endif; ?>            
            <h4><?php $category = get_the_category(); echo $category[1]->cat_name; ?></h4>
          </div>
          <div class="evento-data evento-data-principal col-md-3 col-sm-3 col-xs-3">
          <?php if ($eHoje == "hoje") : ?>
            <p>HJ</p>
          <?php else : ?> 
            <?php $formatado = formataData($eventoData); // recebe as datas formatadas?>
            <p><?php echo $formatado[0]; ?></p>
            <p><small><?php echo $formatado[1]; ?></small></p>
          <?php endif; ?>
          </div><!-- evento-data -->
          <div class="clear"></div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="clearfix"></div>
    </div><!-- /detalhes -->
    </a>
  </article>
<?php endwhile; else:?>
  <article class="col-md-12">
    <?php $event_principal = 0; ?>
  </article>
<?php endif;
// Reset Query
wp_reset_query();?>

<?php /* ------------- EVENTO SECUNDÁRIO ------------- */?>

<?php
   $args=array(
  'showposts' => 4,
  'post_parent' => 'Cidade',
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'evento-data',
      'value' => $dataSistema,
      'compare' => '>=',
      'type' => 'DATE'
      ),
    array(
      'relation' => 'OR',
      array(
        'key' => 'evento_tipo',
          'compare' => 'NOT EXISTS', // works!
          'value' => '' // This is ignored, but is necessary...
          ),
      array(
        'key' => 'evento_tipo',
        'value' => 'Secundario'
        )
      )
    ),
  'orderby' => 'evento-data',
  'order' => 'ASC'
  );

  query_posts($args);
  if (have_posts()): while (have_posts()) : the_post();  

  //Recebe os valores de tipo de evento, data e se o evento é hoje */  
  $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);
  $eventoData = get_post_meta($post->ID,'evento-data',true);
  $publicidade = get_post_meta($post->ID,'post-publicidade',true);
  $eHoje = verificaQuando ($eventoData);
  ?>

  <article class="col-md-3 eventos">
    <?php if ($publicidade == "Sim") : ?>
      <div class="detalhes detalhes-ads"> 
        <div class="row">
          <div class="evento-descricao evento-descricao-secundario col-md-12 col-sm-12 col-xs-12">
            <?php if(has_post_thumbnail()):the_post_thumbnail( 'medium', array( 'class' => 'img-responsive center-block')); ?>
             <?php else : ?>
              <?php the_content();?>
              <?php $adsense = null;
              $adsense = get_post_meta($post->ID,'codigo-adsense',true); 
              echo $adsense;?>
            <?php endif;  ?>            
          </div>
        </div>
      </div><!-- /detalhes -->
    <?php else : ?> 
    <a href="<?php the_permalink();?>" title="Clique para Mais Informações">
    <?php 
      if(has_post_thumbnail()):the_post_thumbnail( 'medium', array( 'class' => 'img-responsive center-block'));
      else : ?><img src="http://openbalada.com.br/wp-content/themes/openbalada_v2/img/no-image.jpg" class="img-responsive center-block" alt="Imagem Não Disponível"><?php 
      endif; 
    ?>
    <div class="detalhes"> 
      <div class="detalhes-bloco <?php echo $eHoje;?>">
        <div class="row">
          <div class="evento-descricao evento-descricao-secundario col-md-9 col-sm-9 col-xs-9">
            <h2><?php the_title();?></h2>
            <?php $variavel = get_post_meta($post->ID,'evento-local',true); ?>
            <?php if (($variavel != "")||($variavel != null)) : ?>
              <?php $str = strip_tags($variavel);?>
              <h3><?php echo $str; ?></h3>
            <?php else : ?>
              <h3><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,10); echo '...'; ?></h3>
            <?php endif; ?>    
            <!-- <h4><?php $category = get_the_category(); echo $category[1]->cat_name; ?></h4> -->
            <?php foreach((get_the_category()) as $cat) {
                if (!($cat->category_parent == 23))
                $city = $cat->cat_name . ' '; };
                $cidade = str_replace("Agenda ", "", $city);
                echo "<h4>" . $cidade . "</h4>"; ?>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="evento-data evento-data-secundario">
              <?php if ($eHoje == "hoje") : ?>
              <p>HJ</p>
            <?php else : ?> 
            <?php $formatado = formataData($eventoData); // recebe as datas formatadas?>
            <p><?php echo $formatado[0]; ?></p>
            <p><small><?php echo $formatado[1]; ?></small></p>
          <?php endif; ?>
        </div>
      </div><!-- /evento-data -->
        </div>
        <div class="clear"></div>
      </div><!-- /detalhes-bloco -->
      <div class="clear"></div>
    </div><!-- /detalhes -->
    </a>
  <?php endif; ?>   
</article> 
<?php endwhile; else:?>
  <?php $event_secundario = 0; ?>
  <?php endif;
  // Reset Query
  wp_reset_query();?>
  <div class="clearfix"></div>            
</section>

<?php /* ------------- EVENTO COMUM ------------- */?>

<section class="row"> 
 <?php
 /* LOOP PARA EVENTO COMUM */
 $args=array(
  'showposts' => -1,
  'post_parent' => 'Cidade',
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'evento-data',
      'value' => $dataSistema,
      'compare' => '>=',
      'type' => 'DATE'
      ),
    array(
      'relation' => 'OR',
      array(
        'key' => 'evento_tipo',
          'compare' => 'NOT EXISTS', // works!
          'value' => '' // This is ignored, but is necessary...
          ),
      array(
        'key' => 'evento_tipo',
        'value' => 'Comum'
        )
      )
    ),
  'orderby' => 'evento-data',
  'order' => 'ASC'
  );

  query_posts($args);
  if (have_posts()): while (have_posts()) : the_post();  

  //Recebe os valores de tipo de evento, data e se o evento é hoje */  
  $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);
  $eventoData = get_post_meta($post->ID,'evento-data',true);
  $publicidade = get_post_meta($post->ID,'post-publicidade',true);
  $eHoje = verificaQuando ($eventoData);
  ?>
  <article class="col-md-3 col-sm-12 col-xs-12 eventos">    
    <?php if ($publicidade == "Sim") : ?>
      <div class="detalhes">
         <div class="evento-descricao evento-descricao-comum col-md-12 col-sm-12 col-xs-12 altura padding-none">
          <?php the_content();?>
          <?php $adsense = null;
          $adsense = get_post_meta($post->ID,'codigo-adsense',true); 
          echo $adsense;?>
         </div>
      </div>
    <?php else : ?> 
      <a href="<?php the_permalink();?>" title="Clique para Mais Informações" >
        <div class="detalhes <?php echo $eHoje;?>">
          <div class="col-md-3 col-sm-3 col-xs-3 altura">           
            <div class="display-table">
              <div class="table-header">
              </div>
              <div class="table-content">
                <div class="evento-data">
                <?php if ($eHoje == "hoje") : ?>
                  <p>HJ</p>
                <?php else : ?> 
                  <?php $formatado = formataData($eventoData); // recebe as datas formatadas?>
                  <p><?php echo $formatado[0]; ?></p>
                  <p><small><?php echo $formatado[1]; ?></small></p>
                <?php endif; ?>
                </div>
              </div>
              <div class="table-footer">            
              </div>
            </div>
          </div>
          <div class="evento-descricao evento-descricao-comum padding-left-right-none col-md-9 col-sm-9 col-xs-9 altura">
            <h2><?php the_title();?></h2>
            <!-- <?php $variavel = get_post_meta($post->ID,'evento-local',true); ?>
              <?php if (($variavel != "")||($variavel != null)) : ?>
                <?php $str = strip_tags($variavel);?>
                <h3><?php echo $str; ?></h3>
              <?php else : ?>
                <h3><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,10); echo '...'; ?></h3>
              <?php endif; ?> -->
              <!-- <h4><?php $category = get_the_category(); echo $category[0]->cat_name; ?></h4> -->
              <h4><?php foreach((get_the_category()) as $cat) {
                if (!($cat->category_parent == 23))
                $city = $cat->cat_name . ' '; };
                $cidade = str_replace("Agenda ", "", $city);
                echo $cidade; ?></h4>
             
          </div>
          <div class="clear"></div>
        <!-- evento-data -->
        </div>
      </a>
    <?php endif; ?>    
  </article>
  <?php endwhile; else:?>
    <?php $event_comum = 0; ?>
  <?php endif; ?>

  <?php // Reset Query

/* ------------- EVENTO EM BRANCO ------------- */

  if (($event_principal === 0) && ($event_secundario === 0) && ($event_comum === 0)): ?>
    <article class="col-md-3 col-sm-12 col-xs-12 eventos">
    <a href="<?php the_permalink();?>" title="Clique para Mais Informações" >
      <div class="detalhes <?php echo $eHoje;?>">
        <div class="col-md-3 col-sm-3 col-xs-3 altura"> 
          <div class="display-table">
            <div class="table-header">
            </div>
            <div class="table-content">
              <div class="evento-data">
                <p>!</p>              
              </div>
            </div>
            <div class="table-footer">            
            </div>
          </div>
        </div>
        <div class="evento-descricao evento-descricao-comum padding-left-right-none col-md-9 col-sm-9 col-xs-9 altura">
          <h3 class="color-red">Sem eventos!</h3>
          <h4>Não foram encontrados eventos cadastrados!</h4>
        </div>
        <div class="clear"></div>
      <!-- evento-data -->
      </div>
    </a>
  </article>
  <?php endif; ?>
  <div class="navigation">
    <?php if(function_exists('wp_paginate')) {wp_paginate('');} ?>
  </div>      
    <div class="clear"></div>
  <?php wp_reset_query();?>    
</section>
</div><!-- /container -->

<script>
// Manter a altura dos eventos comuns todos iguais
$( document ).ready(function() {
  var heights = $(".altura").map(function() {
    return $(this).height();
  }).get(),
  maxHeight = Math.max.apply(null, heights);
  $(".altura").height(maxHeight);
});
</script>

<?php get_footer();?>