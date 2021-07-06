# tada-template-entity

![Container diagram for Template Entity](http://www.plantuml.com/plantuml/png/DOn13a8X30Ntda8FyEdUrRzAXKP8saBWDSRRYuk_caaccNE19yBqzcYUDOh4r7i5ndeIJVwaTqEDLooPkJl4aN8t0XS-8BbUPaCPSkpUy2NZvcIzX4eQ__ifNZP_)


# Template_Entity

Template for creating simple Entity.

Generate Schema Whitelist:

- bin/magento setup:db-declaration:generate-whitelist --module-name=Tada_TemplateEntity

Test note:
- Require-dev: "mockery/mockery": "^0.9.9"
- Run Unit test: ./vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist app/code/Tada/TemplateEntity/Test/Unit
- Run Integration test:
  - cd dev/tests/integration
  - ../../../vendor/bin/phpunit ../../../app/code/Tada/TemplateEntity/Test/Integration
    
Replace Instruction:
 - Copy this module folder to another folder at the same vendor with name is \<ModuleName>.
 - Replacing in files of \<ModuleName> folder :
    - TemplateEntity to \<ModuleName> : replace module name, and namespace
    - Tada_TemplateEntity to \<Vendor>_\<ModuleName> : replace Registration's module name.
    - template_entity to \<module_name> : replace table name
 - Rename some files below: 
    - Api folder: 
        - Data/TemplateEntityInterface.php to Data/\<ModuleName>Interface.php
        - TemplateEntityRepositoryInterface.php to \<ModuleName>RepositoryInterface.php
    - Model folder: 
        - TemplateEntity.php to \<ModuleName>.php
        - TemplateEntityRepository.php to \<ModuleName>Repository.php
        - ResourceModel/TemplateEntity.php to ResourceModel/\<ModuleName>.php
        - Rename ResourceModel/TemplateEntity folder to ResourceModel/\<ModuleName> folder
   - Test folder:
        - Integration folder:
            - rename TemplateEntityRepositoryTest.php to \<ModuleName>RepositoryTest.php
        - Unit folder:
            - rename TemplateEntityRepositoryTest.php to \<ModuleName>RepositoryTest.php
   - Replace name attribute in composer.json:
        - tada/template-entity to <vendor>/<module-name>


# Changelog
- 1.0.0 Initial version
