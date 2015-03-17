<?php get_header();?>    
<section class="row clearfix margin-right-none"> 
  <?php if (have_posts()): while (have_posts()) : the_post();?>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h1 class="titulo-page">Evento</h1>
  </div>

<?php 
/*Seta o horário de Nova York, que é duas horas atrasado, para que
os eventos fiquem visíveis até duas horas da manhã no site*/
date_default_timezone_set("America/New_York"); 
//Pega a data atual do sistema
$dataSistema = date( 'Y-m-d' ); 

 //Recebe os valores de tipo de evento, data e se o evento é hoje */  
  $eventoTipo = get_post_meta($post->ID,'evento-tipo',true);
  $eventoData = get_post_meta($post->ID,'evento-data',true);
  $eHoje = verificaQuando ($eventoData);
 ?>  

  <div class="col-md-4 col-sm-12 col-xs-12 column eventos-single-page">
    <?php 
      if(has_post_thumbnail()) : the_post_thumbnail( 'large', array( 'class' => 'img-responsive center-block' ) ); 
      else : ?> <img src="http://openbalada.com.br/wp-content/themes/openbalada_v2/img/no-image.jpg" class="img-responsive center-block" alt="Imagem Não Disponível"><?php
      endif; 
    ?>
    <div class="detalhes">
      <div class="detalhes-bloco <?php echo $eHoje;?>">
          <div class="evento-data evento-data-singlepage">
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
      <div class="clearfix"></div>
    </div><!-- /detalhes -->
  </div>
  <br>
  <br>
  <div class="col-md-8 col-sm-12 col-xs-12 column">
    <div class="row">
      <div class="col-md-12 column descricao-pageevento">
        <h2 class="color-red text-uppercase"><strong><?php the_title();?></strong></h2>
        <?php the_content(); ?>
        <br>
        <p><?php the_tags('<strong class="tags">TAGS: </strong>',' • ','<br /><br />'); ?></p>
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
      <?php $variavel = get_post_meta($post->ID,'evento-valor',true); 
      $str = strip_tags($variavel);?>
      <?php if (($variavel != "")||($variavel != null)) : ?>
      <div class="col-md-3">
        <div class="box-info bg-green4">
          <i class="icons-sprite icon-value"></i>
          <p><strong><?php echo $str; ?></strong></p>
        </div>
      </div>
      <?php endif; ?>
      <?php $variavel = null; ?>
      <?php $variavel = get_post_meta($post->ID,'evento-faixa-etaria',true); ?>
      <?php $str = strip_tags($variavel);?>
        <?php if (($variavel != "")||($variavel != null)) : ?>
        <div class="col-md-3">
          <div class="box-info bg-green1">
            <i class="icons-sprite icon-rating"></i>
            <p><strong><?php echo $str;?></strong></p>
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
        <?php /* ------ LOCAL ------ */?>
        <?php $variavel = get_post_meta($post->ID,'evento-local',true); ?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <?php $str = strip_tags($variavel);?>
            <p><small>Local do Evento:</small></p>
            <p class="box-cinza"><strong><?php echo $str; ?></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>

        <?php /* ------ ENDEREÇO ------ */?>
        <p><small>Endereço</small></p>
              <p class="box-cinza"><strong><?php echo get_post_meta($post->ID,'evento-endereco',true); ?></strong></p>
        
        <?php /* ------ CIDADE ------ */?>
        <p><small>Cidade:</small></p>
              <p class="box-cinza"><strong>
                <?php $category = get_the_category(); echo $category[1]->cat_name;true; ?>
               </strong></p>
        
        <?php /* ------ TELEFONE ------ */?>
        <?php $variavel = get_post_meta($post->ID,'evento-telefone',true); ?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <?php $str = strip_tags($variavel);?>
            <p><small>Telefone para informações</small></p>
            <p class="box-cinza"><strong><?php echo $str; ?></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>
        
        <?php /* ------ WHATSAPP ------ */?>
        <?php $variavel = get_post_meta($post->ID,'evento-whatsapp',true); ?>
          <?php $str = strip_tags($variavel);?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Whatsapp</small></p>
            <p class="box-cinza"><strong><?php echo $str; ?></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>
        
        <?php /* ------ WEBSITE ------ */?>
        <?php $variavel = get_post_meta($post->ID,'evento-url',true); ?>
          <?php $str = strip_tags($variavel);?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Website</small></p>
            <p class="box-cinza"><strong><a href="<?php echo $variavel; ?>" target="_blank"><?php echo $str; ?></a></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>
        
        <?php /* ------ REDES SOCIAIS ------ */?>
        <?php $variavel = get_post_meta($post->ID,'evento-redes',true); ?>
          <?php $str = strip_tags($variavel);?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Redes Sociais</small></p>
            <p class="box-cinza"><strong><a href="<?php echo $str; ?>" target="_blank">Clique para Acessar</a></strong></p>
          <?php endif; ?>
          <?php $variavel = null; ?>  
        
        <?php /* ------ E-MAIL ------ */?>
        <?php $variavel = get_post_meta($post->ID,'evento-email',true); ?>
          <?php $str = strip_tags($variavel);?>
          <?php if (($variavel != "")||($variavel != null)) : ?>
            <p><small>Contato</small></p>
            <p class="box-cinza"><strong><?php echo $str; ?></strong></p>
          <?php endif; ?>
        <?php $variavel = null; ?>
      </div>

      <?php /* ------ GOOGLE MAPS ------ */?>
      <div class="col-md-6 column">
        <div class="maps-pageevento">
          <iframe frameborder="0" style="border:0" src="https://maps.google.it/maps?q=<?php echo get_post_meta($post->ID,'evento-endereco',true); ?>&output=embed"></iframe>
          <p><small><strong class="color-red">Fique atento:</strong> O mapa exibe dinamicamente o endereço, por isto as vezes ele pode demonstrar o caminho incorretamente.</small></p>
        </div>
      </div>
    </div>
  </div>    
  <?php endwhile; else:?>
  <?php endif;?>                   
</section>                 
</div><!-- /container -->
<?php get_footer();?>