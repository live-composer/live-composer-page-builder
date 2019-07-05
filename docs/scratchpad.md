docker-compose stop
docker-compose up -d

docker-compose up
docker-compose down

To list running containers:
$> docker ps


To browse files on docker:
$> docker exec -t -i live-composer-page-builder_wordpress_1 /bin/bash

To render file in bash:
$> cat filename.php

If you see: "bash: ./bin/setup-local-env.sh: Permission denied"
Run: $> chmod +x file.sh


WP CLI commands:
https://developer.wordpress.org/cli/commands/