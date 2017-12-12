#!/usr/bin/env bash

# Install WordPress.
install-wordpress() {

	mkdir -p "$WP_DEVELOP_DIR" # /tmp/wordpress

	if [[ $WP_VERSION == 'develop' ]]; then
		WP_VERSION=master
	fi

	# Clone the WordPress develop repo. https://github.com/WordPress/wordpress-develop
	git clone --depth=1 --branch="$WP_VERSION" git://develop.git.wordpress.org/ "$WP_DEVELOP_DIR"
	# Set up tests config.
	cd "$WP_DEVELOP_DIR"
	# Contains:
	# ...
	# ./src
	# ./tests
	# ./tools
	# ./wp-cli.yml
	# ./wp-config-sample.php
	# ./wp-tests-config-sample.php

	cp wp-tests-config-sample.php wp-config.php # duplicate file to have ./wp-config.php
	# Search & replace:
	# – Database
	sed -i "s/youremptytestdbnamehere/wordpress_test/" wp-config.php #DB
	sed -i "s/yourusernamehere/root/" wp-config.php #user
	sed -i "s/yourpasswordhere//" wp-config.php #pass
	# – Configure WordPress for access through a web server.
	sed -i "s/'example.org'/'$WP_CEPT_SERVER'/" wp-config.php

	sed -i "s/define( 'ABSPATH'///" wp-config.php

	# Set up database.
	mysql -e 'CREATE DATABASE wordpress_test;' -uroot

	# Install WordPress via PHP unit-test installer.
	php tests/phpunit/includes/install.php wp-config.php "$WP_MULTISITE"

	# Support multisite.
	if [[ $WP_MULTISITE = 1 ]]; then

		# Update the config to enable multisite.
		echo "

			define( 'MULTISITE', true );
			define( 'SUBDOMAIN_INSTALL', false );
			\$GLOBALS['base'] = '/';

		" >> wp-config.php
	fi

	# The next code is missing from wp-config, but required for WP-CLI to run.
	echo "
		/** Absolute path to the WordPress directory. */
		if ( !defined('ABSPATH') )
			define('ABSPATH', dirname(__FILE__) . '/src/');
	" >> wp-config.php

	# Update the config to actually load WordPress.
	# Installed wordPress located in /tmp/wordpress/src ($WP_CORE_DIR)
	# when wp-config.php in /tmp/wordpress
	echo "require_once(ABSPATH . 'wp-settings.php');" >> wp-config.php

	cat wp-config.php

	# $WP_CORE_DIR
	# /tmp/wordpress/src
	# /tmp/wordpress/src/index.php
	# /tmp/wordpress/src/license.txt
	# /tmp/wordpress/src/readme.html
	# /tmp/wordpress/src/wp-activate.php
	# /tmp/wordpress/src/wp-admin
	# /tmp/wordpress/src/wp-blog-header.php
	# /tmp/wordpress/src/wp-comments-post.php
	# /tmp/wordpress/src/wp-content
	# /tmp/wordpress/src/wp-content/themes/
		# /tmp/wordpress/src/wp-content/themes/index.php
		# /tmp/wordpress/src/wp-content/themes/twentyeleven
		# /tmp/wordpress/src/wp-content/themes/twentyfifteen
		# /tmp/wordpress/src/wp-content/themes/twentyfourteen
		# /tmp/wordpress/src/wp-content/themes/twentyseventeen
		# /tmp/wordpress/src/wp-content/themes/twentysixteen
		# /tmp/wordpress/src/wp-content/themes/twentyten
		# /tmp/wordpress/src/wp-content/themes/twentythirteen
		# /tmp/wordpress/src/wp-content/themes/twentytwelve
		# /tmp/wordpress/src/wp-content/themes/default

	# /tmp/wordpress/src/wp-cron.php
	# /tmp/wordpress/src/wp-includes
	# /tmp/wordpress/src/wp-links-opml.php
	# /tmp/wordpress/src/wp-load.php
	# /tmp/wordpress/src/wp-login.php
	# /tmp/wordpress/src/wp-mail.php
	# /tmp/wordpress/src/wp-settings.php
	# /tmp/wordpress/src/wp-signup.php
	# /tmp/wordpress/src/wp-trackback.php
	# /tmp/wordpress/src/xmlrpc.php

	# Set up default theme.
	ln -s "$WP_CORE_DIR/wp-content/themes/twentyseventeen" "$WP_CORE_DIR/wp-content/themes/default"


	# $HOME = /home/travis

	# Set up plugin.
	ln -s "$TRAVIS_BUILD_DIR" "$WP_CORE_DIR"/wp-content/plugins/live-composer-page-builder

	# echo "????? THEMES ----------------------"
	# echo "$WP_CORE_DIR/wp-content/themes/"
	# find "$WP_CORE_DIR/wp-content/themes" -maxdepth 1  # list files in current dirrectory
	# echo "----------------------"

	# echo "????? PLUGINS ----------------------"
	# echo "$WP_CORE_DIR/wp-content/plugins/"
	# find "$WP_CORE_DIR/wp-content/plugins" -maxdepth 1  # list files in current dirrectory
	# echo "----------------------"

	cd -
}

# EOF
