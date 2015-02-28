<?php get_header();?>

<section class="row"> 
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo">Agenda</h1>
  </div>

  <?php
  /* LOOP PARA EVENTO PRINCIPAL */
  date_default_timezone_set("America/New_York"); 
  $today = date( 'Y-m-d' );
  $args=array(
    'showposts' => -1,
    'category_name' => 'agenda',
    'meta_key' => 'evento_tipo',
    'meta_value' => 'Principal',
    'meta_query' => array(
      array(
        'key' => 'evento-data',
        'value' => $today,
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

    //Recebe o valor de tipo de evento*/  
  $eventoTipo = null;
  $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);

  /* Checa se evento é Hoje ou Outro Dia */
  date_default_timezone_set("America/New_York"); 
  $dataAtual = date("Y-m-d");
  $dataEvento = get_post_meta($post->ID,'evento-data',true);

  /*($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; */
  /*($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; */

  $verificaDia_MainEvent = null;
  $verificaDia_CommomEvent = $verificaDia_MainEvent;
  if ($dataAtual == $dataEvento) :
    $verificaDia_MainEvent = "event-main-nowaday";
  $verificaDia_CommomEvent = "nowaday";
  endif;

  /* EVENTO PRINCIPAL */ ?>

  <article class="col-md-6 column events event-main <?php echo $verificaDia_MainEvent;?>">
    <a href="<?php the_permalink();?>" title="<?php the_title();?>">
      <?php if(has_post_thumbnail()) :
      the_post_thumbnail( 'large', array( 'class' => 'img-responsive center-block' ) ); 
      else : ?>
      <img src="http://openbalada.com.br/wp-content/themes/openbalada_v2/img/no-image.jpg" class="img-responsive center-block" alt="Imagem Não Disponível">
    <?php endif; ?>
    <div class="details">
      <div class="details-wrapper">                
        <div class="event-description">
          <h2><?php the_title();?></h2>
          <h3><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25); echo '...'; ?></h3>
          <h4><?php $category = get_the_category(); echo $category[1]->cat_name; ?></h4>
        </div>
        <?php if ($verificaDia_MainEvent == "event-main-nowaday") : ?>
          <div class="event-date event-secondary event-secondary-date">
            <p class="dia-hoje">HJ</p>
          </div>
        <?php else : ?> 
          <div class="event-date event-secondary event-secondary-date">
            <?php $dia = (string) substr($dataEvento, -2);
            $mesEvento = (string) substr($dataEvento, -5, 2); ?>
            <?php switch ($mesEvento) {
              case "01":    $mes = "jan";   break;
              case "02":    $mes = "fev";   break; 
              case "03":    $mes = "mar";   break;
              case "04":    $mes = "abr";   break;
              case "05":    $mes = "mai";   break;
              case "06":    $mes = "jun";   break;
              case "07":    $mes = "jul";   break;
              case "08":    $mes = "ago";   break;
              case "09":    $mes = "set";   break;
              case "10":    $mes = "out";   break;
              case "11":    $mes = "nov";   break;
              case "12":    $mes = "dez";   break; }?>
              <p class="data-dia"><?php echo $dia; ?></p>
              <p class="data-mes"><small><?php echo $mes; ?></small></p>
            </div>   
          <?php endif; ?>            
          <div class="clear"></div>
        </div><!-- detais-wrapper -->
      </div>
      <div class="clear"></div>
    </a>
  </article>
<?php endwhile; else:?>
  <article class="col-md-12">
    <?php $event_principal = 0; ?>
  </article>
  <div class="clearfix"></div>
  <?php endif;
  // Reset Query
  wp_reset_query();?>

  <?php /* ----------------------------------------------------- */ ?>

  <?php
  /* LOOP PARA EVENTO SECUNDÁRIO */
  $today = date( 'Y-m-d' );
  $args=array(
    'showposts' => -1,
    'category_name' => 'agenda',
    'meta_key' => 'evento_tipo',
    'meta_value' => 'Secundario',
    'meta_query' => array(
      array(
        'key' => 'evento-data',
        'value' => $today,
        'compare' => '>=',
        'type' => 'DATE'
        )
      ),
    'orderby' => 'evento-data',
    'order' => 'ASC'
    );

  query_posts($args);
  if (have_posts()): while (have_posts()) : the_post();  

    //Recebe o valor de tipo de evento*/  
  $eventoTipo = null;
  $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);

  /* Checa se evento é Hoje ou Outro Dia */
  date_default_timezone_set("America/New_York"); 
  $dataAtual = date("Y-m-d");
  $dataEvento = get_post_meta($post->ID,'evento-data',true);

  /*($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; */
  ($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; 

  $verificaDia_MainEvent = null;
  $verificaDia_CommomEvent = $verificaDia_MainEvent;
  if ($dataAtual == $dataEvento) :
    $verificaDia_MainEvent = "event-main-nowaday";
  $verificaDia_CommomEvent = "nowaday";
  endif;

  /* EVENTO SECUNDÁRIO */ ?>
  <article class="col-md-3 events <?php echo $verificaDia_MainEvent;?>">
    <a href="<?php the_permalink();?>" title="<?php the_title();?>">
      <?php if(has_post_thumbnail()) :
      the_post_thumbnail( 'medium', array( 'class' => 'img-responsive center-block'));
      else : ?>
      <img src="http://openbalada.com.br/wp-content/themes/openbalada_v2/img/no-image.jpg" class="img-responsive center-block" alt="Imagem Não Disponível">
    <?php endif; ?>          
    <div class="details"> 
      <div class="details-wrapper">
        <div class="event-description">
          <h2><?php the_title();?></h2>
          <h3><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,8); echo '...'; ?></h3>
          <h4><?php $category = get_the_category(); echo $category[1]->cat_name; ?></h4>
        </div>
        <?php if ($verificaDia_MainEvent == "event-main-nowaday") : ?>
          <div class="event-date event-secondary event-secondary-date">
            <p class="dia-hoje">HJ</p>
            <div class="clear"></div>
          </div>
        <?php else : ?>
          <div class="event-date event-secondary event-secondary-date">
            <?php $dia = (string) substr($dataEvento, -2);
            $mesEvento = (string) substr($dataEvento, -5, 2); ?>
            <?php switch ($mesEvento) {
              case "01":    $mes = "jan";   break;
              case "02":    $mes = "fev";   break; 
              case "03":    $mes = "mar";   break;
              case "04":    $mes = "abr";   break;
              case "05":    $mes = "mai";   break;
              case "06":    $mes = "jun";   break;
              case "07":    $mes = "jul";   break;
              case "08":    $mes = "ago";   break;
              case "09":    $mes = "set";   break;
              case "10":    $mes = "out";   break;
              case "11":    $mes = "nov";   break;
              case "12":    $mes = "dez";   break; 
            } ?>
            <p class="data-dia"><?php echo $dia; ?></p>
            <p class="data-mes"><small><?php echo $mes; ?></small></p>
            <div class="clear"></div>
          </div>
          <?php endif; ?>               
        <div class="clear"></div>
      </div><!-- detais-wrapper -->
    </div>
    <div class="clear"></div>
  </a>
</article> 
<?php endwhile; else:?>
  <?php $event_secundario = 0; ?>
  <?php endif;
  // Reset Query
  wp_reset_query();?>
  <div class="clearfix"></div>            
</section>

<?php /* ----------------------------------------------------- */ ?>
<section class="row"> 
 <?php
 /* LOOP PARA EVENTO COMUM */
 $today = date( 'Y-m-d' );
 $args=array(
  'showposts' => -1,
  'category_name' => 'agenda',
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'evento-data',
      'value' => $today,
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

    //Recebe o valor de tipo de evento*/  
 $eventoTipo = null;
 $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);

 /* Checa se evento é Hoje ou Outro Dia */
 date_default_timezone_set("America/New_York"); 
 $dataAtual = date("Y-m-d");
 $dataEvento = get_post_meta($post->ID,'evento-data',true);

 /*($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; */
 ($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; 

 $verificaDia_MainEvent = null;
 $verificaDia_CommomEvent = $verificaDia_MainEvent;
 if ($dataAtual == $dataEvento) :
  $verificaDia_MainEvent = "event-main-nowaday";
$verificaDia_CommomEvent = "nowaday";
endif; ?>    

<!-- sm xs md -->          
<article class="col-md-3 col-sm-12 col-xs-12 events  <?php echo $verificaDia_CommomEvent;?>">
  <a href="<?php the_permalink();?>" title="<?php the_title();?>" >
    <div class="details-wrapper table-row">
      <?php if ($verificaDia_CommomEvent == "nowaday") : ?>
        <div class="col-md-3 col-sm-3 col-xs-3 event-secondary event-secondary-date el">
          <p class="dia-hoje">HJ</p>
        </div>
      <?php else : ?>
        <div class="col-md-3 col-sm-3 col-xs-3 event-secondary event-secondary-date el">
        <?php $dia = (string) substr($dataEvento, -2);
        $mesEvento = (string) substr($dataEvento, -5, 2); ?>
        <?php switch ($mesEvento) {
          case "01":    $mes = "jan";   break;
          case "02":    $mes = "fev";   break; 
          case "03":    $mes = "mar";   break;
          case "04":    $mes = "abr";   break;
          case "05":    $mes = "mai";   break;
          case "06":    $mes = "jun";   break;
          case "07":    $mes = "jul";   break;
          case "08":    $mes = "ago";   break;
          case "09":    $mes = "set";   break;
          case "10":    $mes = "out";   break;
          case "11":    $mes = "nov";   break;
          case "12":    $mes = "dez";   break; 
        } ?>
        <p class="data-dia"><?php echo $dia; ?></p>
        <p class="data-mes"><small><?php echo $mes; ?></small></p>
        <div class="clear"></div>
      </div>
    <?php endif; ?>
      <div class="col-md-9 col-sm-9 col-xs-9 event-secondary event-secondary-description el">
        <h3><?php the_title(); ?></h3>
        <p><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,8); echo '...'; ?></p>
        <p><small><?php $category = get_the_category(); echo $category[1]->cat_name; ?></small></p>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div><!-- detais-wrapper -->
  </a>
</article>
<?php endwhile; else:?>
  <?php $event_comum = 0; ?>
  <?php endif;
    // Reset Query
  if (($event_principal === 0) && ($event_secundario === 0) && ($event_comum === 0)): ?>
  <article class="col-md-3 col-sm-12 col-xs-12 events nowaday">
    <div class="teste col-md-3 col-sm-3 col-xs-3 event-secondary event-secondary-date bg-red">
      <p>!</p>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-9 event-secondary event-secondary-description">
      <h3 class="color-red">Sem eventos!</h3>
      <p>Desculpe! Não foram encontrados eventos cadastrados!</p>
    </div>
  </article>
  <?php endif;
  wp_reset_query();?>    
  <div class="clearfix"></div>
</section>
</div><!-- /container -->

<script>
$( document ).ready(function() {
    var heights = $(".el").map(function() {
        return $(this).height();
    }).get(),

    maxHeight = Math.max.apply(null, heights);

    $(".el").height(maxHeight);
});
</script>

<?php get_footer();?>