<?php
/**
 * Plugin Name: Page Builder: Live Composer - drag and drop website builder (visual front end site editor)
 * Plugin URI: https://www.livecomposerplugin.com
 * Description: Front-end page builder for WordPress with drag and drop editing. Build PRO responsive websites and landing pages. Visually customize any page element.
 * Author: Live Composer Team
 * Version: 1.1.4
 * Author URI: https://livecomposerplugin.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: live-composer-page-builder
 * Domain Path: /lang
 *
 * Live Composer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Live Composer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Live Composer. If not, see <http://www.gnu.org/licenses/>.
 *
 * Idea, initial development and inspiration by
 * Slobodan Kustrimovic https://github.com/BobaWebDev
 *
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

// Do not allow different versions of Live Composer to run at the same time!
if ( ! defined( 'DS_LIVE_COMPOSER_VER' ) ):

	/**
	 * Constants
	 */

	define( 'DS_LIVE_COMPOSER_VER', '1.1.4' );

	define( 'DS_LIVE_COMPOSER_SHORTNAME', __( 'Live Composer', 'live-composer-page-builder' ) );
	define( 'DS_LIVE_COMPOSER_BASENAME', plugin_basename( __FILE__ ) );
	define( 'DS_LIVE_COMPOSER_URL', plugin_dir_url( __FILE__ ) );
	define( 'DS_LIVE_COMPOSER_DIR_NAME', dirname( plugin_basename( __FILE__ ) ) );
	define( 'DS_LIVE_COMPOSER_ABS', dirname( __FILE__ ) );
	define( 'DS_LIVE_COMPOSER_DEV_MODE', false );

	define( 'DSLC_PO_FRAMEWORK_ABS', DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework' );
	define( 'DSLC_ST_FRAMEWORK_ABS', DS_LIVE_COMPOSER_ABS . '/includes/single-templates-framework' );
	define( 'DSLC_ROW_SYSTEM_ABS', DS_LIVE_COMPOSER_ABS . '/includes/row-system' );


	$dslc_var_image_option_bckp = array();
	$dslc_var_row_options = array();

	/**
	 * Is live composer currently active?
	 *
	 * $_GET used on regular pages
	 * $_POST used for AJAX requests
	 */
	if ( isset( $_GET['dslc'] ) || isset( $_POST['dslc'] ) ) {
		$dslc_active = true;
		define( 'DS_LIVE_COMPOSER_ACTIVE', true );
	} else {
		$dslc_active = false;
		define( 'DS_LIVE_COMPOSER_ACTIVE', false );
	}

	/**
	 * Global Variables
	 */

	$dslc_var_modules = array(); // Will hold modules information
	$dslc_var_templates = array(); // Will hold templates information
	$dslc_var_post_options = array(); // Will hold post options information
	$dslc_var_icons = array(); // Will hold available icons array.

	$dslc_css_fonts = '';
	$dslc_css_style = '';
	$dslc_googlefonts_array = array();
	$dslc_all_googlefonts_array = array( "ABeeZee", "Abel", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro", "Aguafina Script", "Akronim", "Aladin", "Aldrich", "Alef", "Alegreya", "Alegreya SC", "Alex Brush", "Alfa Slab One", "Alice", "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almendra", "Almendra Display", "Almendra SC", "Amarante", "Amaranth", "Amatic SC", "Amethysta", "Anaheim", "Andada", "Andika", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Arbutus Slab", "Architects Daughter", "Archivo Black", "Archivo Narrow", "Arimo", "Arizonia", "Armata", "Artifika", "Arvo", "Asap", "Asset", "Astloch", "Asul", "Atomic Age", "Aubrey", "Audiowide", "Autour One", "Average", "Average Sans", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "Bad Script", "Balthazar", "Bangers", "Basic", "Baumans", "Belgrano", "Belleza", "BenchNine", "Bentham", "Berkshire Swash", "Bevan", "Bigelow Rules", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Bitter", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Bubbler One", "Buda", "Buenard", "Butcherman", "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Calligraffitti", "Cambo", "Candal", "Cantarell", "Cantata One", "Cantora One", "Capriola", "Cardo", "Carme", "Carrois Gothic", "Carrois Gothic SC", "Carter One", "Caudex", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chau Philomene One", "Chela One", "Chelsea Market", "Cherry Cream Soda", "Cherry Swash", "Chewy", "Chicle", "Chivo", "Cinzel", "Cinzel Decorative", "Clicker Script", "Coda", "Coda Caption", "Codystar", "Combo", "Comfortaa", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Courgette", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Text", "Croissant One", "Crushed", "Cuprum", "Cutive", "Cutive Mono", "Damion", "Dancing Script", "Dawning of a New Day", "Days One", "Delius", "Delius Swash Caps", "Delius Unicase", "Della Respira", "Denk One", "Devonshire", "Didact Gothic", "Diplomata", "Diplomata SC", "Domine", "Donegal One", "Doppio One", "Dorsa", "Dosis", "Dr Sugiyama", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Duru Sans", "Dynalight", "Eagle Lake", "Eater", "EB Garamond", "Economica", "Electrolize", "Elsie", "Elsie Swash Caps", "Emblema One", "Emilys Candy", "Engagement", "Englebert", "Enriqueta", "Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Expletus Sans", "Fanwood Text", "Fascinate", "Fascinate Inline", "Faster One", "Fauna One", "Federant", "Federo", "Felipa", "Fenix", "Finger Paint", "Fjalla One", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Freckle Face", "Fredericka the Great", "Fredoka One", "Fresca", "Frijole", "Fruktur", "Fugaz One", "Gabriela", "Gafata", "Galdeano", "Galindo", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One", "GFS Didot", "GFS Neohellenic", "Gilda Display", "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Gorditas", "Goudy Bookletter 1911", "Graduate", "Grand Hotel", "Gravitas One", "Great Vibes", "Griffy", "Gruppo", "Gudea", "Habibi", "Hammersmith One", "Hanalei", "Hanalei Fill", "Handlee", "Happy Monkey", "Headland One", "Henny Penny", "Herr Von Muellerhoff", "Holtwood One SC", "Homemade Apple", "Homenaje", "Iceberg", "Iceland", "IM Fell Double Pica", "IM Fell Double Pica SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika", "Irish Grover", "Istok Web", "Italiana", "Italianno", "Jacques Francois", "Jacques Francois Shadow", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Josefin Sans", "Josefin Slab", "Joti One", "Judson", "Julee", "Julius Sans One", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kameron", "Karla", "Kaushan Script", "Kavoon", "Keania One", "Kelly Slab", "Kenia", "Kite One", "Knewave", "Kotta One", "Kranky", "Kreon", "Kristi", "Krona One", "La Belle Aurore", "Lancelot", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton", "Lemon", "Libre Baskerville", "Life Savers", "Lilita One", "Lily Script One", "Limelight", "Linden Hill", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Lusitana", "Lustria", "Macondo", "Macondo Swash Caps", "Magra", "Maiden Orange", "Mako", "Marcellus", "Marcellus SC", "Marck Script", "Margarine", "Marko One", "Marmelad", "Marvel", "Mate", "Mate SC", "Maven Pro", "McLaren", "Meddon", "MedievalSharp", "Medula One", "Megrim", "Meie Script", "Merienda", "Merienda One", "Merriweather", "Merriweather Sans", "Metal Mania", "Metamorphous", "Metrophobic", "Michroma", "Milonga", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Molengo", "Molle", "Monda", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Montserrat Alternates", "Montserrat Subrayada", "Mountains of Christmas", "Mouse Memoirs", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Muli", "Mystery Quest", "Neucha", "Neuton", "New Rocker", "News Cycle", "Niconne", "Nixie One", "Nobile", "Norican", "Nosifer", "Nothing You Could Do", "Noticia Text", "Noto Sans", "Noto Serif", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Numans", "Nunito", "Offside", "Old Standard TT", "Oldenburg", "Oleo Script", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Orbitron", "Oregano", "Orienta", "Original Surfer", "Oswald", "Over the Rainbow", "Overlock", "Overlock SC", "Ovo", "Oxygen", "Oxygen Mono", "Pacifico", "Paprika", "Parisienne", "Passero One", "Passion One", "Pathway Gothic One", "Patrick Hand", "Patrick Hand SC", "Patua One", "Paytone One", "Peralta", "Permanent Marker", "Petit Formal Script", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Pirata One", "Plaster", "Play", "Playball", "Playfair Display", "Playfair Display SC", "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Poppins", "Pontano Sans", "Port Lligat Sans", "Port Lligat Slab", "Prata", "Press Start 2P", "Princess Sofia", "Prociono", "Prosto One", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif", "PT Serif Caption", "Puritan", "Purple Purse", "Quando", "Quantico", "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Quintessential", "Qwigley", "Racing Sans One", "Radley", "Raleway", "Raleway Dots", "Rambla", "Rammetto One", "Ranchers", "Rancho", "Rationale", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Risque", "Roboto", "Roboto Condensed", "Roboto Slab", "Rochester", "Rock Salt", "Rokkitt", "Romanesco", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Ruda", "Rufina", "Ruge Boogie", "Ruluko", "Rum Raisin", "Ruslan Display", "Russo One", "Ruthie", "Rye", "Sacramento", "Sail", "Salsa", "Sanchez", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Scada", "Schoolbell", "Seaweed Script", "Sevillana", "Seymour One", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Share Tech", "Share Tech Mono", "Shojumaru", "Short Stack", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Sintony", "Sirin Stencil", "Six Caps", "Skranji", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Snowburst One", "Sofadi One", "Sofia", "Sonsie One", "Sorts Mill Goudy", "Source Code Pro", "Source Sans Pro", "Special Elite", "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Stalemate", "Stalinist One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded", "Stoke", "Strait", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Syncopate", "Tangerine", "Tauri", "Telex", "Tenor Sans", "Text Me One", "The Girl Next Door", "Tienne", "Tinos", "Titan One", "Titillium Web", "Trade Winds", "Trocchi", "Trochut", "Trykker", "Tulpen One", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua", "Underdog", "Unica One", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "Vampiro One", "Varela", "Varela Round", "Vast Shadow", "Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Voltaire", "VT323", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Warnes", "Wellfleet", "Wendy One", "Wire One", "Yanone Kaffeesatz", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada" );
	$dslc_should_filter = true;

	/**
	 * Include all the files
	 */

	include DS_LIVE_COMPOSER_ABS . '/includes/editing-screen.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/other-functions.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/css-generation/css-for-modules.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/functions.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/display-functions.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/editorinterface.class.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/row-system/init.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/ajax.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/shortcodes.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/scripts.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/post-options-framework/post-options-framework.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/plugin-options-framework.php';
	include DSLC_ST_FRAMEWORK_ABS . '/single-templates-framework.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/archive-templates.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/styling-presets.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/header-footer.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/search-filter.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/post-templates.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/other.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/options.extension.class.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/upgrade.class.php';

	$cap_page = dslc_get_option( 'lc_min_capability_page', 'dslc_plugin_options_access_control' );
	if ( ! $cap_page ) $cap_page = 'publish_posts';
	define( 'DS_LIVE_COMPOSER_CAPABILITY', $cap_page );
	define( 'DS_LIVE_COMPOSER_CAPABILITY_SAVE', $cap_page );

	/**
	 * Include Modules
	 */
	include DS_LIVE_COMPOSER_ABS . '/includes/class.module.php';

	/**
	 * Tutorials disabled by default
	 *
	 * Use the next call to activate tutorials form your theme
	 * add_filter( 'dslc_tutorials', '__return_true' );
	 *
	 * @since 1.0.7
	 */
	function dslc_tutorials_load() {
		$dslc_tutorials = false;
		if ( apply_filters( 'dslc_tutorials', $dslc_tutorials ) ) {
			include DS_LIVE_COMPOSER_ABS . '/includes/tutorials/tutorial.php';
		}
	}
	add_action( 'after_setup_theme', 'dslc_tutorials_load' );

endif; // ! defined( 'DS_LIVE_COMPOSER_VER' )

/**
 * On plugin activation check if there is lite version
 * or previous generation of the plugin installed.
 * If found, disable these "unwanted" versions of LC.
 *
 * @return void
 */
function dslc_disable_old_plugin() {

	if ( stristr( __FILE__ , 'live-composer-page-builder/') ) {

		/**
		 * Deactivate the old version of Live Composer.
		 * New version is live-composer-page-builder/ds-live-composer.php
		 */
		$old_lc = 'ds-live-composer/ds-live-composer.php';
		if ( is_plugin_active( $old_lc ) ) {
			deactivate_plugins( $old_lc );
		}

		/* Deactivate lite version of the Live Composer */
		$lc_lite = 'live-composer-lite/lite-ds-live-composer.php';
		if ( is_plugin_active( $lc_lite ) ) {
			deactivate_plugins( $lc_lite );
		}
	}
}
register_activation_hook( __FILE__, 'dslc_disable_old_plugin' );

/**
 * Function redirects to the 'Welcome Screen' on plugin activation.
 * Theme developers we have 'dslc_show_welcome_screen' filter for you
 * to make it possible to disable this behavior from the theme.
 *
 * @param string $plugin Full path to the plugin that WP just activated.
 * @return void
 */
function lc_welcome( $plugin ) {

	if ( plugin_basename( __FILE__ ) === $plugin ) {
		// Make Welcome screen optional for the theme developers.
		$show_welcome_screen = true;
		if ( ! apply_filters( 'dslc_show_welcome_screen', $show_welcome_screen ) ) {
			return;
		}

		// Bail if activating from network, or bulk.
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) || isset( $_GET['tgmpa-activate'] ) ) {
			return;
		}

		wp_safe_redirect( admin_url( 'admin.php?page=dslc_plugin_options#dslc-top' ) );
		exit; // ! important to keep this exit line
		// Function wp_redirect() does not exit automatically and should almost always be followed by exit.
	}

}
add_action( 'activated_plugin', 'lc_welcome' );

dslc_load_modules( DS_LIVE_COMPOSER_ABS . '/modules', 'module.php' );
DSLC_Upgrade::init();
