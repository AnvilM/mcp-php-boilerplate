analyse:
	vendor/bin/phpstan --memory-limit=-1

test:
	vendor/bin/pest
	
cs-check:
	vendor/bin/php-cs-fixer fix --dry-run --diff --verbose

cs-fix:
	vendor/bin/php-cs-fixer fix --verbose