.PHONY: test testnocov examples travis

testnocov:
	php vendor/bin/phpunit

test:
	php vendor/bin/phpunit --coverage-text

examples:
	php examples/mapping.php

travis: test examples
