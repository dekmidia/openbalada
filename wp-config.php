<?php



/** Enable W3 Total Cache Edge Mode */

define('W3TC_EDGE_MODE', true); // Added by W3 Total Cache


define( 'WP_MEMORY_LIMIT', '256M' );

/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'openbala_obdb_v1');


/** Usuário do banco de dados MySQL */
define('DB_USER', 'openbala_opnblda');


/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 's@&5IH4u');


/** nome do host do MySQL */
define('DB_HOST', 'localhost');


/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ']=o?f!p|SU&$pDO;.;OVG+_Vb}qwj<N39a:s;B@[/<6p$|BW|U/+:[dmkHn:71-E');

define('SECURE_AUTH_KEY',  '7K8SvbD#Jvfu&dUL,OW5]$RwC4~E-[4f76M,3QGfB-gmtR4PAV:|3X]JU1vr [1$');

define('LOGGED_IN_KEY',    'hcv-nirX9r|u`&jCN.9u|i,.+!1dv<g~9 Oz;zanB>eYuE ,X:+^rvW.H!G+3kw[');

define('NONCE_KEY',        '-wZXF/[aN7XM-8i.zDh(KYF -a68ZIZY|Q8C8HqlfwZW|NxU:%h&u@},.g6u0kP+');

define('AUTH_SALT',        '>|6b.VXX<g|8%&ii$$f9C}SfU=7]u0*18mp-94=uA3v2=&&Oi6MNZk7-%E{0} qY');

define('SECURE_AUTH_SALT', 'CdIGW9PRCbptU-E:h!@[T{aUixpH4|nS.H&ZIlqq4`0g9xU]_Dra1>_&}3-f?i??');

define('LOGGED_IN_SALT',   'le&Ot)ovS7; !ZA(d)N=vI]bE~$]Z H_=1~-yr2Pa4V-W-|>xlYwLeTu c$_p*Z@');

define('NONCE_SALT',       'wP,+yr%:`ac=T2`cb(#6`4,Z{7{]y+Ni Nv)eixhRUtBNfPXbIt)7L9R1XeY20gM');


/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';



/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
