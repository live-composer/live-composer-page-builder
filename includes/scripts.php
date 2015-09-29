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
		'str_confirm' => __( 'CONFIRM', 'dslc_string' ),
		'str_ok' => __( 'OK', 'dslc_string' ),
		'str_import' => __( 'IMPORT', 'dslc_string' ),
		'str_exit_title' => __( 'You are about to exit Live Composer', 'dslc_string' ),
		'str_exit_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'dslc_string' ),
		'str_area_helper_text' => __( 'MODULES AREA', 'dslc_string' ),
		'str_row_helper_text' => __( 'MODULES ROW', 'dslc_string' ),
		'str_import_row_title' => __( 'Import Row', 'dslc_string' ),
		'str_import_row_descr' => __( 'Copy the row export code bellow.', 'dslc_string' ),
		'str_del_module_title' => __( 'Delete Module', 'dslc_string' ),
		'str_del_module_descr' => __( 'Are you sure you want to delete this module?', 'dslc_string' ),
		'str_del_area_title' => __( 'Delete Area/Column', 'dslc_string' ),
		'str_del_area_descr' => __( 'Are you sure you want to delete this modules area?', 'dslc_string' ),
		'str_del_row_title' => __( 'Delete Row', 'dslc_string' ),
		'str_del_row_descr' => __( 'Are you sure you want to delete this row?', 'dslc_string' ),
		'str_export_row_title' => __( 'Export Row', 'dslc_string' ),
		'str_export_row_descr' => __( 'The code bellow is the importable code for this row.', 'dslc_string' ),
		'str_module_curr_edit_title' => __( 'You are currently editing a module', 'dslc_string' ),
		'str_module_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'dslc_string' ),
		'str_row_curr_edit_title' => __( 'You are currently editing a modules row', 'dslc_string' ),
		'str_row_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'dslc_string' ),
		'str_refresh_title' => __( 'You are about to refresh the page', 'dslc_string' ),
		'str_refresh_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'dslc_string' ),
		'str_res_tablet' => __( 'tablet', 'dslc_string' ),
		'str_res_phone' => __( 'phone', 'dslc_string' )
	);
	
	// Array of fonts available to be used in LC editor
	$fonts_array = array(
		'regular' => array( "Georgia", "Times", "Arial", "Lucida Sans Unicode", "Tahoma", "Trebuchet MS", "Verdana", "Helvetica" ),
		'google' => array( "ABeeZee","Abel","Abril Fatface","Aclonica","Acme","Actor","Adamina","Advent Pro","Aguafina Script","Akronim","Aladin","Aldrich","Alef","Alegreya","Alegreya SC","Alex Brush","Alfa Slab One","Alice","Alike","Alike Angular","Allan","Allerta","Allerta Stencil","Allura","Almendra","Almendra Display","Almendra SC","Amarante","Amaranth","Amatic SC","Amethysta","Anaheim","Andada","Andika","Annie Use Your Telescope","Anonymous Pro","Antic","Antic Didone","Antic Slab","Anton","Arapey","Arbutus","Arbutus Slab","Architects Daughter","Archivo Black","Archivo Narrow","Arimo","Arizonia","Armata","Artifika","Arvo","Asap","Asset","Astloch","Asul","Atomic Age","Aubrey","Audiowide","Autour One","Average","Average Sans","Averia Gruesa Libre","Averia Libre","Averia Sans Libre","Averia Serif Libre","Bad Script","Balthazar","Bangers","Basic","Baumans","Belgrano","Belleza","BenchNine","Bentham","Berkshire Swash","Bevan","Bigelow Rules","Bigshot One","Bilbo","Bilbo Swash Caps","Bitter","Black Ops One","Bonbon","Boogaloo","Bowlby One","Bowlby One SC","Brawler","Bree Serif","Bubblegum Sans","Bubbler One","Buda","Buenard","Butcherman","Butterfly Kids","Cabin","Cabin Condensed","Cabin Sketch","Caesar Dressing","Cagliostro","Calligraffitti","Cambo","Candal","Cantarell","Cantata One","Cantora One","Capriola","Cardo","Carme","Carrois Gothic","Carrois Gothic SC","Carter One","Caudex","Cedarville Cursive","Ceviche One","Changa One","Chango","Chau Philomene One","Chela One","Chelsea Market","Cherry Cream Soda","Cherry Swash","Chewy","Chicle","Chivo","Cinzel","Cinzel Decorative","Clicker Script","Coda","Coda Caption","Codystar","Combo","Comfortaa","Coming Soon","Concert One","Condiment","Contrail One","Convergence","Cookie","Copse","Corben","Courgette","Cousine","Coustard","Covered By Your Grace","Crafty Girls","Creepster","Crete Round","Crimson Text","Croissant One","Crushed","Cuprum","Cutive","Cutive Mono","Damion","Dancing Script", "Dawning of a New Day","Days One","Delius","Delius Swash Caps","Delius Unicase","Della Respira","Denk One","Devonshire","Didact Gothic","Diplomata","Diplomata SC","Domine","Donegal One","Doppio One","Dorsa","Dosis","Dr Sugiyama","Droid Sans","Droid Sans Mono","Droid Serif","Duru Sans","Dynalight","Eagle Lake","Eater","EB Garamond","Economica","Electrolize","Elsie","Elsie Swash Caps","Emblema One","Emilys Candy","Engagement","Englebert","Enriqueta","Erica One","Esteban","Euphoria Script","Ewert","Exo","Expletus Sans","Fanwood Text","Fascinate","Fascinate Inline","Faster One","Fauna One","Federant","Federo","Felipa","Fenix","Finger Paint","Fjalla One","Fjord One","Flamenco","Flavors","Fondamento","Fontdiner Swanky","Forum","Francois One","Freckle Face","Fredericka the Great","Fredoka One","Fresca","Frijole","Fruktur","Fugaz One","Gabriela","Gafata","Galdeano","Galindo","Gentium Basic","Gentium Book Basic","Geo","Geostar","Geostar Fill","Germania One","GFS Didot","GFS Neohellenic","Gilda Display","Give You Glory","Glass Antiqua","Glegoo","Gloria Hallelujah","Goblin One","Gochi Hand","Gorditas","Goudy Bookletter 1911","Graduate","Grand Hotel","Gravitas One","Great Vibes","Griffy","Gruppo","Gudea","Habibi","Hammersmith One","Hanalei","Hanalei Fill","Handlee","Happy Monkey","Headland One","Henny Penny","Herr Von Muellerhoff","Holtwood One SC","Homemade Apple","Homenaje","Iceberg","Iceland","IM Fell Double Pica","IM Fell Double Pica SC","IM Fell DW Pica","IM Fell DW Pica SC","IM Fell English","IM Fell English SC","IM Fell French Canon","IM Fell French Canon SC","IM Fell Great Primer","IM Fell Great Primer SC","Imprima","Inconsolata","Inder","Indie Flower","Inika","Irish Grover","Istok Web","Italiana","Italianno","Jacques Francois","Jacques Francois Shadow","Jim Nightshade","Jockey One","Jolly Lodger","Josefin Sans","Josefin Slab","Joti One","Judson","Julee","Julius Sans One","Junge","Jura","Just Another Hand","Just Me Again Down Here","Kameron","Karla","Kaushan Script","Kavoon","Keania One","Kelly Slab","Kenia","Kite One","Knewave","Kotta One","Kranky","Kreon","Kristi","Krona One","La Belle Aurore","Lancelot","Lato","League Script","Leckerli One","Ledger","Lekton","Lemon","Libre Baskerville","Life Savers","Lilita One","Lily Script One","Limelight","Linden Hill","Lobster","Lobster Two","Londrina Outline","Londrina Shadow","Londrina Sketch","Londrina Solid","Lora","Love Ya Like A Sister","Loved by the King","Lovers Quarrel","Luckiest Guy","Lusitana","Lustria","Macondo","Macondo Swash Caps","Magra","Maiden Orange","Mako","Marcellus","Marcellus SC","Marck Script","Margarine","Marko One","Marmelad","Marvel","Mate","Mate SC","Maven Pro","McLaren","Meddon","MedievalSharp","Medula One","Megrim","Meie Script","Merienda","Merienda One","Merriweather","Merriweather Sans","Metal Mania","Metamorphous","Metrophobic","Michroma","Milonga","Miltonian","Miltonian Tattoo","Miniver","Miss Fajardose","Modern Antiqua","Molengo","Molle","Monda","Monofett","Monoton","Monsieur La Doulaise","Montaga","Montez","Montserrat","Montserrat Alternates","Montserrat Subrayada","Mountains of Christmas","Mouse Memoirs","Mr Bedfort","Mr Dafoe","Mr De Haviland","Mrs Saint Delafield","Mrs Sheppards","Muli","Mystery Quest","Neucha","Neuton","New Rocker","News Cycle","Niconne","Nixie One","Nobile","Norican","Nosifer","Nothing You Could Do","Noticia Text","Noto Sans","Noto Serif","Nova Cut","Nova Flat","Nova Mono","Nova Oval","Nova Round","Nova Script","Nova Slim","Nova Square","Numans","Nunito","Offside","Old Standard TT","Oldenburg","Oleo Script","Oleo Script Swash Caps","Open Sans","Open Sans Condensed","Oranienbaum","Orbitron","Oregano","Orienta","Original Surfer","Oswald","Over the Rainbow","Overlock","Overlock SC","Ovo","Oxygen","Oxygen Mono","Pacifico","Paprika","Parisienne","Passero One","Passion One","Pathway Gothic One","Patrick Hand","Patrick Hand SC","Patua One","Paytone One","Peralta","Permanent Marker","Petit Formal Script","Petrona","Philosopher","Piedra","Pinyon Script","Pirata One","Plaster","Play","Playball","Playfair Display","Playfair Display SC","Podkova","Poiret One","Poller One","Poly","Pompiere","Pontano Sans","Port Lligat Sans","Port Lligat Slab","Prata","Press Start 2P","Princess Sofia","Prociono","Prosto One","PT Mono","PT Sans","PT Sans Caption","PT Sans Narrow","PT Serif","PT Serif Caption","Puritan","Purple Purse","Quando","Quantico","Quattrocento","Quattrocento Sans","Questrial","Quicksand","Quintessential","Qwigley","Racing Sans One","Radley","Raleway","Raleway Dots","Rambla","Rammetto One","Ranchers","Rancho","Rationale","Redressed","Reenie Beanie","Revalia","Ribeye","Ribeye Marrow","Righteous","Risque","Roboto","Roboto Condensed","Roboto Slab","Rochester","Rock Salt","Rokkitt","Romanesco","Ropa Sans","Rosario","Rosarivo","Rouge Script","Ruda","Rufina","Ruge Boogie","Ruluko","Rum Raisin","Ruslan Display","Russo One","Ruthie","Rye","Sacramento","Sail","Salsa","Sanchez","Sancreek","Sansita One","Sarina","Satisfy","Scada","Schoolbell","Seaweed Script","Sevillana","Seymour One","Shadows Into Light","Shadows Into Light Two","Shanti","Share","Share Tech","Share Tech Mono","Shojumaru","Short Stack","Sigmar One","Signika","Signika Negative","Simonetta","Sintony","Sirin Stencil","Six Caps","Skranji","Slackey","Smokum","Smythe","Sniglet","Snippet","Snowburst One","Sofadi One","Sofia","Sonsie One","Sorts Mill Goudy","Source Code Pro","Source Sans Pro","Special Elite","Spicy Rice","Spinnaker","Spirax","Squada One","Stalemate","Stalinist One","Stardos Stencil","Stint Ultra Condensed","Stint Ultra Expanded","Stoke","Strait","Sue Ellen Francisco","Sunshiney","Supermercado One","Swanky and Moo Moo","Syncopate","Tangerine","Tauri","Telex","Tenor Sans","Text Me One","The Girl Next Door","Tienne","Tinos","Titan One","Titillium Web","Trade Winds","Trocchi","Trochut","Trykker","Tulpen One","Ubuntu","Ubuntu Condensed","Ubuntu Mono","Ultra","Uncial Antiqua","Underdog","Unica One","UnifrakturCook","UnifrakturMaguntia","Unkempt","Unlock","Unna","Vampiro One","Varela","Varela Round","Vast Shadow","Vibur","Vidaloka","Viga","Voces","Volkhov","Vollkorn","Voltaire","VT323","Waiting for the Sunrise","Wallpoet","Walter Turncoat","Warnes","Wellfleet","Wendy One","Wire One","Yanone Kaffeesatz","Yellowtail","Yeseva One","Yesteryear","Zeyada" ),
	);
	
	// Allow devs to alter available fonts
	$fonts_array = apply_filters( 'dslc_available_fonts', $fonts_array );

	// Array of icons available to be used
	$icons_array = array(
		'fontawesome' => array( "adjust", "adn", "align-center", "align-justify", "align-left", "align-right", "ambulance", "anchor", "android", "angellist", "angle-down", "angle-left", "angle-right", "angle-up", "apple", "archive", "area-chart", "arrow-circle-left", "arrow-circle-right", "arrow-down", "arrow-left", "arrow-right", "arrow-up", "asterisk", "at", "automobile", "backward", "ban-circle", "bank", "bar-chart", "barcode", "beaker", "bed", "beer", "behance", "behance-square", "bell", "bell-alt", "bell-slash", "bell-slash-o", "bicycle", "binoculars", "birthday-cake", "bitbucket", "bitbucket-sign", "bitcoin", "bold", "bolt", "bomb", "book", "bookmark", "bookmark-empty", "briefcase", "btc", "bug", "building", "building", "bullhorn", "bullseye", "bus", "buysellads", "cab", "calculator", "calendar", "calendar-empty", "camera", "camera-retro", "car", "caret-down", "caret-left", "caret-right", "caret-square-left", "caret-up", "cart-arrow-down", "cart-plus", "cc", "cc-amex", "cc-discover", "cc-mastercard", "cc-paypal", "cc-stripe", "cc-visa", "certificate", "check", "check-empty", "check-minus", "check-sign", "chevron-down", "chevron-left", "chevron-right", "chevron-sign-down", "chevron-sign-left", "chevron-sign-right", "chevron-sign-up", "chevron-up", "child", "circle", "circle-arrow-down", "circle-arrow-left", "circle-arrow-right", "circle-arrow-up", "circle-blank", "circle-o-notch", "circle-thin", "cloud", "cloud-download", "cloud-upload", "cny", "code", "code-fork", "codepen", "coffee", "cog", "cogs", "collapse", "collapse-alt", "collapse-top", "columns", "comment", "comment-alt", "comments", "comments-alt", "compass", "connectdevelop", "copy", "copyright", "credit-card", "crop", "css3", "cube", "cubes", "cut", "dashboard", "dashcube", "database", "delicious", "desktop", "deviantart", "diamond", "digg", "dollar", "dot-circle", "double-angle-down", "double-angle-left", "double-angle-right", "double-angle-up", "download", "download-alt", "dribbble", "dropbox", "drupal", "edit", "edit-sign", "eject", "ellipsis-horizontal", "ellipsis-vertical", "empire", "envelope", "envelope-alt", "envelope-square", "eraser", "eur", "euro", "exchange", "exclamation", "exclamation-sign", "expand", "expand-alt", "external-link", "external-link-sign", "eye-close", "eye-open", "eyedropper", "facebook", "facebook-official", "facebook-sign", "facetime-video", "fast-backward", "fast-forward", "fax", "female", "fighter-jet", "file", "file-alt", "file-archive-o", "file-audio-o", "file-code-o", "file-excel-o", "file-image-o", "file-movie-o", "file-pdf-o", "file-photo-o", "file-picture-o", "file-powerpoint-o", "file-sound-o", "file-text", "file-text-alt", "file-video-o", "file-word-o", "file-zip-o", "film", "filter", "fire", "fire-extinguisher", "flag", "flag-alt", "flag-checkered", "flickr", "folder-close", "folder-close-alt", "folder-open", "folder-open-alt", "font", "food", "forumbee", "forward", "foursquare", "frown", "fullscreen", "futbol-o", "gamepad", "gbp", "ge", "gear", "gears", "gift", "git", "git-square", "github", "github-alt", "github-sign", "gittip", "glass", "globe", "google", "google-plus", "google-plus-sign", "google-wallet", "graduation-cap", "group", "h-sign", "hacker-news", "hand-down", "hand-left", "hand-right", "hand-up", "hdd", "header", "headphones", "heart", "heart-empty", "heartbeat", "history", "home", "hospital", "hotel (alias)", "html5", "ils", "inbox", "indent-left", "indent-right", "info", "info-sign", "inr", "instagram", "institution", "ioxhost", "italic", "joomla", "jpy", "jsfiddle", "key", "keyboard", "krw", "language", "laptop", "lastfm", "lastfm-square", "leaf", "leanpub", "legal", "lemon", "level-down", "level-up", "life-bouy", "life-ring", "life-saver", "lightbulb", "line-chart", "link", "linkedin", "linkedin-sign", "linux", "list", "list-alt", "list-ol", "list-ul", "location-arrow", "lock", "long-arrow-down", "long-arrow-left", "long-arrow-right", "long-arrow-up", "magic", "magnet", "mail-forward", "mail-reply", "mail-reply-all", "male", "map-marker", "mars", "mars-double", "mars-stroke", "mars-stroke-h", "mars-stroke-v", "maxcdn", "meanpath", "medium", "medkit", "meh", "mercury", "microphone", "microphone-off", "minus", "minus-sign", "minus-sign-alt", "mobile-phone", "money", "moon", "mortar-board", "motorcycle", "move", "music", "neuter", "newspaper-o", "off", "ok", "ok-circle", "ok-sign", "openid", "pagelines", "paint-brush", "paper-clip", "paper-plane", "paper-plane-o", "paperclip", "paragraph", "paste", "pause", "paw", "paypal", "pencil", "phone", "phone-sign", "picture", "pie-chart", "pied-piper", "pied-piper-alt", "pied-piper-square", "pinterest", "pinterest-p", "pinterest-sign", "plane", "play", "play-circle", "play-sign", "plug", "plus", "plus-sign", "plus-sign-alt", "power-off", "print", "pushpin", "puzzle-piece", "qq", "qrcode", "question", "question-sign", "quote-left", "quote-right", "ra", "random", "rebel", "recycle", "reddit", "reddit-square", "refresh", "remove", "remove-circle", "remove-sign", "renminbi", "renren", "reorder", "repeat", "reply", "reply-all", "resize-full", "resize-horizontal", "resize-small", "resize-vertical", "retweet", "road", "rocket", "rotate-left", "rotate-right", "rouble", "rss", "rss-sign", "rupee", "save", "screenshot", "search", "sellsy", "send", "send-o", "server", "share", "share-alt", "share-alt", "share-alt-square", "share-sign", "shield", "ship", "shirtsinbulk", "shopping-cart", "sign-blank", "signal", "signin", "signout", "simplybuilt", "sitemap", "skyatlas", "skype", "slack", "sliders", "slideshare", "smile", "sort", "sort-by-alphabet", "sort-by-alphabet-alt", "sort-by-attributes", "sort-by-attributes-alt", "sort-by-order", "sort-by-order-alt", "sort-down", "sort-up", "soundcloud", "space-shuttle", "spinner", "spoon", "spotify", "stack-exchange", "stackexchange", "star", "star-empty", "star-half", "star-half-empty", "star-half-full", "steam", "steam-square", "step-backward", "step-forward", "stethoscope", "stop", "street-view", "strikethrough", "stumbleupon", "stumbleupon-circle", "subscript", "subway", "suitcase", "sun", "superscript", "support", "table", "tablet", "tag", "tags", "tasks", "taxi", "tencent-weibo", "terminal", "text-height", "text-width", "th", "th-large", "th-list", "thumbs-down", "thumbs-down-alt", "thumbs-up", "thumbs-up-alt", "ticket", "time", "tint", "toggle-off", "toggle-on", "train", "transgender", "transgender-alt", "trash", "trash", "tree", "trello", "trophy", "truck", "tty", "tumblr", "tumblr-sign", "turkish-lira", "twitch", "twitter", "twitter-sign", "umbrella", "unchecked", "underline", "undo", "university", "unlink", "unlock", "unlock-alt", "upload", "upload-alt", "usd", "user", "user-md", "user-plus", "user-secret", "user-times", "venus", "venus-double", "venus-mars", "viacoin", "vimeo-square", "vine", "vk", "volume-down", "volume-off", "volume-up", "warning-sign", "wechat", "weibo", "weixin", "whatsapp", "wheelchair", "wifi", "windows", "won", "wordpress", "wrench", "xing", "xing-sign", "yahoo", "yelp", "yen", "youtube", "youtube-play", "youtube-sign", "zoom-in", "zoom-out" ),
	);
	
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
		wp_localize_script( 'dslc-builder-main-js', 'DSLCIcons', $icons_array );

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