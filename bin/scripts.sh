#!/usr/bin/env bash


wpcept-run() {

	# if [[ $DO_WP_CEPT == 0 ]]; then
	# 	echo Not running codecept tests.
	# 	return
	# fi

	TMPDIR=${TMPDIR-/tmp}
	TMPDIR=$(echo $TMPDIR | sed -e "s/\/$//")
	WP_TESTS_DIR=${WP_TESTS_DIR-$TMPDIR/wordpress-tests-lib}
	WP_CORE_DIR=${WP_CORE_DIR-$TMPDIR/wordpress/}
	WP_CORE_DIR=${WP_CORE_DIR-$TMPDIR/wordpress/}
	WP_CEPT_SERVER='127.0.0.1:8080'

	echo "WP_CORE_DIR: $WP_CORE_DIR"
	echo "WP_CORE_DIR: $WP_TESTS_DIR"
	# Custom Code: Start server for codeception tests.
	# We start the server up early so that it has time to prepare.
	php -S "$WP_CEPT_SERVER" -t "$WP_TESTS_DIR" &

	# export WP_DEVELOP_DIR=/tmp/wordpress

	# Configure WordPress for access through a web server.
	cd "$WP_TESTS_DIR"

	echo "$WP_TESTS_DIR ----------------------"
	find . -maxdepth 1  # list files in current dirrectory
	sed -i "s/example.org/$WP_CEPT_SERVER/" wp-tests-config.php #Update site URL in tests config
	cp "$WP_TESTS_DIR/wp-tests-config.php" "$WP_CORE_DIR/wp-config.php"
	echo "require_once(ABSPATH . 'wp-settings.php');" >> wp-config.php
	echo "$WP_TESTS_DIR ----------------------"
	find . -maxdepth 1  # list files in current dirrectory
	echo "$WP_CORE_DIR ----------------------"
	cd "$WP_CORE_DIR"
	find . -maxdepth 1  # list files in current dirrectory

	# sed -i "s/example.org/$WP_TESTS_DIR/" wp-config-sample.php
	# cp wp-config-sample.php wp-config.php

	# echo "
	# 	if ( ! defined( 'WP_INSTALLING' ) && ( getenv( 'WP_MULTISITE' ) || file_exists( dirname( __FILE__ ) . '/is-multisite' ) ) ) {
	# 		define( 'MULTISITE', true );
	# 		define( 'SUBDOMAIN_INSTALL', false );
	# 		\$GLOBALS['base'] = '/';
	# 	}
	# 	require_once(ABSPATH . 'wp-settings.php');
	# " >> wp-config.php

	# cat wp-config.php # show file content

	cd -

	echo "XXXXXXXX ----------------------"
	find . -maxdepth 1  # list files in current dirrectory

	# sed -i "s/wptests.local/$WP_CEPT_SERVER/" codeception.dist.yml
	# phantomjs --webdriver=4444 >/dev/null &

	# Give PhantomJS time to start.
	# sleep 3

	# php vendor/bin/codecept run acceptance --steps --debug -vvv --env travis
}

wpcept-run # custom