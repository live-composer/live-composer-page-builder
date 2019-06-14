To run tests launch:
$> bash bin/localtest.sh



Next steps:
0. Create the databases used by the modules; wp-browser will not do it for you!
1. Install and configure WordPress activating the theme and plugins you need to create a database dump in tests/_data/dump.sql
2. Edit tests/acceptance.suite.yml to make sure WPDb and WPBrowser configurations match your local setup; change WPBrowser to WPWebDriver to enable browser testing
3. Edit tests/functional.suite.yml to make sure WordPress and WPDb configurations match your local setup
4. Edit tests/wpunit.suite.yml to make sure WPLoader configuration matches your local setup
5. Create your first acceptance tests using codecept g:cest acceptance WPFirst
6. Write a test in tests/acceptance/WPFirstCest.php
7. Run tests using: codecept run acceptance
 ---

 PREV DOCS:

 Installing inviroment:

To install composer:
1. Install composer in the development folder as described here: https://getcomposer.org/download/
2. Then move it to the /url/local/bin/composer folder with the next command: $> mv composer.phar /usr/local/bin/composer (maybe needs sudo in front)
3. Now you can run composer with the next command $> composer
4. Install packages with $> composer install
## before was: composer install --ignore-platform-reqs

Composer commands:
– INSTALL $> composer install
– UPDATE (DON'T USE) $> composer update --ignore-platform-reqs

================================================================================

ACCEPTANCE TESTING:

To do once:
1. Download PhantomJS (nt) http://phantomjs.org/download.html
2. copy phantomjs file to /bin/phantomjs

To test:
Run in macOS terminal (not from the editor) from the project folder
$> bash bin/localtest.sh

Documentation & examples:
– Some documentation: https://github.com/lucatume/wp-browser
– Available methods(commadns): https://github.com/lucatume/wp-browser#methods
– http://codeception.com/docs/modules/WebDriver
– Examples: https://github.com/WordPoints/wordpoints/tree/develop/tests/codeception/acceptance

================================================================================

PHPUNIT TESTING:
https://pippinsplugins.com/unit-tests-wordpress-plugins-setting-up-testing-suite/

To do once:
bash bin/install-wp-tests.sh wordpress_test root 'root' localhost latest

Replace root with the username of your database and
replace 'root' with the database password.
Also replace “localhost” with the hostname of your database.
You can find all three of these values in your wp-config.php file.

To test:
$> phpunit



// ============================================================

OTHER RESOURCES:
WP-CLI commands: https://developer.wordpress.org/cli/commands/
