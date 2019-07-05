#!/bin/bash

clear

# Exit if any command fails
set -e

# For development
CLI='cli'

# For testing
if [ "$1" == '--e2e_tests' ]; then
	CLI="${CLI}_e2e_tests"
fi

# Set up environment variables
. "$(dirname "$0")/bootstrap-env.sh"

# Include useful functions
. "$(dirname "$0")/includes.sh"

# Change to the expected directory
cd "$(dirname "$0")/.."

# Check Docker is installed and running
. "$(dirname "$0")/install-docker.sh"

# Set up WordPress Development site.
# Note: we don't bother installing the test site right now, because that's
# done on every time `npm run test-e2e` is run.
. "$(dirname "$0")/install-wordpress.sh"


# Install the PHPUnit test scaffolding.
# echo -e $(status_message "Installing PHPUnit test scaffolding...")
# docker-compose run --rm wordpress_phpunit /app/bin/install-wp-tests.sh wordpress_test root example mysql $WP_VERSION false > /dev/null

# Install Composer. This is only used to run WordPress Coding Standards checks.
# echo -e $(status_message "Installing and updating Composer modules...")
# docker-compose run --rm composer install

! read -d '' LIVECOMPOSER <<"EOT"

    _                   ___                                         
 \_|_)  o              / (_)                                        
   |             _    |      __   _  _  _     _   __   ,   _   ,_   
  _|    |  |  |_|/    |     /  \_/ |/ |/ |  |/ \_/  \_/ \_|/  /  |  
 (/\___/|_/ \/  |__/   \___/\__/   |  |  |_/|__/ \__/  \/ |__/   |_/
                                           /|                       
                                           \|                       
EOT

CURRENT_URL=$(docker-compose run -T --rm $CLI option get siteurl)

echo -e "\nWelcome to...\n"
echo -e "\033[95m$LIVECOMPOSER\033[0m"

# Give the user more context to what they should do next: Build Gutenberg and start testing!
echo -e "\nRun $(action_format "npm run dev") to build the latest Gutenberg packages,"
echo -e "then open $(action_format "$CURRENT_URL") to get started!"

echo -e "\n\nAccess the above install using the following credentials:"
echo -e "Default username: $(action_format "admin"), password: $(action_format "password")"

# For testing
if [ "$1" == '--e2e_tests' ]; then
	echo -e "\nRun $(action_format "npm run test-e2e") to perform automatic testing."
fi
