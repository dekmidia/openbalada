<?php get_header();?>    
<section class="row clearfix margin-right-none"> 
  <?php if (have_posts()): while (have_posts()) : the_post();?>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo-page">Evento</h1>
  </div>  

      <?php //Recebe o valor de tipo de evento*/  
      $eventoTipo = null;
      $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);

      /* Checa se evento é Hoje ou Outro Dia */
      date_default_timezone_set("America/New_York"); 
      $dataAtual = date("Y-m-d");
      $dataEvento = get_post_meta($post->ID,'evento-data',true);
      
      /*($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; */
      /*($dataAtual == $dataEvento) ? $queDia = "Hoje" : $queDia = "Outro dia"; */      
     ?> 

      <div class="col-md-4 column events event-main">
        <a href="<?php the_permalink(); ?>">
          <?php if(has_post_thumbnail()) :
            the_post_thumbnail( 'medium', array( 'class' => 'img-responsive center-block'));
          else : ?>
            <img src="http://openbalada.com.br/wp-content/themes/openbalada_v2/img/no-image.jpg" class="img-responsive center-block" alt="Imagem Não Disponível">
          <?php endif; ?>  
        </a>

      <?php $verificaDia_MainEvent = null;
      $verificaDia_CommomEvent = $verificaDia_MainEvent;
      if ($dataAtual == $dataEvento) :
        $verificaDia_MainEvent = "event-main-nowaday";
      endif; ?> 

      <?php if ($verificaDia_MainEvent == "event-main-nowaday") : ?>

          <div class="details-page details-pageevento event-main-nowaday">
            <div class="event-date event-secondary event-secondary-date">
              <p style="display:block; margin-top: 17px">HJ</p>
            </div>               
            <div class="clear"></div>
          </div>

        <?php else : ?>

        <div class="details-page details-pageevento">
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
          </div>

        <?php endif; ?>
      </div>

  <div class="col-md-8 column">
    <div class="row">
      <div class="col-md-12 column descricao-pageevento">
        <h2 class="color-red text-uppercase"><strong><?php the_title();?></strong></h2>
        <?php the_content(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="box-info">
          <i class="icons-sprite icon-date"></i>
          <p><strong>
            <?php echo date('d', strtotime(get_post_meta($post->ID,"evento-data",true)));?>
            <?php echo "/" ?>
            <?php $traduzDia = date('M', strtotime(get_post_meta($post->ID,"evento-data",true))); 
            switch ($traduzDia) {
              case "Jan": echo "Jan"; break;
              case "Feb": echo "Fev"; break;
              case "Mar": echo "Mar"; break;
              case "Apr": echo "Abr"; break;
              case "May": echo "Mai"; break;
              case "Jun": echo "Jun"; break;
              case "Jul": echo "Jul"; break;
              case "Aug": echo "Ago"; break;
              case "Sep": echo "Set"; break;
              case "Oct": echo "Out"; break;
              case "Nov": echo "Nov"; break;
              case "Dec": echo "Dez"; break;
            }?>
          <?php echo "/" ?>
          <?php echo date('y', strtotime(get_post_meta($post->ID,"evento-data",true)));?></strong></p>    
        </div>
      </div>
      <?php $variavel = null; ?>
      <?php $variavel = get_post_meta($post->ID,'evento-horario',true); ?>
      <?php if (($variavel != "")||($variavel != null)) : ?>
        <div class="col-md-3">
          <div class="box-info bg-orange2">
            <i class="icons-sprite  icon-hour"></i>
            <p><strong><?php echo $variavel; ?></strong></p>
          </div>
        </div>
      <?php endif; ?>
      <?php $variavel = null; ?>
      <?php $variavel = get_post_meta($post->ID,'evento-valor',true); ?>
      <?php if (($variavel != "")||($variavel != null)) : ?>
      <div class="col-md-3">
        <div class="box-info bg-green4">
          <i class="icons-sprite icon-value"></i>
          <p><strong><?php echo $variavel; ?></strong></p>
        </div>
      </div>
      <?php endif; ?>
      <?php $variavel = null; ?>
      <?php $variavel = get_post_meta($post->ID,'evento-faixa-etaria',true); ?>
        <?php if (($variavel != "")||($variavel != null)) : ?>
        <div class="col-md-3">
          <div class="box-info bg-green1">
            <i class="icons-sprite icon-rating"></i>
            <p><strong><?php echo $variavel;?></strong></p>
          </div>
        </div> 
      <?php endif; ?>
      <div class="col-md-12 column">
        <div class="box-info bg-green2">
          <i class="icons-sprite icon-maps"></i>
          <p class="hidden-xs hidden-sm"><strong>Como chegar?</strong></p>
          <p class="text-center visible-xs visible-sm"><strong>Como chegar?</strong></p>
        </div>
      </div>
      <div class="col-md-6 column descricao-pageevento descricao-maps">
        <p><small>Endereço</small></p>
              <p class="box-cinza"><strong><?php echo get_post_meta($post->ID,'evento-endereco',true); ?></strong></p>
        <p><small>Cidade:</small></p>
              <p class="box-cinza"><strong><?php $category = get_the_category(); echo $category[1]->cat_name;true; ?></strong></p>
        <?php $variavel = get_post_meta($post->ID,'evento-url',true); ?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Website</small></p>
            <p class="box-cinza"><strong><a href="<?php echo $variavel; ?>" target="_blank"<?php echo $variavel; ?></a></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>
        <?php $variavel = get_post_meta($post->ID,'evento-redes',true); ?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Redes Sociais</small></p>
            <p class="box-cinza"><strong><a href="<?php echo $variavel; ?>" target="_blank">Clique para Acessar</a></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>  
        <?php $variavel = get_post_meta($post->ID,'evento-email',true); ?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Contato</small></p>
            <p class="box-cinza"><strong><?php echo $variavel; ?></strong></p>
          <?php endif; ?>
        <?php $variavel = null; ?>
      </div>
      <div class="col-md-6 column">
        <div class="maps-pageevento">
          <iframe src="https://www.google.com/maps/embed?pb=<?php echo get_post_meta($post->ID,'evento-endereco',true); ?>" frameborder="0" style="border:0"></iframe>
        </div>
      </div>
    </div>
  </div>    
  <?php endwhile; else:?>
  <?php endif;?>                   
</section>                 
</div><!-- /container -->
<?php get_footer();?>