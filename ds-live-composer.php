<?php
/**
 * Plugin Name: Page Builder: Live Composer - drag and drop website builder (visual front end site editor)
 * Plugin URI: https://www.livecomposerplugin.com
 * Description: Front-end page builder for WordPress with drag and drop editing. Build PRO responsive websites and landing pages. Visually customize any page element.
 * Author: Live Composer Team
 * Version: 1.1.3.1
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
	 * ALL THE GLOBAL VARIABLES WILL BE REMOVED.
	 * DO NOT USE IT IN YOUR PLUGINS OR THEMES!
	 */

	$dslc_var_image_option_bckp = array();
	$dslc_var_row_options = array();

	/**
	 * Is Live Composer currently active?
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

endif; // ! defined( 'DS_LIVE_COMPOSER_VER' )


if ( ! class_exists( 'Live_Composer' ) ) :
	/**
	 * Main Live_Composer Class.
	 *
	 * Code inspiration: Easy Digital Downloads (GPL)
	 *
	 * @since 1.1.4
	 */
	final class Live_Composer {
		/** Singleton *************************************************************/
		/**
		 * Instance
		 *
		 * @var Live_Composer The one true Live_Composer
		 * @since 1.1.4
		 */
		private static $instance;

		/**
		 * LC Custom Post Type Templates Engine
		 *
		 * @var object|LC_CPT_Templates
		 * @since 1.1.4
		 */
		public $cpt_templates;

		/**
		 * LC Plugin Options
		 *
		 * @var object|LC_Plugin_Options
		 * @since 1.1.4
		 */
		public $plugin_options;

		/**
		 * LC Plugin Version
		 *
		 * @var object|LC_Upgrade
		 * @since 1.1.4
		 */
		public $version;

		/**
		 * LC Plugin Sidebar Icon (in WP Admin)
		 * A base64 URL for the svg for use in the menu.
		 *
		 * @var string
		 * @since 1.1.4
		 */
		public $sidebar_icon;

		/**
		 * Main Live_Composer Instance.
		 *
		 * Insures that only one instance of Live_Composer exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.1.4
		 * @static
		 * @static var $instance
		 * @return object|Live_Composer The one true Live_Composer
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Live_Composer ) ) {

				self::$instance = new Live_Composer;

				// @todo: move the calls below out of instance() and class.

				// Setup the constants needed.
				self::$instance->setup_constants();

				// Disable old and free verions of LC.
				register_activation_hook( __FILE__, array( self::$instance, 'disable_old_versions' ) );

				// Load the language files.
				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

				// Before including any code we need to make sure the plugin options are ready.
				require_once DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/plugin-options-framework.php';
				self::$instance->plugin_options = new LC_Plugin_Options();

				// Include the required files.
				self::$instance->includes();

				require_once DSLC_ST_FRAMEWORK_ABS . '/inc/class.lc-cpt-templates.php';
				require_once DS_LIVE_COMPOSER_ABS . '/includes/class.lc-upgrade.php';
				self::$instance->cpt_templates  = new LC_CPT_Templates();
				self::$instance->version        = new LC_Upgrade();

				self::$instance->sidebar_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9Ii0yOTcgMzg4IDE3IDE3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IC0yOTcgMzg4IDE3IDE3OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6IzlFQTNBODt9Cjwvc3R5bGU+Cjx0aXRsZT5TbGljZSAxPC90aXRsZT4KPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0tMjg0LjIsMzg4aC05LjhjLTEuNiwwLTMsMS4zLTMsM3Y4LjljMCwxLjYsMS4zLDMsMywzaDEuNXYtMmgtMS41Yy0wLjYsMC0xLTAuNC0xLTFWMzkxYzAtMC41LDAuNC0xLDEtMWg5LjgKCWMwLjUsMCwxLDAuNCwxLDF2Mi4zaDJWMzkxQy0yODEuMiwzODkuMy0yODIuNSwzODgtMjg0LjIsMzg4eiIvPgo8ZyBpZD0iR3JvdXAtMTgiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMuNTMxMjUwLCA1LjI5Njg3NSkiPgoJPHBhdGggaWQ9IkNvbWJpbmVkLVNoYXBlIiBjbGFzcz0ic3QwIiBkPSJNLTI5Mi4yLDM5OS42di0xLjJjMCwwLTEuOC0yLjQtMi42LTMuM2MtMC44LTAuOS0xLjItMi40LDAtM2MxLjItMC42LDEuOCwxLjIsMS44LDEuMgoJCXMtMS43LTMuNywwLjItNGMxLjMtMC4yLDEuNiwxLjYsMS42LDEuNnMtMC4xLTIsMS40LTJjMS41LDAsMS41LDIsMS41LDJzMC0xLjgsMS4yLTEuOGMxLjIsMCwxLjQsMS41LDEuNCwxLjVzLTAuMi0wLjksMC45LTAuOQoJCWMwLjksMCwxLjEsMC42LDEuMiwxLjdjMCwwLjQtMC4xLDEuNS0wLjEsMmMwLDMtMiwzLjctMiwzLjd2Mi40aC0xLjJjMCwwLTAuOC0xLjItMS4yLTEuMnMtMC42LDEuMi0wLjYsMS4ySC0yOTIuMnogTS0yOTEuNSwzOTMuMQoJCXYyLjVjMCwwLjMsMC4yLDAuNSwwLjUsMC41YzAuMywwLDAuNS0wLjIsMC41LTAuNXYtMi41YzAtMC4zLTAuMi0wLjUtMC41LTAuNUMtMjkxLjIsMzkyLjYtMjkxLjUsMzkyLjgtMjkxLjUsMzkzLjF6CgkJIE0tMjg5LjUsMzkzLjF2M2MwLDAuMywwLjIsMC41LDAuNSwwLjVjMC4zLDAsMC41LTAuMiwwLjUtMC41di0zYzAtMC4zLTAuMi0wLjUtMC41LTAuNUMtMjg5LjMsMzkyLjYtMjg5LjUsMzkyLjgtMjg5LjUsMzkzLjF6CgkJIE0tMjg3LjUsMzkzLjF2Mi41YzAsMC4zLDAuMiwwLjUsMC41LDAuNWMwLjMsMCwwLjUtMC4yLDAuNS0wLjV2LTIuNWMwLTAuMy0wLjItMC41LTAuNS0wLjVDLTI4Ny4yLDM5Mi42LTI4Ny41LDM5Mi45LTI4Ny41LDM5My4xCgkJeiIvPgo8L2c+Cjwvc3ZnPgo=';

				// Show welcome screen after plugin activated.
				add_action( 'activated_plugin', array( self::$instance, 'redirect_to_welcome' ) );

				// Load Tutorials.
				add_action( 'after_setup_theme', array( self::$instance, 'load_tutorials' ) );
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.1.4
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'live-composer-page-builder' ), '1.6' );
		}
		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.1.4
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'live-composer-page-builder' ), '1.1.4' );
		}
		/**
		 * Setup plugin constants.
		 *
		 * @access private
		 * @since 1.1.4
		 * @return void
		 */
		private function setup_constants() {

			// Plugin version.
			if ( ! defined( 'DS_LIVE_COMPOSER_VER' ) ) {
				define( 'DS_LIVE_COMPOSER_VER', '1.1.3.1' );
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_SHORTNAME' ) ) {
				define( 'DS_LIVE_COMPOSER_SHORTNAME', __( 'Live Composer', 'live-composer-page-builder' ) );
			}

			// Plugin Folder Path.
			if ( ! defined( 'DS_LIVE_COMPOSER_ABS' ) ) {
				define( 'DS_LIVE_COMPOSER_ABS', dirname( __FILE__ ) );
			}
			// Plugin Folder URL.
			if ( ! defined( 'DS_LIVE_COMPOSER_URL' ) ) {
				define( 'DS_LIVE_COMPOSER_URL', plugin_dir_url( __FILE__ ) );
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_BASENAME' ) ) {
				define( 'DS_LIVE_COMPOSER_BASENAME', plugin_basename( __FILE__ ) );
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_DIR_NAME' ) ) {
				define( 'DS_LIVE_COMPOSER_DIR_NAME', dirname( plugin_basename( __FILE__ ) ) );
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_DEV_MODE' ) ) {
				define( 'DS_LIVE_COMPOSER_DEV_MODE', false );
			}

			if ( ! defined( 'DSLC_PO_FRAMEWORK_ABS' ) ) {
				define( 'DSLC_PO_FRAMEWORK_ABS', DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework' );
			}

			if ( ! defined( 'DSLC_ST_FRAMEWORK_ABS' ) ) {
				define( 'DSLC_ST_FRAMEWORK_ABS', DS_LIVE_COMPOSER_ABS . '/includes/single-templates-framework' );
			}

			if ( ! defined( 'DSLC_ROW_SYSTEM_ABS' ) ) {
				define( 'DSLC_ROW_SYSTEM_ABS', DS_LIVE_COMPOSER_ABS . '/includes/row-system' );
			}
		}


		/**
		 * Include required files.
		 *
		 * @access private
		 * @since 1.1.4
		 * @return void
		 */
		private function includes() {
			require_once DS_LIVE_COMPOSER_ABS . '/includes/editing-screen.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/other-functions.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/css-generation/css-for-modules.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/functions.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/display-functions.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/editorinterface.class.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/row-system/init.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/ajax.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/shortcodes.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/scripts.php';
			// require_once DS_LIVE_COMPOSER_ABS . '/includes/options.extension.class.php'; // @todo: needs code refactoring.
			require_once DS_LIVE_COMPOSER_ABS . '/includes/post-options-framework/post-options-framework.php';
			// require_once DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/plugin-options-framework.php';
			require_once DSLC_ST_FRAMEWORK_ABS . '/single-templates-framework.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/archive-templates.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/styling-presets.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/header-footer.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/search-filter.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/post-templates.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/other.php';
			// require_once DS_LIVE_COMPOSER_ABS . '/includes/class.lc-upgrade.php';
			require_once DS_LIVE_COMPOSER_ABS . '/includes/class.module.php';

			// Setup default user rights.
			// $cap_page = dslc_get_option( 'lc_min_capability_page', 'dslc_plugin_options_access_control' );
			$cap_page = false;

			if ( ! $cap_page ) {
				$cap_page = 'publish_posts';
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_CAPABILITY' ) ) {
				define( 'DS_LIVE_COMPOSER_CAPABILITY', $cap_page );
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_CAPABILITY_SAVE' ) ) {
				define( 'DS_LIVE_COMPOSER_CAPABILITY_SAVE', $cap_page );
			}

			dslc_load_modules( DS_LIVE_COMPOSER_ABS . '/modules', 'module.php' );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.1.4
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'live-composer-page-builder', false, DS_LIVE_COMPOSER_DIR_NAME . '/lang/' );
		}

		/**
		 * On plugin activation check if there is
		 * lite version or previous generation of the Live Composer installed.
		 * If found any: disable these "unwanted" versions.
		 *
		 * @access public
		 * @since 1.1.4
		 * @return void
		 */
		public function disable_old_versions() {

			// On Live Composer activation...
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

		/**
		 * Redirects to the 'Welcome Screen' on plugin activation.
		 * Theme developers we have 'dslc_show_welcome_screen' filter for you
		 * to make it possible to disable this behavior from the theme.
		 *
		 * @access public
		 * @since 1.1.4
		 * @return void
		 */
		public function redirect_to_welcome( $plugin ) {

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

		/**
		 * Tutorials disabled by default
		 *
		 * Use the next call to activate tutorials form your theme
		 * add_filter( 'dslc_tutorials', '__return_true' );
		 *
		 * @access public
		 * @since 1.0.7
		 * @return void
		 */
		public function load_tutorials() {
			$dslc_tutorials = false;
			if ( apply_filters( 'dslc_tutorials', $dslc_tutorials ) ) {
				include DS_LIVE_COMPOSER_ABS . '/includes/tutorials/tutorial.php';
			}
		}
	}

endif; // End if class_exists check.

/**
 * The main function for that returns Live_Composer
 *
 * The main function responsible for returning the one true Live_Composer
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $LC = Live_Composer(); ?>
 *
 * @since 1.1.4
 * @return object|Live_Composer The one true Live_Composer Instance.
 */
function Live_Composer() {
	return Live_Composer::instance();
}

// Get LC Running.
Live_Composer();
