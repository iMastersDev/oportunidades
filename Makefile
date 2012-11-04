COMPOSER = php composer.phar
VENDOR_DIR = vendor
PHPUNIT = bin/phpunit
PHPUNIT_XML = tests/phpunit.xml
CURRENT_BRANCH := $(shell git branch | grep '*' | cut -d ' ' -f 2)
BRANCHES=`git branch | grep -v "*" | tr "\\n" " "`

.check-composer:
	@echo "Checking if Composer is installed..."
	@test -f composer.phar || curl -s http://getcomposer.org/installer | php;

.check-installation: .check-composer
	@echo "Checking for vendor directory..."
	@test -d $(VENDOR_DIR) || make install

clean:
	@echo "Removing Composer..."
	rm -f composer.phar
	rm -rf vendor

test: .check-installation
	$(PHPUNIT) -c $(PHPUNIT_XML) tests/

test-branches:
	@echo "Current branch: $(CURRENT_BRANCH)";
	@for BRANCH in $(BRANCHES); do \
		echo "------------------------------------------------------------" \
		git checkout $$BRANCH; \
		test -f Makefile && make test || git checkout $(CURRENT_BRANCH); \
	done;
	git checkout $(CURRENT_BRANCH);

testdox: .check-installation
	$(PHPUNIT) -c $(PHPUNIT_XML) --testdox tests/

coverage: .check-installation
	$(PHPUNIT) -c $(PHPUNIT_XML) --coverage-text tests/	

install: clean .check-installation
	@echo "Executing a composer installation of development dependencies.."
	$(COMPOSER) install --dev

update: .check-installation
	@echo "Executing a composer update of development dependencies.."
	$(COMPOSER) update --dev

.PHONY: test clean