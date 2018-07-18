# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [2.1.3] - 22-06-2018

### Added
- Allow `project.name` provision

## [2.1.2] - 22-06-2018

### Added
- `magento:install` and `magento:setup:upgrade` are executed in `--no-interaction` mode, when possible.

## [2.1] - 8-05-2018

### Changed
- `EnsureConfiguration` has been updated to use out of the box magento `config:set` available on versions >=2.2
- `config.yaml` file has a different format now according to previous commented change. See [Sample config.yaml](config.sample/mg2-builder/magento/config.yaml)

## [2.0] - 14-12-2017
### Added
- New `artifact:transfer` to build and transfer artifacts. Uses config propagation features in `Magento >= 2.2`
- New `tests-setup:install` to create integration test DB and settings without the need to install magento.
- New `config/project.properties` to be able to share configurations with [magento2-deployment-tool](https://github.com/staempfli/magento2-deployment-tool)

### Changed
- `config/mg2-builder/project.properties` moved to `config/mg2-builder/build.properties`
- Dependency should now be installed in `required` instead of `required-dev`. Needed to be able to use the new `artifact:transfer` feature.
- `release.deploy.server.command` updated to also set `-Dbuild.project.type` option.

### Removed
- `config/mg2-builder/project.properties` moved to `config/project.properties`
