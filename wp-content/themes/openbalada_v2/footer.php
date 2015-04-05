    <div class="clear clearfix"></div>
    <footer class="clearfix"> 
    	<div class="container">
    		<div class="row">
                <div class="col-md-4 text-center padding-top-bottom-5">
        			<p><img class="logo-footer" src="<?php bloginfo('template_directory'); ?>/img/openbalada-logo-footer.png" alt="OpenBalada"></p>
                </div>
                <div class="col-md-4 text-center padding-top-bottom-5">
                    <p><small>2015 - Todos os direitos reservados  |  Versão 0.2.77</small></p>
                </div>
                <div class="col-md-4 text-center padding-top-bottom-5">
                    <a href="http://www.dekmidia.com.br" target="_blank" title="Precisando de soluções Digitais? Conheça a DekMídia" rel="nofollow">
                        <p><img class="logo-footer" src="<?php bloginfo('template_directory'); ?>/img/projeto-dekmidia.png" alt="OpenBalada"></p>
                    </a>
                </div>
    		</div>  
    	</div>       
    </footer>
    
    <!-- SCRIPTS -->
    <?php wp_head(); ?>
    <?php wp_footer(); ?>
    <script type="text/javascript" src="http://openbalada.com.br/wp-content/themes/openbalada_v2/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://openbalada.com.br/wp-content/themes/openbalada_v2//js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    <script>
    // Manter a altura dos eventos comuns todos iguais
    $( document ).ready(function() {
      var heights = $(".altura").map(function() {
        return $(this).height();
      }).get(),
      maxHeight = Math.max.apply(null, heights);
      $(".altura").height(maxHeight);
    });

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-59989207-1', 'auto');
	  ga('send', 'pageview');
	</script>
</body>
</html>