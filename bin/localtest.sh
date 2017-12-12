#!/usr/bin/env bash


localtest-run() {
	clear
	cd bin
	# phantomjs --webdriver=4444 &
	phantomjs --webdriver=4444 >/dev/null 2>&1 & # Run phantomJS in background.
	cd .. # Go back to the project forlder to make sure codecept have it right.

	# Install and Activate Yoast SEO plugin (used in tests).
    vendor/bin/wp plugin install wordpress-seo --activate

	# Give PhantomJS time to start.
	sleep 3

	php ./vendor/bin/codecept run acceptance --steps  && codecept run functional && codecept run # Debug mode: -d  output data with this function: codecept_debug($data)
	killall phantomjs # Kill phantomJS background process.
}

localtest-run