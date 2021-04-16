php=php
src=src
tests=tests
codeSnifferRuleset=codesniffer-ruleset.xml
dirs:=$(src) $(tests)
bin=vendor/bin


fix: check-syntax phpcbf phpcs phpstan test

check-syntax:
	$(bin)/parallel-lint -e $(php) $(dirs)

phpcs:
	$(bin)/phpcs -sp --standard=$(codeSnifferRuleset) --extensions=php $(dirs)

phpcbf:
	$(bin)/phpcbf -spn --standard=$(codeSnifferRuleset) --extensions=php $(dirs)

phpstan:
	$(bin)/phpstan analyze $(dirs)

ci: check-syntax phpcs phpstan

test:
	$(bin)/phpunit tests
