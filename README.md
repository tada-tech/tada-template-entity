# Template Entity

Template for creating simple Entity.

Generate Schema Whitelist:

- bin/magento setup:db-declaration:generate-whitelist --module-name=Tada_TemplateEntity

Test note:
- Require-dev: "mockery/mockery": "^0.9.9"
- Run Unit test: ./vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist app/code/Tada/TemplateEntity/Test/Unit
- Run Integration test:
  - cd dev/tests/integration
  - ../../../vendor/bin/phpunit ../../../app/code/Tada/TemplateEntity/Test/Integration

# Changelog
- 1.0.0 Initial version
- 1.0.1 Write Unit Test

