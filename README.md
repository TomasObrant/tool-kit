php bin/console lexik:jwt:generate-keypair

vendor/bin/phpstan analyse
vendor/bin/php-cs-fixer fix
php bin/phpunit

php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --env=test

php bin/console doctrine:fixtures:load --env=test
