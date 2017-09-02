# Magento 2 Builder tool

Tool to automatically build Magento2 projects and sync data from remote servers

## Installation

```
composer require --dev "staempfli/magento2-builder-tool":"~1.0"
```

## Setup

### Config Folder

```
cp -r <vendor_path>/staempfli/magento2-builder-tool/config.sample/ config
```

* Set the project custom `core_config_data` on `config/mg2-builder/magento/config.yaml`
* Set the project servers settings on `config.sample/mg2-builder/server/config.yaml`

**NOTE:** You only need to replace parameters between `<>` with your corresponding values. All other placehoders like `${}` or `{{}}` will be automatically replaced during the tool execution

### Create logs folder

```
mkdir logs
vim logs/.gitignore
# Ignore everything in this directory
*
# Except this file
!.gitignore
```

### Custom Properties

You can customise all properties according to your needs:

* Properties added in `config/mg2-builder/project.properties` have the highest priority and will overwrite default ones
* Check all properties that can be customised here:
	* [build/config/default.properties](build/config/default.properties)

## Usage

* List available targets:

	* `bin/mg2-builder -l`

* Project install:

	* `bin/mg2-builder install`

* Sync data from server:

	* `bin/mg2-builder sync`

### TIPS
If you do not want to input over and over again the properties required, you can setup your default environment parameters as follows:

1. Create folder `_conf` at one level higher than your project root.

2. Add a new file `environment.properties` inside that folder.

3. Inside this file you can specify your environment properties as follows:

```
project.environment=<your_environment_type> (usually Local)
database.admin.username=<your_database_admin_user>
environment.server.type=<your_server_type> (apache, nginx or none)
environment.vhosts.dir=<your_preferred_vhost.d_path>
```

## Custom scripts

If you need additional scripts to build your projects, you can add them here:

* `config/mg2-builder/xmlscripts/custom.xml`

You can also define targets that will be automatically executed during the build process.
This tool contains `customHooks` that can be listened to dispatch other targets.
You can set inside `config/mg2-builder/project.properties` the targets to be executed by these hooks:

```
vim config/mg2-builder/xmlscripts/custom.xml
before-magento-install = <your-custom-target>
after-sync = <your-custom-target>
after-tests-setup-integration = <your-custom-target>
after-util-db-clean = <your-custom-target>
```

## Prerequisites

- PHP >= 7.0.*
- Mysql >= 5.7.*

## Developers

* [Juan Alonso](https://github.com/jalogut)

Licence
-------
[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

Copyright
---------
(c) 2016 Staempfli AG