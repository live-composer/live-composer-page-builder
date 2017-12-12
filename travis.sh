#!/usr/bin/env bash

# Install WordPress.
install-wordpress() {

	mkdir -p "$WP_DEVELOP_DIR"

	if [[ $WP_VERSION == 'develop' ]]; then
		WP_VERSION=master
	fi

	# Clone the WordPress develop repo.
	git clone --depth=1 --branch="$WP_VERSION" git://develop.git.wordpress.org/ "$WP_DEVELOP_DIR"

	# Set up tests config.
	cd "$WP_DEVELOP_DIR"
	cp wp-tests-config-sample.php wp-config.php
	sed -i "s/youremptytestdbnamehere/wordpress_test/" wp-config.php
	sed -i "s/yourusernamehere/root/" wp-config.php
	sed -i "s/yourpasswordhere//" wp-config.php
	cd -

	# Set up database.
	mysql -e 'CREATE DATABASE wordpress_test;' -uroot

	# Configure WordPress for access through a web server.
	sed -i "s/'example.org'/'$WP_CEPT_SERVER'/" wp-config.php

	# Install.
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

	# Update the config to actually load WordPress.
	echo "require_once(ABSPATH . 'wp-settings.php');" >> wp-config.php

	# Set up default theme.
	ln -s "$WP_CORE_DIR/wp-content/themes/twentyseventeen" "$WP_CORE_DIR/wp-content/themes/default"



	export PROJECT_DIR=$(pwd)/src
	export PROJECT_SLUG=$(basename "$(pwd)" | sed 's/^wp-//')

	# Set up plugin.
	ln -s "$PROJECT_DIR" "$WP_CORE_DIR"/wp-content/plugins/"$PROJECT_SLUG"
}

# EOF
