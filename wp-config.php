<?php

// BEGIN iThemes Security - Ne modifiez pas ou ne supprimez pas cette ligne
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Désactivez l’éditeur de code - iThemes Security > Réglages > Ajustements WordPress > Éditeur de code
// END iThemes Security - Ne modifiez pas ou ne supprimez pas cette ligne

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
define( 'DB_NAME', 'sneakersaddicts' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'chouchou' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '(544[g{b7mB 6JIIW3n@`/PD0!rpwB*i=l`L@jG`gH-9&&c?<[?{,unP^)zVIq_j' );
define( 'SECURE_AUTH_KEY',  'fQX@0J.xYCyf6@l0n)ed[AtD8s j]|xI|6BFFV^lB-X^xc19#6 lR%2t;!f_*:MI' );
define( 'LOGGED_IN_KEY',    'vlR6&!#!-+]&6cEoZYoM2VakPEYr6PloxZkzdIN>&_1T<3J5^R{KJBL_X/V+qI %' );
define( 'NONCE_KEY',        'yFO4C~A4mBi_`PS(zNu3=fN-Qb1+#!0Vhc%~Cl^tJ[u7>)d5q+rH?~UW,yg,2&?i' );
define( 'AUTH_SALT',        'G)-={7U:>_s]N-vAvoM)rQ;:;9(NPfS&Yn[[Z85s(bu~Khd}1cQZVt48*s ]w5AU' );
define( 'SECURE_AUTH_SALT', 'HH(iO7z9&+3!EuVLnLtpVjWpYUx&5T 3~Hr/jj.f,U|D]Av3OO/%ledM8ker:[aK' );
define( 'LOGGED_IN_SALT',   ')-iK1qo*/l7Zpz :}O`NSXjK,1^8/JW?C^5:,%!9+U0.pH,9-Pu^K3@0x+U5 `D2' );
define( 'NONCE_SALT',       '#):jb9eD2-!!tp-*q_CS=a03^Z0n:WClw4S%[RVRvg*s?QvJW$NE*yV FrVx>C/[' );
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

define('FS_METHOD', 'direct');

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
