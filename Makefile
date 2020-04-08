php=php
src=src
codeSnifferRuleset=codesniffer-ruleset.xml
dirs:=$(src)
bin=vendor/bin


fix: check-syntax phpcbf phpcs phpstan

check-syntax:
	$(bin)/parallel-lint -e $(php) $(dirs)

phpcs:
	$(bin)/phpcs -sp --standard=$(codeSnifferRuleset) --extensions=php $(dirs)

phpcbf:
	$(bin)/phpcbf -spn --standard=$(codeSnifferRuleset) --extensions=php $(dirs)

phpstan:
	$(bin)/phpstan analyze $(dirs) --level max

ci: check-syntax phpcs phpstan
