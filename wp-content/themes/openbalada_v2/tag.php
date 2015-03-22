<?php get_header();?>

<section class="row"> 
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo-page"><small>Buscando por:  </small><br><?php "  ".single_cat_title();?></h1>
  </div>

  <?php 
/*Seta o horário de Nova York, que é duas horas atrasado, para que
os eventos fiquem visíveis até duas horas da manhã no site*/
date_default_timezone_set("America/New_York"); 
//Pega a data atual do sistema
/*$dataSistema = date( 'Y-m-d' ); 
?>

<?php
/*LOOP PARA EVENTO SECUNDÁRIO */  
/*$args=array(
  'showposts' => -1,
  'meta_query' => array(
    array(
      'key' => 'evento-data',
      'value' => $dataSistema,
      'type' => 'DATE'
      )
    ),
  'orderby' => 'evento-data',
  'order' => 'ASC'
  );
query_posts($args);
if (have_posts()): while (have_posts()) : the_post();  

  //Recebe os valores de tipo de evento, data e se o evento é hoje */  
/*$eventoTipo = get_post_meta($post->ID,'evento-tipo',true);
$eventoData = get_post_meta($post->ID,'evento-data',true);
$eHoje = verificaQuando ($eventoData);
?>

<?php /* EVENTO PRINCIPAL */ ?>
<?php if (have_posts()): while (have_posts()) : the_post();
//Recebe os valores de tipo de evento, data e se o evento é hoje */  
$eventoTipo = get_post_meta($post->ID,'evento-tipo',true);
$eventoData = get_post_meta($post->ID,'evento-data',true);
$eHoje = verificaQuando ($eventoData);?>

<article class="col-md-3 eventos">
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
        <h4><?php $category = get_the_category(); echo $category[1]->cat_name; ?></h4>
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
</article> 
<?php endwhile; else:?>
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
    <?php if(function_exists('wp_paginate')) {wp_paginate('');} ?></div>      
  <div class="clear"></div>
  <div class="clearfix"></div>            
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