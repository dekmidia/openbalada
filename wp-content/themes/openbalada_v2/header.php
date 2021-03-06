<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title><?php if (is_home()){
      bloginfo('name');
    }elseif (is_category()){
      single_cat_title(); echo ' -  ' ; bloginfo('name');
    }elseif (is_single()){
      single_post_title();
    }elseif (is_page()){
      bloginfo('name'); echo ': '; single_post_title();
    }else {
      wp_title('',true);
    } ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo get_bloginfo ( 'description' );?> ">
  <meta name="author" content="DekMídia Soluções Digitais">
  <meta name="keywords" content="balada, divulgação, mídia, vale do paraiba, eventos, festas, virada, bares" />

  <meta property="og:title" content="OpenBalada - Onde sua diversão começa!" />
  <meta property="og:url" content="http://www.openbalada.com.br/" />
  <meta property="og:image" content="http://www.openbalada.com.br/wp-content/themes/openbalada_v2/img/openbalada-logo.png" />
  <meta property="og:site_name" content="OpenBalada - Siga sua Balada!" />
  <meta property="og:description" content="OpenBalada é uma ferramenta colaborativa de divulgação de informações de eventos." />
  <meta name="robots" content="index,follow" />

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <!-- ESTILOS -->
  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <link href="http://openbalada.com.br/wp-content/themes/openbalada_v2/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://openbalada.com.br/wp-content/themes/openbalada_v2/css/bootstrap-xl.css" rel="stylesheet">
  <link href="http://localhost/openbalada/wp-content/themes/openbalada_v2/css/custom.css" rel="stylesheet">  
  <link href="http://openbalada.com.br/wp-content/themes/openbalada_v2/css/fonts.css" rel="stylesheet">

  <!-- Fav and touch icons -->
  <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico">  
  
    </head>
    <body class="waitMe_body">
    	<div class="container conteudo">
    		<header class="row clearfix">
          <div class="col-md-3 column">
            <a href="<?php echo get_settings('home'); ?>" title="Página Inicial"> 
              <img class="slider img-responsive open-logo hidden-xs hidden-sm" src="<?php bloginfo('template_directory'); ?>/img/openbalada-logo.png" alt="OpenBalada">
              <img class="img-responsive center-block open-logo visible-xs visible-sm" src="<?php bloginfo('template_directory'); ?>/img/openbalada-logo.png" alt="OpenBalada">
            </a>
          </div>
          
          <?php  // Area de Ads - Google e Boo-Box

            /*$ad1 = '
              <div class="col-md-9 column adsense hidden-xs hidden-sm">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Validação OpenBalada -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-8448516230767950"
                     data-ad-slot="1317560629"></ins>
                <script>
                  (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
              </div>
              
              <div class="col-md-9 column adsense-mobile visible-xs visible-sm">            
                  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- Validação OpenBalada -->
                  <ins class="adsbygoogle"
                   style="display:block"
                   data-ad-client="ca-pub-8448516230767950"
                   data-ad-slot="2925927825"
                   data-ad-format="auto"></ins>
                  <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
              </div>
             ';*/
            $ad2 = '
            <div class="col-md-9 column adsense hidden-xs hidden-sm">            
              <script type="text/javascript">
                bb_bid = "1700590";
                bb_lang = "pt-BR";
                bb_name = "custom";
                bb_limit = "8";
                bb_format = "bbb";
              </script>
              <script type="text/javascript" src="http://static.boo-box.com/javascripts/embed.js"></script>
            </div>' ;

            /*$banners = array($ad1, $ad2);
            shuffle($banners);
            print $banners[0]*/
            echo $ad2;
            ?>

          <div class="col-md-12 column">
            <nav class="nav-main navbar navbar-default navbar-main" role="navigation">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button> 
              </div>
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php wp_nav_menu(array(
                  'container_class' => 'menu-header',
                  'theme_location' => 'primary',
                  'items_wrap' => '<ul id="%1$s" class="%2$s col-md-10 nav navbar-nav">%3$s</ul>',
                  'walker' => new BS3_Walker_Nav_Menu,
                  )); ?> 
                  <?php $search_text = ""; ?> 
                  <form class="col-md-2 col-sm-2 input-search" method="get" id="searchform" action="<?php bloginfo('home'); ?>/"> 
                    <div class="form-group form-group-navbar-nav">
                      <input class="form-control" type="text" value="<?php echo $search_text; ?>" name="s" id="s" onblur="if (this.value == '')  
                      {this.value = '<?php echo $search_text; ?>';}"  
                      onfocus="if (this.value == '<?php echo $search_text; ?>'){this.value = '';}" /> 
                      <input type="hidden" id="searchsubmit" /> 
                    </div> 
                  </form>
                </div>
              </nav>
            </div>
          </header> 