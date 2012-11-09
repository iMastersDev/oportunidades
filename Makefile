COMPOSER = php composer.phar
VENDOR_DIR = vendor
BIN_DIR = bin
PHPUNIT = $(BIN_DIR)/phpunit
PHPUNIT_XML = tests/phpunit.xml
PHPCS = $(BIN_DIR)/phpcs
PHPCS_STANDARD = PSR2
CURRENT_BRANCH := $(shell git branch | grep '*' | cut -d ' ' -f 2)
BRANCHES := $(shell git branch | grep -v "$(CURRENT_BRANCH)" | tr -d " " | tr "\\n" " ")
GIT_STAGE := $(shell git status -s | wc -l | tr -d " ")

.check-composer:
	@echo "Checking if Composer is installed..."
	@test -f composer.phar || curl -s http://getcomposer.org/installer | php;

.check-installation: .check-composer
	@echo "Checking for vendor directory..."
	@test -d $(VENDOR_DIR) || make install
	@echo "Checking for bin directory..."
	@test -d $(BIN_DIR) || make install

.check-no-changes:
	@echo "Checking if git stage is clean..."
	@test $(GIT_STAGE) -eq "0" || exit 10;
	@echo "Git stage is clean."

clean:
	@echo "Removing Composer..."
	rm -f composer.phar
	rm -f composer.lock
	rm -rf $(VENDOR_DIR)
	rm -f bin/phpunit
	rm -f bin/phpcs

test: .check-installation
	$(PHPUNIT) -c $(PHPUNIT_XML) tests/

test-branches: .check-no-changes
	@echo "Current branch: $(CURRENT_BRANCH)";
	@echo "Branches to run on: $(BRANCHES)"
	@$(foreach branch,$(BRANCHES), git checkout $(branch) & test -f Makefile & make test)

testdox: .check-installation
	$(PHPUNIT) -c $(PHPUNIT_XML) --testdox tests/

coverage: .check-installation
	$(PHPUNIT) -c $(PHPUNIT_XML) --coverage-text tests/	

install: clean .check-composer
	@echo "Executing a composer installation of development dependencies.."
	$(COMPOSER) install --dev

update: .check-installation
	@echo "Executing a composer update of development dependencies.."
	$(COMPOSER) update --dev

code-sniffer: .check-installation
	$(PHPCS) --standard=$(PHPCS_STANDARD) src/

code-sniffer-report: .check-installation
	$(PHPCS) --report-summary --report-source --report-gitblame --standard=$(PHPCS_STANDARD) src

.PHONY: test clean