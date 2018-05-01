<?php
/**
 * Plugin Name: Page Builder: Live Composer - drag and drop website builder (visual front end site editor)
 * Plugin URI: https://www.livecomposerplugin.com
 * Description: Front-end page builder for WordPress with drag and drop editing. Build PRO responsive websites and landing pages. Visually customize any page element.
 * Author: Live Composer Team
 * Version: 1.3.15
 * Author URI: https://livecomposerplugin.com
 * License: GPL3
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
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

// Do not allow different versions of Live Composer to run at the same time!
if ( ! defined( 'DS_LIVE_COMPOSER_VER' ) && version_compare( PHP_VERSION, '5.3.0', '>' ) ) :

	/**
	 * Constants
	 */

	define( 'DS_LIVE_COMPOSER_VER', '1.3.15' );

	define( 'DS_LIVE_COMPOSER_SHORTNAME', __( 'Live Composer', 'live-composer-page-builder' ) );
	define( 'DS_LIVE_COMPOSER_BASENAME', plugin_basename( __FILE__ ) );
	define( 'DS_LIVE_COMPOSER_URL', plugin_dir_url( __FILE__ ) );
	define( 'DS_LIVE_COMPOSER_DIR_NAME', dirname( plugin_basename( __FILE__ ) ) );
	define( 'DS_LIVE_COMPOSER_ABS', dirname( __FILE__ ) );
	define( 'DS_LIVE_COMPOSER_DEV_MODE', false ); // Used by theme/plugin developers only.

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
	$dslc_var_icon_fonts = array(); // Will hold available icons array.

	$dslc_css_fonts = '';
	$dslc_css_style = '';


	/**
	 * Devs, please don't change global $dslc_regular_fonts
	 * and $dslc_all_googlefonts_array arrays.
	 * They will be removed soon!
	 *
	 * Use add_filter( 'dslc_available_fonts', 'yourfunction' )
	 * for any fonts manipulations.
	 */
	$dslc_regular_fonts = array( 'Georgia', 'Times', 'Arial', 'Lucida Sans Unicode', 'Tahoma', 'Trebuchet MS', 'Verdana', 'Helvetica' );
	$dslc_all_googlefonts_array = array( 'ABeeZee', 'Abel', 'Abhaya Libre', 'Abril Fatface', 'Aclonica', 'Acme', 'Actor', 'Adamina', 'Advent Pro', 'Aguafina Script', 'Akronim', 'Aladin', 'Aldrich', 'Alef', 'Alegreya', 'Alegreya SC', 'Alegreya Sans', 'Alegreya Sans SC', 'Alex Brush', 'Alfa Slab One', 'Alice', 'Alike', 'Alike Angular', 'Allan', 'Allerta', 'Allerta Stencil', 'Allura', 'Almendra', 'Almendra Display', 'Almendra SC', 'Amarante', 'Amaranth', 'Amatic SC', 'Amatica SC', 'Amethysta', 'Amiko', 'Amiri', 'Amita', 'Anaheim', 'Andada', 'Andika', 'Angkor', 'Annie Use Your Telescope', 'Anonymous Pro', 'Antic', 'Antic Didone', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo Black', 'Archivo Narrow', 'Aref Ruqaa', 'Arima Madurai', 'Arimo', 'Arizonia', 'Armata', 'Arsenal', 'Artifika', 'Arvo', 'Arya', 'Asap', 'Asar', 'Asset', 'Assistant', 'Astloch', 'Asul', 'Athiti', 'Atma', 'Atomic Age', 'Aubrey', 'Audiowide', 'Autour One', 'Average', 'Average Sans', 'Averia Gruesa Libre', 'Averia Libre', 'Averia Sans Libre', 'Averia Serif Libre', 'Bad Script', 'Bahiana', 'Baloo', 'Baloo Bhai', 'Baloo Bhaina', 'Baloo Chettan', 'Baloo Da', 'Baloo Paaji', 'Baloo Tamma', 'Baloo Thambi', 'Balthazar', 'Bangers', 'Barrio', 'Basic', 'Battambang', 'Baumans', 'Bayon', 'Belgrano', 'Belleza', 'BenchNine', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One', 'Bilbo', 'Bilbo Swash Caps', 'BioRhyme', 'BioRhyme Expanded', 'Biryani', 'Bitter', 'Black Ops One', 'Bokor', 'Bonbon', 'Boogaloo', 'Bowlby One', 'Bowlby One SC', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buda', 'Buenard', 'Bungee', 'Bungee Hairline', 'Bungee Inline', 'Bungee Outline', 'Bungee Shade', 'Butcherman', 'Butterfly Kids', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Cairo', 'Calligraffitti', 'Cambay', 'Cambo', 'Candal', 'Cantarell', 'Cantata One', 'Cantora One', 'Capriola', 'Cardo', 'Carme', 'Carrois Gothic', 'Carrois Gothic SC', 'Carter One', 'Catamaran', 'Caudex', 'Caveat', 'Caveat Brush', 'Cedarville Cursive', 'Ceviche One', 'Changa', 'Changa One', 'Chango', 'Chathura', 'Chau Philomene One', 'Chela One', 'Chelsea Market', 'Chenla', 'Cherry Cream Soda', 'Cherry Swash', 'Chewy', 'Chicle', 'Chivo', 'Chonburi', 'Cinzel', 'Cinzel Decorative', 'Clicker Script', 'Coda', 'Coda Caption', 'Codystar', 'Coiny', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Condiment', 'Content', 'Contrail One', 'Convergence', 'Cookie', 'Copse', 'Corben', 'Cormorant', 'Cormorant Garamond', 'Cormorant Infant', 'Cormorant SC', 'Cormorant Unicase', 'Cormorant Upright', 'Courgette', 'Cousine', 'Coustard', 'Covered By Your Grace', 'Crafty Girls', 'Creepster', 'Crete Round', 'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 'Damion', 'Dancing Script', 'Dangrek', 'David Libre', 'Dawning of a New Day', 'Days One', 'Dekko', 'Delius', 'Delius Swash Caps', 'Delius Unicase', 'Della Respira', 'Denk One', 'Devonshire', 'Dhurjati', 'Didact Gothic', 'Diplomata', 'Diplomata SC', 'Domine', 'Donegal One', 'Doppio One', 'Dorsa', 'Dosis', 'Dr Sugiyama', 'Droid Sans', 'Droid Sans Mono', 'Droid Serif', 'Duru Sans', 'Dynalight', 'EB Garamond', 'Eagle Lake', 'Eater', 'Economica', 'Eczar', 'Ek Mukta', 'El Messiri', 'Electrolize', 'Elsie', 'Elsie Swash Caps', 'Emblema One', 'Emilys Candy', 'Engagement', 'Englebert', 'Enriqueta', 'Erica One', 'Esteban', 'Euphoria Script', 'Ewert', 'Exo', 'Exo 2', 'Expletus Sans', 'Fanwood Text', 'Farsan', 'Fascinate', 'Fascinate Inline', 'Faster One', 'Fasthand', 'Fauna One', 'Federant', 'Federo', 'Felipa', 'Fenix', 'Finger Paint', 'Fira Mono', 'Fira Sans', 'Fira Sans Condensed', 'Fira Sans Extra Condensed', 'Fjalla One', 'Fjord One', 'Flamenco', 'Flavors', 'Fondamento', 'Fontdiner Swanky', 'Forum', 'Francois One', 'Frank Ruhl Libre', 'Freckle Face', 'Fredericka the Great', 'Fredoka One', 'Freehand', 'Fresca', 'Frijole', 'Fruktur', 'Fugaz One', 'GFS Didot', 'GFS Neohellenic', 'Gabriela', 'Gafata', 'Galada', 'Galdeano', 'Galindo', 'Gentium Basic', 'Gentium Book Basic', 'Geo', 'Geostar', 'Geostar Fill', 'Germania One', 'Gidugu', 'Gilda Display', 'Give You Glory', 'Glass Antiqua', 'Glegoo', 'Gloria Hallelujah', 'Goblin One', 'Gochi Hand', 'Gorditas', 'Goudy Bookletter 1911', 'Graduate', 'Grand Hotel', 'Gravitas One', 'Great Vibes', 'Griffy', 'Gruppo', 'Gudea', 'Gurajada', 'Habibi', 'Halant', 'Hammersmith One', 'Hanalei', 'Hanalei Fill', 'Handlee', 'Hanuman', 'Happy Monkey', 'Harmattan', 'Headland One', 'Heebo', 'Henny Penny', 'Herr Von Muellerhoff', 'Hind', 'Hind Guntur', 'Hind Madurai', 'Hind Siliguri', 'Hind Vadodara', 'Holtwood One SC', 'Homemade Apple', 'Homenaje', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica', 'IM Fell Double Pica SC', 'IM Fell English', 'IM Fell English SC', 'IM Fell French Canon', 'IM Fell French Canon SC', 'IM Fell Great Primer', 'IM Fell Great Primer SC', 'Iceberg', 'Iceland', 'Imprima', 'Inconsolata', 'Inder', 'Indie Flower', 'Inika', 'Inknut Antiqua', 'Irish Grover', 'Istok Web', 'Italiana', 'Italianno', 'Itim', 'Jacques Francois', 'Jacques Francois Shadow', 'Jaldi', 'Jim Nightshade', 'Jockey One', 'Jolly Lodger', 'Jomhuria', 'Josefin Sans', 'Josefin Slab', 'Joti One', 'Judson', 'Julee', 'Julius Sans One', 'Junge', 'Jura', 'Just Another Hand', 'Just Me Again Down Here', 'Kadwa', 'Kalam', 'Kameron', 'Kanit', 'Kantumruy', 'Karla', 'Karma', 'Katibeh', 'Kaushan Script', 'Kavivanar', 'Kavoon', 'Kdam Thmor', 'Keania One', 'Kelly Slab', 'Kenia', 'Khand', 'Khmer', 'Khula', 'Kite One', 'Knewave', 'Kotta One', 'Koulen', 'Kranky', 'Kreon', 'Kristi', 'Krona One', 'Kumar One', 'Kumar One Outline', 'Kurale', 'La Belle Aurore', 'Laila', 'Lakki Reddy', 'Lalezar', 'Lancelot', 'Lateef', 'Lato', 'League Script', 'Leckerli One', 'Ledger', 'Lekton', 'Lemon', 'Lemonada', 'Libre Baskerville', 'Libre Franklin', 'Life Savers', 'Lilita One', 'Lily Script One', 'Limelight', 'Linden Hill', 'Lobster', 'Lobster Two', 'Londrina Outline', 'Londrina Shadow', 'Londrina Sketch', 'Londrina Solid', 'Lora', 'Love Ya Like A Sister', 'Loved by the King', 'Lovers Quarrel', 'Luckiest Guy', 'Lusitana', 'Lustria', 'Macondo', 'Macondo Swash Caps', 'Mada', 'Magra', 'Maiden Orange', 'Maitree', 'Mako', 'Mallanna', 'Mandali', 'Marcellus', 'Marcellus SC', 'Marck Script', 'Margarine', 'Marko One', 'Marmelad', 'Martel', 'Martel Sans', 'Marvel', 'Mate', 'Mate SC', 'Maven Pro', 'McLaren', 'Meddon', 'MedievalSharp', 'Medula One', 'Meera Inimai', 'Megrim', 'Meie Script', 'Merienda', 'Merienda One', 'Merriweather', 'Merriweather Sans', 'Metal', 'Metal Mania', 'Metamorphous', 'Metrophobic', 'Michroma', 'Milonga', 'Miltonian', 'Miltonian Tattoo', 'Miniver', 'Miriam Libre', 'Mirza', 'Miss Fajardose', 'Mitr', 'Modak', 'Modern Antiqua', 'Mogra', 'Molengo', 'Molle', 'Monda', 'Monofett', 'Monoton', 'Monsieur La Doulaise', 'Montaga', 'Montez', 'Montserrat', 'Montserrat Alternates', 'Montserrat Subrayada', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Mouse Memoirs', 'Mr Bedfort', 'Mr Dafoe', 'Mr De Haviland', 'Mrs Saint Delafield', 'Mrs Sheppards', 'Mukta Vaani', 'Muli', 'Mystery Quest', 'NTR', 'Neucha', 'Neuton', 'New Rocker', 'News Cycle', 'Niconne', 'Nixie One', 'Nobile', 'Nokora', 'Norican', 'Nosifer', 'Nothing You Could Do', 'Noticia Text', 'Noto Sans', 'Noto Serif', 'Nova Cut', 'Nova Flat', 'Nova Mono', 'Nova Oval', 'Nova Round', 'Nova Script', 'Nova Slim', 'Nova Square', 'Numans', 'Nunito', 'Nunito Sans', 'Odor Mean Chey', 'Offside', 'Old Standard TT', 'Oldenburg', 'Oleo Script', 'Oleo Script Swash Caps', 'Open Sans', 'Open Sans Condensed', 'Oranienbaum', 'Orbitron', 'Oregano', 'Orienta', 'Original Surfer', 'Oswald', 'Over the Rainbow', 'Overlock', 'Overlock SC', 'Overpass', 'Overpass Mono', 'Ovo', 'Oxygen', 'Oxygen Mono', 'PT Mono', 'PT Sans', 'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption', 'Pacifico', 'Padauk', 'Palanquin', 'Palanquin Dark', 'Pangolin', 'Paprika', 'Parisienne', 'Passero One', 'Passion One', 'Pathway Gothic One', 'Patrick Hand', 'Patrick Hand SC', 'Pattaya', 'Patua One', 'Pavanam', 'Paytone One', 'Peddana', 'Peralta', 'Permanent Marker', 'Petit Formal Script', 'Petrona', 'Philosopher', 'Piedra', 'Pinyon Script', 'Pirata One', 'Plaster', 'Play', 'Playball', 'Playfair Display', 'Playfair Display SC', 'Podkova', 'Poiret One', 'Poller One', 'Poly', 'Pompiere', 'Pontano Sans', 'Poppins', 'Port Lligat Sans', 'Port Lligat Slab', 'Pragati Narrow', 'Prata', 'Preahvihear', 'Press Start 2P', 'Pridi', 'Princess Sofia', 'Prociono', 'Prompt', 'Prosto One', 'Proza Libre', 'Puritan', 'Purple Purse', 'Quando', 'Quantico', 'Quattrocento', 'Quattrocento Sans', 'Questrial', 'Quicksand', 'Quintessential', 'Qwigley', 'Racing Sans One', 'Radley', 'Rajdhani', 'Rakkas', 'Raleway', 'Raleway Dots', 'Ramabhadra', 'Ramaraja', 'Rambla', 'Rammetto One', 'Ranchers', 'Rancho', 'Ranga', 'Rasa', 'Rationale', 'Ravi Prakash', 'Redressed', 'Reem Kufi', 'Reenie Beanie', 'Revalia', 'Rhodium Libre', 'Ribeye', 'Ribeye Marrow', 'Righteous', 'Risque', 'Roboto', 'Roboto Condensed', 'Roboto Mono', 'Roboto Slab', 'Rochester', 'Rock Salt', 'Rokkitt', 'Romanesco', 'Ropa Sans', 'Rosario', 'Rosarivo', 'Rouge Script', 'Rozha One', 'Rubik', 'Rubik Mono One', 'Ruda', 'Rufina', 'Ruge Boogie', 'Ruluko', 'Rum Raisin', 'Ruslan Display', 'Russo One', 'Ruthie', 'Rye', 'Sacramento', 'Sahitya', 'Sail', 'Salsa', 'Sanchez', 'Sancreek', 'Sansita', 'Sarala', 'Sarina', 'Sarpanch', 'Satisfy', 'Scada', 'Scheherazade', 'Schoolbell', 'Scope One', 'Seaweed Script', 'Secular One', 'Sevillana', 'Seymour One', 'Shadows Into Light', 'Shadows Into Light Two', 'Shanti', 'Share', 'Share Tech', 'Share Tech Mono', 'Shojumaru', 'Short Stack', 'Shrikhand', 'Siemreap', 'Sigmar One', 'Signika', 'Signika Negative', 'Simonetta', 'Sintony', 'Sirin Stencil', 'Six Caps', 'Skranji', 'Slabo 13px', 'Slabo 27px', 'Slackey', 'Smokum', 'Smythe', 'Sniglet', 'Snippet', 'Snowburst One', 'Sofadi One', 'Sofia', 'Sonsie One', 'Sorts Mill Goudy', 'Source Code Pro', 'Source Sans Pro', 'Source Serif Pro', 'Space Mono', 'Special Elite', 'Spicy Rice', 'Spinnaker', 'Spirax', 'Squada One', 'Sree Krushnadevaraya', 'Sriracha', 'Stalemate', 'Stalinist One', 'Stardos Stencil', 'Stint Ultra Condensed', 'Stint Ultra Expanded', 'Stoke', 'Strait', 'Sue Ellen Francisco', 'Suez One', 'Sumana', 'Sunshiney', 'Supermercado One', 'Sura', 'Suranna', 'Suravaram', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tangerine', 'Taprom', 'Tauri', 'Taviraj', 'Teko', 'Telex', 'Tenali Ramakrishna', 'Tenor Sans', 'Text Me One', 'The Girl Next Door', 'Tienne', 'Tillana', 'Timmana', 'Tinos', 'Titan One', 'Titillium Web', 'Trade Winds', 'Trirong', 'Trocchi', 'Trochut', 'Trykker', 'Tulpen One', 'Ubuntu', 'Ubuntu Condensed', 'Ubuntu Mono', 'Ultra', 'Uncial Antiqua', 'Underdog', 'Unica One', 'UnifrakturCook', 'UnifrakturMaguntia', 'Unkempt', 'Unlock', 'Unna', 'VT323', 'Vampiro One', 'Varela', 'Varela Round', 'Vast Shadow', 'Vesper Libre', 'Vibur', 'Vidaloka', 'Viga', 'Voces', 'Volkhov', 'Vollkorn', 'Voltaire', 'Waiting for the Sunrise', 'Wallpoet', 'Walter Turncoat', 'Warnes', 'Wellfleet', 'Wendy One', 'Wire One', 'Work Sans', 'Yanone Kaffeesatz', 'Yantramanav', 'Yatra One', 'Yellowtail', 'Yeseva One', 'Yesteryear', 'Yrsa', 'Zeyada' );

	$dslc_available_fonts['regular'] = $dslc_regular_fonts;
	$dslc_available_fonts['google'] = $dslc_all_googlefonts_array;

	// Allow devs to alter available fonts.
	$dslc_available_fonts = apply_filters( 'dslc_available_fonts', $dslc_available_fonts );

	/* This array gets filled with fonts used on the page (temporary storage) */
	$dslc_googlefonts_array = array();


	$dslc_should_filter = true;

	/**
	 * Include all the files
	 */

	include DS_LIVE_COMPOSER_ABS . '/includes/editing-screen.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/other-functions.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/css-generation.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/functions.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/display-functions.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/editorinterface.class.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/row-system/init.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/module-controls.php';
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
	include DS_LIVE_COMPOSER_ABS . '/includes/editor-messages.php';
	include DS_LIVE_COMPOSER_ABS . '/includes/class-dslc-cache.php'; // Simple HTML/CSS caching class.
	include DS_LIVE_COMPOSER_ABS . '/includes/plugin-updates/lc-license-manager.class.php';

	$cap_page = dslc_get_option( 'lc_min_capability_page', 'dslc_plugin_options_access_control' );
	if ( ! $cap_page ) { $cap_page = 'publish_posts';
	}
	define( 'DS_LIVE_COMPOSER_CAPABILITY', $cap_page );
	define( 'DS_LIVE_COMPOSER_CAPABILITY_SAVE', $cap_page );

	/**
	 * Include Modules
	 */
	include DS_LIVE_COMPOSER_ABS . '/includes/class.module.php';

	dslc_load_modules( DS_LIVE_COMPOSER_ABS . '/modules', 'module.php' );
	DSLC_Upgrade::init();

endif; // ! defined( 'DS_LIVE_COMPOSER_VER' )

function dslc_php_version() {
	if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) { ?>
		<div class="notice notice-error">
			<p><?php echo __( 'Live Composer requires PHP version 5.3+. Your version of PHP is 6 years old. The latest version is PHP 7. Please, contact your hosting to upgrade the server.', 'live-composer-page-builder' ); ?></p>
		</div>
	<?php }
}
add_action( 'admin_notices', 'dslc_php_version' );

/**
 * On plugin activation check if there is lite version
 * or previous generation of the plugin installed.
 * If found, disable these "unwanted" versions of LC.
 *
 * @return void
 */
function dslc_disable_old_plugin() {

	if ( stristr( __FILE__ , 'live-composer-page-builder/' ) ) {

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

function dslc_deactivate_plugin() {
	// Deactivate WooCommerce Integration Plugin.
	if ( defined( 'LCWOO_INTEGRATION_PLUGIN_VER' ) && version_compare( LCWOO_INTEGRATION_PLUGIN_VER, '1.2.5', '<=' ) ) {
		$plugins_page_url = admin_url('plugins.php');
		wp_die( 'Please, deactivate <a href="' . esc_attr( $plugins_page_url ) . '">WooCommerce integration for Live Composer</a> plugin first. <br />Sorry for this inconvenience.' );
	}

}
register_deactivation_hook( __FILE__, 'dslc_deactivate_plugin' );

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
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) || isset( $_GET['tgmpa-activate'] ) || isset( $_GET['tgmpa-install'] ) ) {
			return;
		}

		wp_safe_redirect( admin_url( 'admin.php?page=dslc_plugin_options#dslc-top' ) );
		exit; // ! important to keep this exit line
		// Function wp_redirect() does not exit automatically and should almost always be followed by exit.
	}

}
add_action( 'activated_plugin', 'lc_welcome' );