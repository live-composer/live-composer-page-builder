<?php

/**
 * Table of Contents
 *
 * - dslc_load_scripts ( Load CSS and JS files )
 * - dslc_load_admin_scripts ( Load CSS and JS files for the admin )
 * - dslc_load_fonts ( Load Google Fonts )
 */


/**
 * Load CSS and JS files
 *
 * @since 1.0
 */

function dslc_load_scripts() {

	global $dslc_active;

	$translation_array = array( 
		'str_confirm' => __( 'CONFIRM', 'live-composer-page-builder' ),
		'str_ok' => __( 'OK', 'live-composer-page-builder' ),
		'str_import' => __( 'IMPORT', 'live-composer-page-builder' ),
		'str_exit_title' => __( 'You are about to exit Live Composer', 'live-composer-page-builder' ),
		'str_exit_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'live-composer-page-builder' ),
		'str_area_helper_text' => __( 'MODULES AREA', 'live-composer-page-builder' ),
		'str_row_helper_text' => __( 'MODULES ROW', 'live-composer-page-builder' ),
		'str_import_row_title' => __( 'Import Row', 'live-composer-page-builder' ),
		'str_import_row_descr' => __( 'Copy the row export code bellow.', 'live-composer-page-builder' ),
		'str_del_module_title' => __( 'Delete Module', 'live-composer-page-builder' ),
		'str_del_module_descr' => __( 'Are you sure you want to delete this module?', 'live-composer-page-builder' ),
		'str_del_area_title' => __( 'Delete Area/Column', 'live-composer-page-builder' ),
		'str_del_area_descr' => __( 'Are you sure you want to delete this modules area?', 'live-composer-page-builder' ),
		'str_del_row_title' => __( 'Delete Row', 'live-composer-page-builder' ),
		'str_del_row_descr' => __( 'Are you sure you want to delete this row?', 'live-composer-page-builder' ),
		'str_export_row_title' => __( 'Export Row', 'live-composer-page-builder' ),
		'str_export_row_descr' => __( 'The code bellow is the importable code for this row.', 'live-composer-page-builder' ),
		'str_module_curr_edit_title' => __( 'You are currently editing a module', 'live-composer-page-builder' ),
		'str_module_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'live-composer-page-builder' ),
		'str_row_curr_edit_title' => __( 'You are currently editing a modules row', 'live-composer-page-builder' ),
		'str_row_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'live-composer-page-builder' ),
		'str_refresh_title' => __( 'You are about to refresh the page', 'live-composer-page-builder' ),
		'str_refresh_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'live-composer-page-builder' ),
		'str_res_tablet' => __( 'tablet', 'live-composer-page-builder' ),
		'str_res_phone' => __( 'phone', 'live-composer-page-builder' )
	);
	
	// Array of fonts available to be used in LC editor
	$fonts_array = array(
		'regular' => array( "Georgia", "Times", "Arial", "Lucida Sans Unicode", "Tahoma", "Trebuchet MS", "Verdana", "Helvetica" ),
		'google' => array( "ABeeZee","Abel","Abril Fatface","Aclonica","Acme","Actor","Adamina","Advent Pro","Aguafina Script","Akronim","Aladin","Aldrich","Alef","Alegreya","Alegreya SC","Alex Brush","Alfa Slab One","Alice","Alike","Alike Angular","Allan","Allerta","Allerta Stencil","Allura","Almendra","Almendra Display","Almendra SC","Amarante","Amaranth","Amatic SC","Amethysta","Anaheim","Andada","Andika","Annie Use Your Telescope","Anonymous Pro","Antic","Antic Didone","Antic Slab","Anton","Arapey","Arbutus","Arbutus Slab","Architects Daughter","Archivo Black","Archivo Narrow","Arimo","Arizonia","Armata","Artifika","Arvo","Asap","Asset","Astloch","Asul","Atomic Age","Aubrey","Audiowide","Autour One","Average","Average Sans","Averia Gruesa Libre","Averia Libre","Averia Sans Libre","Averia Serif Libre","Bad Script","Balthazar","Bangers","Basic","Baumans","Belgrano","Belleza","BenchNine","Bentham","Berkshire Swash","Bevan","Bigelow Rules","Bigshot One","Bilbo","Bilbo Swash Caps","Bitter","Black Ops One","Bonbon","Boogaloo","Bowlby One","Bowlby One SC","Brawler","Bree Serif","Bubblegum Sans","Bubbler One","Buda","Buenard","Butcherman","Butterfly Kids","Cabin","Cabin Condensed","Cabin Sketch","Caesar Dressing","Cagliostro","Calligraffitti","Cambo","Candal","Cantarell","Cantata One","Cantora One","Capriola","Cardo","Carme","Carrois Gothic","Carrois Gothic SC","Carter One","Caudex","Cedarville Cursive","Ceviche One","Changa One","Chango","Chau Philomene One","Chela One","Chelsea Market","Cherry Cream Soda","Cherry Swash","Chewy","Chicle","Chivo","Cinzel","Cinzel Decorative","Clicker Script","Coda","Coda Caption","Codystar","Combo","Comfortaa","Coming Soon","Concert One","Condiment","Contrail One","Convergence","Cookie","Copse","Corben","Courgette","Cousine","Coustard","Covered By Your Grace","Crafty Girls","Creepster","Crete Round","Crimson Text","Croissant One","Crushed","Cuprum","Cutive","Cutive Mono","Damion","Dancing Script", "Dawning of a New Day","Days One","Delius","Delius Swash Caps","Delius Unicase","Della Respira","Denk One","Devonshire","Didact Gothic","Diplomata","Diplomata SC","Domine","Donegal One","Doppio One","Dorsa","Dosis","Dr Sugiyama","Droid Sans","Droid Sans Mono","Droid Serif","Duru Sans","Dynalight","Eagle Lake","Eater","EB Garamond","Economica","Electrolize","Elsie","Elsie Swash Caps","Emblema One","Emilys Candy","Engagement","Englebert","Enriqueta","Erica One","Esteban","Euphoria Script","Ewert","Exo","Expletus Sans","Fanwood Text","Fascinate","Fascinate Inline","Faster One","Fauna One","Federant","Federo","Felipa","Fenix","Finger Paint","Fjalla One","Fjord One","Flamenco","Flavors","Fondamento","Fontdiner Swanky","Forum","Francois One","Freckle Face","Fredericka the Great","Fredoka One","Fresca","Frijole","Fruktur","Fugaz One","Gabriela","Gafata","Galdeano","Galindo","Gentium Basic","Gentium Book Basic","Geo","Geostar","Geostar Fill","Germania One","GFS Didot","GFS Neohellenic","Gilda Display","Give You Glory","Glass Antiqua","Glegoo","Gloria Hallelujah","Goblin One","Gochi Hand","Gorditas","Goudy Bookletter 1911","Graduate","Grand Hotel","Gravitas One","Great Vibes","Griffy","Gruppo","Gudea","Habibi","Hammersmith One","Hanalei","Hanalei Fill","Handlee","Happy Monkey","Headland One","Henny Penny","Herr Von Muellerhoff","Holtwood One SC","Homemade Apple","Homenaje","Iceberg","Iceland","IM Fell Double Pica","IM Fell Double Pica SC","IM Fell DW Pica","IM Fell DW Pica SC","IM Fell English","IM Fell English SC","IM Fell French Canon","IM Fell French Canon SC","IM Fell Great Primer","IM Fell Great Primer SC","Imprima","Inconsolata","Inder","Indie Flower","Inika","Irish Grover","Istok Web","Italiana","Italianno","Jacques Francois","Jacques Francois Shadow","Jim Nightshade","Jockey One","Jolly Lodger","Josefin Sans","Josefin Slab","Joti One","Judson","Julee","Julius Sans One","Junge","Jura","Just Another Hand","Just Me Again Down Here","Kameron","Karla","Kaushan Script","Kavoon","Keania One","Kelly Slab","Kenia","Kite One","Knewave","Kotta One","Kranky","Kreon","Kristi","Krona One","La Belle Aurore","Lancelot","Lato","League Script","Leckerli One","Ledger","Lekton","Lemon","Libre Baskerville","Life Savers","Lilita One","Lily Script One","Limelight","Linden Hill","Lobster","Lobster Two","Londrina Outline","Londrina Shadow","Londrina Sketch","Londrina Solid","Lora","Love Ya Like A Sister","Loved by the King","Lovers Quarrel","Luckiest Guy","Lusitana","Lustria","Macondo","Macondo Swash Caps","Magra","Maiden Orange","Mako","Marcellus","Marcellus SC","Marck Script","Margarine","Marko One","Marmelad","Marvel","Mate","Mate SC","Maven Pro","McLaren","Meddon","MedievalSharp","Medula One","Megrim","Meie Script","Merienda","Merienda One","Merriweather","Merriweather Sans","Metal Mania","Metamorphous","Metrophobic","Michroma","Milonga","Miltonian","Miltonian Tattoo","Miniver","Miss Fajardose","Modern Antiqua","Molengo","Molle","Monda","Monofett","Monoton","Monsieur La Doulaise","Montaga","Montez","Montserrat","Montserrat Alternates","Montserrat Subrayada","Mountains of Christmas","Mouse Memoirs","Mr Bedfort","Mr Dafoe","Mr De Haviland","Mrs Saint Delafield","Mrs Sheppards","Muli","Mystery Quest","Neucha","Neuton","New Rocker","News Cycle","Niconne","Nixie One","Nobile","Norican","Nosifer","Nothing You Could Do","Noticia Text","Noto Sans","Noto Serif","Nova Cut","Nova Flat","Nova Mono","Nova Oval","Nova Round","Nova Script","Nova Slim","Nova Square","Numans","Nunito","Offside","Old Standard TT","Oldenburg","Oleo Script","Oleo Script Swash Caps","Open Sans","Open Sans Condensed","Oranienbaum","Orbitron","Oregano","Orienta","Original Surfer","Oswald","Over the Rainbow","Overlock","Overlock SC","Ovo","Oxygen","Oxygen Mono","Pacifico","Paprika","Parisienne","Passero One","Passion One","Pathway Gothic One","Patrick Hand","Patrick Hand SC","Patua One","Paytone One","Peralta","Permanent Marker","Petit Formal Script","Petrona","Philosopher","Piedra","Pinyon Script","Pirata One","Plaster","Play","Playball","Playfair Display","Playfair Display SC","Podkova","Poiret One","Poller One","Poly","Pompiere","Pontano Sans","Poppins","Port Lligat Sans","Port Lligat Slab","Prata","Press Start 2P","Princess Sofia","Prociono","Prosto One","PT Mono","PT Sans","PT Sans Caption","PT Sans Narrow","PT Serif","PT Serif Caption","Puritan","Purple Purse","Quando","Quantico","Quattrocento","Quattrocento Sans","Questrial","Quicksand","Quintessential","Qwigley","Racing Sans One","Radley","Raleway","Raleway Dots","Rambla","Rammetto One","Ranchers","Rancho","Rationale","Redressed","Reenie Beanie","Revalia","Ribeye","Ribeye Marrow","Righteous","Risque","Roboto","Roboto Condensed","Roboto Slab","Rochester","Rock Salt","Rokkitt","Romanesco","Ropa Sans","Rosario","Rosarivo","Rouge Script","Ruda","Rufina","Ruge Boogie","Ruluko","Rum Raisin","Ruslan Display","Russo One","Ruthie","Rye","Sacramento","Sail","Salsa","Sanchez","Sancreek","Sansita One","Sarina","Satisfy","Scada","Schoolbell","Seaweed Script","Sevillana","Seymour One","Shadows Into Light","Shadows Into Light Two","Shanti","Share","Share Tech","Share Tech Mono","Shojumaru","Short Stack","Sigmar One","Signika","Signika Negative","Simonetta","Sintony","Sirin Stencil","Six Caps","Skranji","Slackey","Smokum","Smythe","Sniglet","Snippet","Snowburst One","Sofadi One","Sofia","Sonsie One","Sorts Mill Goudy","Source Code Pro","Source Sans Pro","Special Elite","Spicy Rice","Spinnaker","Spirax","Squada One","Stalemate","Stalinist One","Stardos Stencil","Stint Ultra Condensed","Stint Ultra Expanded","Stoke","Strait","Sue Ellen Francisco","Sunshiney","Supermercado One","Swanky and Moo Moo","Syncopate","Tangerine","Tauri","Telex","Tenor Sans","Text Me One","The Girl Next Door","Tienne","Tinos","Titan One","Titillium Web","Trade Winds","Trocchi","Trochut","Trykker","Tulpen One","Ubuntu","Ubuntu Condensed","Ubuntu Mono","Ultra","Uncial Antiqua","Underdog","Unica One","UnifrakturCook","UnifrakturMaguntia","Unkempt","Unlock","Unna","Vampiro One","Varela","Varela Round","Vast Shadow","Vibur","Vidaloka","Viga","Voces","Volkhov","Vollkorn","Voltaire","VT323","Waiting for the Sunrise","Wallpoet","Walter Turncoat","Warnes","Wellfleet","Wendy One","Wire One","Yanone Kaffeesatz","Yellowtail","Yeseva One","Yesteryear","Zeyada" ),
	);
	
	// Allow devs to alter available fonts
	$fonts_array = apply_filters( 'dslc_available_fonts', $fonts_array );

	// Array of icons available to be used
	global $dslc_var_icons;
	
	/**
	 * CSS
	 */

	if ( DS_LIVE_COMPOSER_LOAD_MINIFIED ) {
		wp_enqueue_style( 'dslc-main-css', DS_LIVE_COMPOSER_URL . 'css/main.min.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-font-awesome', DS_LIVE_COMPOSER_URL . 'css/font-awesome.min.css', array(), DS_LIVE_COMPOSER_VER);
		wp_enqueue_style( 'dslc-modules-css', DS_LIVE_COMPOSER_URL . 'css/modules.min.css', array(), DS_LIVE_COMPOSER_VER);
	} else {
		wp_enqueue_style( 'dslc-main-css', DS_LIVE_COMPOSER_URL . 'css/main.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-font-awesome', DS_LIVE_COMPOSER_URL . 'css/font-awesome.css', array(), DS_LIVE_COMPOSER_VER);
		wp_enqueue_style( 'dslc-modules-css', DS_LIVE_COMPOSER_URL . 'css/modules.css', array(), DS_LIVE_COMPOSER_VER);
	}

	wp_enqueue_style( 'dslc-plugins-css', DS_LIVE_COMPOSER_URL . 'css/plugins.css', array(), DS_LIVE_COMPOSER_VER);

	/**
	 * JavaScript
	 */

	wp_enqueue_script( 'dslc-plugins-js', DS_LIVE_COMPOSER_URL . 'js/plugins.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
	wp_enqueue_script( 'wp-mediaelement' );

	if ( DS_LIVE_COMPOSER_LOAD_MINIFIED )
		wp_enqueue_script( 'dslc-main-js', DS_LIVE_COMPOSER_URL . 'js/main.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
	else
		wp_enqueue_script( 'dslc-main-js', DS_LIVE_COMPOSER_URL . 'js/main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

	if ( is_ssl() ) {
		wp_localize_script( 'dslc-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'https' ) ) );
	} else {
		wp_localize_script( 'dslc-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'http' ) ) );
	}
	
	/**
	 * Live Composer Active
	 */

	if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		wp_enqueue_media();
		
		/**
		 * CSS
		 */

		wp_enqueue_style( 'jquery-ui-slider' );
		wp_enqueue_style( 'dslc-builder-main-css', DS_LIVE_COMPOSER_URL . 'css/builder.main.css', array(), DS_LIVE_COMPOSER_VER);
		wp_enqueue_style( 'dslc-builder-plugins-css', DS_LIVE_COMPOSER_URL . 'css/builder.plugins.css', array(), DS_LIVE_COMPOSER_VER);

		/**
		 * JavaScript
		 */

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-effects-core' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'dslc-load-fonts', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js' );
		wp_enqueue_script( 'dslc-builder-plugins-js', DS_LIVE_COMPOSER_URL . 'js/builder.plugins.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

		if ( DS_LIVE_COMPOSER_LOAD_MINIFIED )
			wp_enqueue_script( 'dslc-builder-main-js', DS_LIVE_COMPOSER_URL . 'js/builder.main.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		else
			wp_enqueue_script( 'dslc-builder-main-js', DS_LIVE_COMPOSER_URL . 'js/builder.main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

		if ( is_ssl() ) {
			wp_localize_script( 'dslc-builder-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'https' ) ) );
		} else {
			wp_localize_script( 'dslc-builder-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'http' ) ) );
		}
		wp_localize_script( 'dslc-builder-main-js', 'DSLCString', $translation_array );
		wp_localize_script( 'dslc-builder-main-js', 'DSLCFonts', $fonts_array );
		wp_localize_script( 'dslc-builder-main-js', 'DSLCIcons', $dslc_var_icons );

	}

} add_action( 'wp_enqueue_scripts', 'dslc_load_scripts' );


/**
 * Load CSS and JS files for the admin
 *
 * @since 1.0
 */

function dslc_load_admin_scripts( $hook ) {	

	if ( ( $hook == 'post-new.php' || $hook == 'post.php' ) && DS_LIVE_COMPOSER_LOAD_MINIFIED ) {
		wp_enqueue_script( 'dslc-post-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/js/main.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
		wp_enqueue_style( 'dslc-post-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/css/main.min.css', array(), DS_LIVE_COMPOSER_VER);
	} elseif ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		wp_enqueue_script( 'dslc-post-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/js/main.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
		wp_enqueue_style( 'dslc-post-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/css/main.css', array(), DS_LIVE_COMPOSER_VER);
	}

	if ( strpos( $hook,'dslc_plugin_options') !== false && DS_LIVE_COMPOSER_LOAD_MINIFIED ) {
		wp_enqueue_script( 'dslc-plugin-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/js/main.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-plugin-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/css/main.css', array(), DS_LIVE_COMPOSER_VER);
	} elseif ( strpos( $hook,'dslc_plugin_options') !== false ) {
		wp_enqueue_script( 'dslc-plugin-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/js/main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-plugin-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/css/main.css', array(), DS_LIVE_COMPOSER_VER);
	}

} add_action( 'admin_enqueue_scripts', 'dslc_load_admin_scripts' );


/**
 * Load Google Fonts
 *
 * @since 1.0
 */

function dslc_load_fonts() {

	if ( isset( $_GET['dslc'] ) && $_GET['dslc'] == 'active' ) {

		wp_enqueue_style( 'dslc-gf-oswald', "//fonts.googleapis.com/css?family=Oswald:400,300,700&subset=latin,latin-ext" );
		wp_enqueue_style( 'dslc-gf-opensans', "//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" );
		wp_enqueue_style( 'dslc-gf-roboto', "//fonts.googleapis.com/css?family=Roboto:400,700" );
		wp_enqueue_style( 'dslc-gf-lato', "//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" );

	}

} add_action( 'wp_enqueue_scripts', 'dslc_load_fonts' );