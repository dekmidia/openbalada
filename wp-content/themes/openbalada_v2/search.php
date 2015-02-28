<?php get_header();?>

<section class="row"> 
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo-page"><small>Buscando por:  </small><br><?php echo get_search_query()?></h1>
  </div>

  <?php
  /*LOOP PARA EVENTO SECUNDÁRIO */  
  $today = date( 'Y-m-d' );
  $args=array(
    'showposts' => -1,
    'meta_query' => array(
        array(
            'key' => 'evento-data',
            'value' => $today,
            'type' => 'DATE'
        )
    ),
    'orderby' => 'evento-data',
    'order' => 'ASC'
  );
  $the_query = new WP_Query( $args );
  if ($the_query->have_posts()): while (have_posts()) : the_post();  

    /* Checa se evento é Hoje ou Outro Dia */
    date_default_timezone_set("America/New_York"); 
    $dataAtual = date("Y-m-d");
    $dataEvento = get_post_meta($post->ID,'evento-data',true);
  
    $verificaDia_MainEvent = null;
    $verificaDia_CommomEvent = $verificaDia_MainEvent;
    if ($dataAtual == $dataEvento) :
      $verificaDia_MainEvent = "event-main-nowaday";
      $verificaDia_CommomEvent = "nowaday";
    endif;

    /* EVENTO PRINCIPAL */ ?>
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
                <p><?php echo $dia; ?></p>
                <p><small><?php echo $mes; ?></small></p>
              </div>               
              <div class="clear"></div>
            </div><!-- detais-wrapper -->
          </div>
          <div class="clear"></div>
        </a>
      </article> 
  <?php endwhile; else:?>
  <article class="col-md-3 col-sm-12 col-xs-12 events nowaday">
      <a href="<?php the_permalink();?>" title="<?php the_title();?>">
        <div class="details-wrapper">
            <div class="teste col-md-3 col-sm-3 col-xs-3 event-secondary event-secondary-date bg-red">
              <p>!</p>
            </div>
          <div class="col-md-9 col-sm-9 col-xs-9 event-secondary event-secondary-description">
            <h3 class="color-red">SEM RESULTADOS!</h3>
            <p>Desculpe! Não foram encontrados resultados com este termo. Faça uma busca com outras palavras!</p>
          </div>
          <div class="clear"></div>
        </div><!-- detais-wrapper -->
      </a>
    </article>

  <?php endif;
  // Reset Query
  wp_reset_postdata();?>
  <div class="clearfix"></div>            
  </section> 
 
  </div><!-- /container -->

<?php get_footer();?>