<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', "u316799227_yves" );


/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', "u316799227_yves" );


/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', "01072009Yves@" );


/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', "localhost" );


/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );


/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '@ozsj3@bm_G>~%S*0$s?pb,y~su+XA{5c#5AkZq0njm3EQqCK>N1%|zOdT4?w?cv' );

define( 'SECURE_AUTH_KEY',  'wtQI?QU.9_+M|dmj|r0sDgg;myWSN8Dgm}3D6y5cQwRheF&;tl!W-B}D%FUjH,|#' );

define( 'LOGGED_IN_KEY',    '{c5@^&?K>-0<tTmL-n^uDeh5j^=F?k%sKw6@M@Um|s.gnZnUIm/B*o;0V/xlwv7U' );

define( 'NONCE_KEY',        'mj,}Bi s-Od]?.}h/J+cY7E6LM[Zk&%-S4uj1m*U ~j&l)ZA[%+65Vg9.E}baeqC' );

define( 'AUTH_SALT',        'S?w$8#*YzbL;3!UcOd$jZ9L=JlhfP%olBs[.t`iB+)BvXtl/V|6aWF*fd>H~U9-g' );

define( 'SECURE_AUTH_SALT', 'R]P<$.D/$q${|iM`xl^+l4E>?P!,}*9&s%sBDwevi.(^aNv vz%`CoR_$RG<Mho!' );

define( 'LOGGED_IN_SALT',   '%1.,W3n ShJ11fH{8KrqEovg0p$MdTWexx;3tK46UF=;y2 23D$(=HzOz76]KdK{' );

define( 'NONCE_SALT',       'PcuFwC^i/;>j@=I~Y(-4-ZkG_)D|_H])Cy.E33F76VO =4LS9E=[l;m<kxd0{f!8' );

/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';


/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
define( 'WP_SITEURL', 'https://yvessofer.com/' );
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname(__FILE__) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
