clear

php app/console doctrine:database:drop --force --if-exists

php app/console doctrine:database:create

php app/console doctrine:schema:create

php app/console doctrine:fixtures:load -q
