#!/usr/bin/env bash


wpcept-run() {

	# if [[ $DO_WP_CEPT == 0 ]]; then
	# 	echo Not running codecept tests.
	# 	return
	# fi

	TMPDIR=${TMPDIR-/tmp}
	TMPDIR=$(echo $TMPDIR | sed -e "s/\/$//")
	WP_CORE_DIR=${WP_CORE_DIR-$TMPDIR/wordpress/}
	WP_CORE_DIR=${WP_CORE_DIR-$TMPDIR/wordpress/}
	WP_CEPT_SERVER='127.0.0.1:8080'

	echo "WP_CORE_DIR: $WP_CORE_DIR"
	# Custom Code: Start server for codeception tests.
	# We start the server up early so that it has time to prepare.
	php -S "$WP_CEPT_SERVER" -t "$WP_CORE_DIR" &

	# export WP_DEVELOP_DIR=/tmp/wordpress

	# Configure WordPress for access through a web server.
	cd "$WP_CORE_DIR"

	find . -maxdepth 1  # list files in current dirrectory

	sed -i "s/example.org/$WP_CEPT_SERVER/" wp-tests-config.php
	cp wp-tests-config.php wp-config.php
	echo "
		if ( ! defined( 'WP_INSTALLING' ) && ( getenv( 'WP_MULTISITE' ) || file_exists( dirname( __FILE__ ) . '/is-multisite' ) ) ) {
			define( 'MULTISITE', true );
			define( 'SUBDOMAIN_INSTALL', false );
			\$GLOBALS['base'] = '/';
		}
		require_once(ABSPATH . 'wp-settings.php');
	" >> wp-config.php

	cd -

	# sed -i "s/wptests.local/$WP_CEPT_SERVER/" codeception.dist.yml
	# phantomjs --webdriver=4444 >/dev/null &

	# Give PhantomJS time to start.
	# sleep 3

	php vendor/bin/codecept run acceptance --steps --debug -vvv --env travis
}

wpcept-run # custom