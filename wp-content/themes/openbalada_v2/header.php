<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>
    <?php if (is_home()){
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
	<meta name="description" content="">
	<meta name="author" content="">
  <meta name="keywords" content="balada, divulgação, mídia, vale do paraiba, eventos, festas, virada, bares" />
  <meta property="og:title" content="OpenBalada - Onde sua diversão começa!" />
  <meta property="og:url" content="http://www.openbalada.com.br/" />
  <meta property="og:image" content="http://www.openbalada.com.br/wp-content/themes/openbalada_v2/img/openbalada-logo.png" />
  <meta property="og:site_name" content="OpenBalada - Siga sua Balada!" />
  <meta property="og:description" content="OpenBalada é uma ferramenta colaborativa de divulgação de informações de eventos." />
  <meta name="robots" content="index,follow" />

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <link href="<?php bloginfo('template_directory'); ?>/css/custom.css" rel="stylesheet">
	<link href="<?php bloginfo('template_directory'); ?>/css/fonts.css" rel="stylesheet">

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico">

	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
    	<div class="container">
    		<header class="row clearfix">
          <div class="col-md-4 column">
            <a href="index.htm" title="Página Inicial"> 
              <img class="slider img-responsive open-logo hidden-xs hidden-sm" src="<?php bloginfo('template_directory'); ?>/img/openbalada-logo.png" alt="OpenBalada">
              <img class="img-responsive center-block open-logo visible-xs visible-sm" src="<?php bloginfo('template_directory'); ?>/img/openbalada-logo.png" alt="OpenBalada">
            </a>
          </div>
          <div class="col-md-4 column">
          </div>
          <div class="col-md-4 column">
          </div>
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
                <ul class="col-md-12 nav navbar-nav">
                  <li class="bg-red col-md-2 col-sm-2"><a href="index.htm">agenda</a></li>
                  <li class="bg-orange2 col-md-2 col-sm-2"><a href="index.htm">coberturas</a></li>
                  <li class="bg-green2 col-md-2 col-sm-2"><a href="index.htm">promoções</a></li>
                  <li class="bg-blue2 col-md-2 col-sm-2"><a href="index.htm">baladas</a></li>
                  <li class="bg-green1 col-md-2 col-sm-2"><a href="index.htm">rádios</a></li>
                  <li class="col-md-2 col-sm-2 input-search">
                    <form class="" role="search">
                      <div class="form-group form-group-navbar-nav">
                        <input type="text" class="form-control input-search" />
                      </div> 
                    </form>
                  </li>
                </ul>                 
              </div>
            </nav>
          </div>
          <?php wp_head(); ?>
        </header> 