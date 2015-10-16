<?php

/**
 * Table of contents
 *
 * - dslc_yoast_seo_content_filter ( Include LC content in Yoast SEO filter )
 * - dslc_plugin_action_links ( Additional links on plugin listings page )
 * - dslc_icons
 */


/**
 * Include LC content in Yoast SEO filter
 *
 * @since 1.0
 */

function dslc_yoast_seo_content_filter( $post_content, $post ) {

	// If there's LC content append it to the post content var
	if ( get_post_meta( $post->ID, 'dslc_content_for_search', true ) ) {
		$post_content .= ' ' . get_post_meta( $post->ID, 'dslc_content_for_search', true );
	}

	// Return the post content var
	return $post_content;

} add_filter( 'wpseo_pre_analysis_post_content', 'dslc_yoast_seo_content_filter', 10, 2 );

/**
 * Additional links on plugin listings page 
 *
 * @since 1.0
 */

function dslc_plugin_action_links( $links ) {

	// Themes link
	$themes_link = '<a href="http://livecomposerplugin.com/themes" target="_blank">Themes</a>';
	array_unshift( $links, $themes_link );	

	// Addons link
	$addons_link = '<a href="http://livecomposerplugin.com/add-ons" target="_blank">Add-Ons</a>';
	array_unshift( $links, $addons_link );	

	// Support link
	$support_link = '<a href="http://livecomposerplugin.com/support" target="_blank">Support</a>';
	array_unshift( $links, $support_link );

	// Pass it back
	return $links;

} add_filter( 'plugin_action_links_' . DS_LIVE_COMPOSER_BASENAME, 'dslc_plugin_action_links' );

function dslc_icons() {

	global $dslc_var_icons;

	$dslc_var_icons = array(
		'fontawesome' => array( "adjust", "adn", "align-center", "align-justify", "align-left", "align-right", "ambulance", "anchor", "android", "angellist", "angle-down", "angle-left", "angle-right", "angle-up", "apple", "archive", "area-chart", "arrow-circle-left", "arrow-circle-right", "arrow-down", "arrow-left", "arrow-right", "arrow-up", "asterisk", "at", "automobile", "backward", "ban-circle", "bank", "bar-chart", "barcode", "beaker", "bed", "beer", "behance", "behance-square", "bell", "bell-alt", "bell-slash", "bell-slash-o", "bicycle", "binoculars", "birthday-cake", "bitbucket", "bitbucket-sign", "bitcoin", "bold", "bolt", "bomb", "book", "bookmark", "bookmark-empty", "briefcase", "btc", "bug", "building", "building", "bullhorn", "bullseye", "bus", "buysellads", "cab", "calculator", "calendar", "calendar-empty", "camera", "camera-retro", "car", "caret-down", "caret-left", "caret-right", "caret-square-left", "caret-up", "cart-arrow-down", "cart-plus", "cc", "cc-amex", "cc-discover", "cc-mastercard", "cc-paypal", "cc-stripe", "cc-visa", "certificate", "check", "check-empty", "check-minus", "check-sign", "chevron-down", "chevron-left", "chevron-right", "chevron-sign-down", "chevron-sign-left", "chevron-sign-right", "chevron-sign-up", "chevron-up", "child", "circle", "circle-arrow-down", "circle-arrow-left", "circle-arrow-right", "circle-arrow-up", "circle-blank", "circle-o-notch", "circle-thin", "cloud", "cloud-download", "cloud-upload", "cny", "code", "code-fork", "codepen", "coffee", "cog", "cogs", "collapse", "collapse-alt", "collapse-top", "columns", "comment", "comment-alt", "comments", "comments-alt", "compass", "connectdevelop", "copy", "copyright", "credit-card", "crop", "css3", "cube", "cubes", "cut", "dashboard", "dashcube", "database", "delicious", "desktop", "deviantart", "diamond", "digg", "dollar", "dot-circle", "double-angle-down", "double-angle-left", "double-angle-right", "double-angle-up", "download", "download-alt", "dribbble", "dropbox", "drupal", "edit", "edit-sign", "eject", "ellipsis-horizontal", "ellipsis-vertical", "empire", "envelope", "envelope-alt", "envelope-square", "eraser", "eur", "euro", "exchange", "exclamation", "exclamation-sign", "expand", "expand-alt", "external-link", "external-link-sign", "eye-close", "eye-open", "eyedropper", "facebook", "facebook-official", "facebook-sign", "facetime-video", "fast-backward", "fast-forward", "fax", "female", "fighter-jet", "file", "file-alt", "file-archive-o", "file-audio-o", "file-code-o", "file-excel-o", "file-image-o", "file-movie-o", "file-pdf-o", "file-photo-o", "file-picture-o", "file-powerpoint-o", "file-sound-o", "file-text", "file-text-alt", "file-video-o", "file-word-o", "file-zip-o", "film", "filter", "fire", "fire-extinguisher", "flag", "flag-alt", "flag-checkered", "flickr", "folder-close", "folder-close-alt", "folder-open", "folder-open-alt", "font", "food", "forumbee", "forward", "foursquare", "frown", "fullscreen", "futbol-o", "gamepad", "gbp", "ge", "gear", "gears", "gift", "git", "git-square", "github", "github-alt", "github-sign", "gittip", "glass", "globe", "google", "google-plus", "google-plus-sign", "google-wallet", "graduation-cap", "group", "h-sign", "hacker-news", "hand-down", "hand-left", "hand-right", "hand-up", "hdd", "header", "headphones", "heart", "heart-empty", "heartbeat", "history", "home", "hospital", "hotel (alias)", "html5", "ils", "inbox", "indent-left", "indent-right", "info", "info-sign", "inr", "instagram", "institution", "ioxhost", "italic", "joomla", "jpy", "jsfiddle", "key", "keyboard", "krw", "language", "laptop", "lastfm", "lastfm-square", "leaf", "leanpub", "legal", "lemon", "level-down", "level-up", "life-bouy", "life-ring", "life-saver", "lightbulb", "line-chart", "link", "linkedin", "linkedin-sign", "linux", "list", "list-alt", "list-ol", "list-ul", "location-arrow", "lock", "long-arrow-down", "long-arrow-left", "long-arrow-right", "long-arrow-up", "magic", "magnet", "mail-forward", "mail-reply", "mail-reply-all", "male", "map-marker", "mars", "mars-double", "mars-stroke", "mars-stroke-h", "mars-stroke-v", "maxcdn", "meanpath", "medium", "medkit", "meh", "mercury", "microphone", "microphone-off", "minus", "minus-sign", "minus-sign-alt", "mobile-phone", "money", "moon", "mortar-board", "motorcycle", "move", "music", "neuter", "newspaper-o", "off", "ok", "ok-circle", "ok-sign", "openid", "pagelines", "paint-brush", "paper-clip", "paper-plane", "paper-plane-o", "paperclip", "paragraph", "paste", "pause", "paw", "paypal", "pencil", "phone", "phone-sign", "picture", "pie-chart", "pied-piper", "pied-piper-alt", "pied-piper-square", "pinterest", "pinterest-p", "pinterest-sign", "plane", "play", "play-circle", "play-sign", "plug", "plus", "plus-sign", "plus-sign-alt", "power-off", "print", "pushpin", "puzzle-piece", "qq", "qrcode", "question", "question-sign", "quote-left", "quote-right", "ra", "random", "rebel", "recycle", "reddit", "reddit-square", "refresh", "remove", "remove-circle", "remove-sign", "renminbi", "renren", "reorder", "repeat", "reply", "reply-all", "resize-full", "resize-horizontal", "resize-small", "resize-vertical", "retweet", "road", "rocket", "rotate-left", "rotate-right", "rouble", "rss", "rss-sign", "rupee", "save", "screenshot", "search", "sellsy", "send", "send-o", "server", "share", "share-alt", "share-alt", "share-alt-square", "share-sign", "shield", "ship", "shirtsinbulk", "shopping-cart", "sign-blank", "signal", "signin", "signout", "simplybuilt", "sitemap", "skyatlas", "skype", "slack", "sliders", "slideshare", "smile", "sort", "sort-by-alphabet", "sort-by-alphabet-alt", "sort-by-attributes", "sort-by-attributes-alt", "sort-by-order", "sort-by-order-alt", "sort-down", "sort-up", "soundcloud", "space-shuttle", "spinner", "spoon", "spotify", "stack-exchange", "stackexchange", "star", "star-empty", "star-half", "star-half-empty", "star-half-full", "steam", "steam-square", "step-backward", "step-forward", "stethoscope", "stop", "street-view", "strikethrough", "stumbleupon", "stumbleupon-circle", "subscript", "subway", "suitcase", "sun", "superscript", "support", "table", "tablet", "tag", "tags", "tasks", "taxi", "tencent-weibo", "terminal", "text-height", "text-width", "th", "th-large", "th-list", "thumbs-down", "thumbs-down-alt", "thumbs-up", "thumbs-up-alt", "ticket", "time", "tint", "toggle-off", "toggle-on", "train", "transgender", "transgender-alt", "trash", "trash", "tree", "trello", "trophy", "truck", "tty", "tumblr", "tumblr-sign", "turkish-lira", "twitch", "twitter", "twitter-sign", "umbrella", "unchecked", "underline", "undo", "university", "unlink", "unlock", "unlock-alt", "upload", "upload-alt", "usd", "user", "user-md", "user-plus", "user-secret", "user-times", "venus", "venus-double", "venus-mars", "viacoin", "vimeo-square", "vine", "vk", "volume-down", "volume-off", "volume-up", "warning-sign", "wechat", "weibo", "weixin", "whatsapp", "wheelchair", "wifi", "windows", "won", "wordpress", "wrench", "xing", "xing-sign", "yahoo", "yelp", "yen", "youtube", "youtube-play", "youtube-sign", "zoom-in", "zoom-out" ),
	);

	// Allow devs to alter available icons
	$dslc_var_icons = apply_filters( 'dslc_available_icons', $dslc_var_icons );

} add_action( 'init', 'dslc_icons' );