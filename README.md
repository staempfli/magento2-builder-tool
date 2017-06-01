# Magento 2 Builder tool

Tool to automatically build Magento2 projects and sync data from remote servers

## Installation

```
composer require --dev "staempfli/magento2-builder-tool":"~1.0"
```

## Setup

### Required Packages

To use `sync` capabilities, this tool requires that [n98-magerun2](https://github.com/netz98/n98-magerun2) is installed in your project:

```
composer require "n98/magerun2":"^1.4"
```

### Settings configuration

#### Create config

```
cp -r <vendor_path>/staempfli/magento2-builder-tool/config.sample/ config
```

* Set your custom default `core_config_data` settings on `config/mg2-builder/magento/config.yaml`
* Set servers configuration on `config.sample/mg2-builder/server/config.yaml`

**NOTE:** You only need to replace parameters between `<>` with your corresponding values. All other placehoders like `${}` or `{{}}` will be automatically replaced during the tool execution

#### Create logs folder

```
mkdir logs
vim logs/.gitignore
# Ignore everything in this directory
*
# Except this file
!.gitignore
```

#### Properties

You can customise all properties according to your needs:

* Properties added in `config/mg2-builder/project.properties` have the highest priority and will overwrite default ones
* You can check all default properties that can be customised on:
	* [build/config/default.properties](build/config/default.properties)

## Usage

* List available targets:

	* `bin/mg2-builder -l`

* Project install:

	* `bin/mg2-builder install`

* Sync data from server:

	* `bin/mg2-builder sync`

### TIPS
If you are tired of writing over and over again some of the questions during the process, you can setup your default environment parameters as follows:

1. Create the folder `_conf` one level higher than your project root.

2. Add a file called `environment.properties` inside that folder.

3. Inside this file you can specify your default environment preferences as follows:

```
project.environment=<your_environment_type> (usually Local)
database.admin.username=<your_database_admin_user>
environment.server.type=<your_server_type> (apache or nginx)
environment.vhosts.dir=<your_preferred_vhost.d_path>
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