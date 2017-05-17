# Magento 2 Development tool

## Installation in a new Project

##### Update the project composer.json file as follows:

```
"require": {
    "staempfli/mage2-n98-magerun2": "dev-master"
},
"require-dev": {
	"staempfli/mage2-dev-tool": "dev-master"
},
"scripts": {
	"setPermissionsBin": "chmod -R +x bin",
    "symlinkDevTool": "[ ! -d magento/vendor/staempfli/mage2-dev-tool ] || (ln -sf magento/vendor/staempfli/mage2-dev-tool/build.xml . && ln -sf magento/vendor/staempfli/mage2-dev-tool/build .)",
	"post-install-cmd": [
		"@setPermissionsBin",
		"@symlinkDevTool"
    ],
    "post-update-cmd": [
     	"@setPermissionsBin",
        "@symlinkDevTool"
    ]
},
"config": {
	"secure-http": false,
	"bin-dir": "bin",
	"vendor-dir": "magento/vendor"
}

```

##### Update the project .gitignore as follows:

```
/magento #Important: add the slash in order to ignore only the root folder. /config/magento is needed in the repo.
/bin
/build
/build.xml

```

##### Run composer update to get the development-tool-dependency:

`$ composer update`


##### Create config folder:

`$ cp -r vendor/staempfli/mage2-dev-tool/config/ config`

##### Create log folder:

```
$ mkdir logs
$ vim logs/.gitignore
# Ignore everything in this directory
*
# Except this file
!.gitignore
```

##### Setup Build and Sync configuration:
	
* Set the specific core_config_data for the different environments

	* You can use the property ${project.name} to automatically set the value of the project root folder here.

```
$ mv config/magento/config.yaml.dist config/magento/config.yaml
vim config/magento/config.yaml
```

* Set the file templates template.

***Leave the existing placeholders ({{}}) as the will automatically replace during installation***

```
mv config/magento/env.php.template.dist config/magento/env.php.template
mv config/magento/install-config-mysql.php.template config/magento/install-config-mysql.php.template
mv config/vhosts/apache.local.conf.dist config/vhosts/apache.local.conf
mv config/vhosts/nginx.local.conf.dist config/vhosts/nginx.local.conf

```

* Set the servers configuration to sync data from:

```
mv config/servers/config.yaml.dist config/servers/config.yaml
vim config/servers/config.yaml
```


* Set specific Project properties if needed. This step is only required if the project has something different from the other Magento projects

```
mv config/project.properties.dist config/project.properties
vim config/project.properties
```

##### Ready to Use
* You can test that everything works fine:

`$ bin/phing install`

### TIPS
If you are tired of writing over and over again some of the questions during the process, you can setup your default environment parameters as follows:

1. Create the folder `_conf` one level higher that your project root. That would be into the folder where you usually have all the projects

2. Add a file called `environment.properties` inside that folder:

`$ vim _conf/environment.properties`


3. Inside this file you specify some of your default environment preferences as follows:

```
project.environment=<your_environment_type> (usually Local)
database.admin.username=<your_database_admin_user>
environment.server.type=<your_server_type> (apache or nginx)
environment.vhosts.dir=<your_preferred_vhost.d_path>
```


## How to use it in a project
You can use the development tools as follows:

* List available targets:
	* `$ bin/phing -l`
* Project setup:
	* `$ bin/phing install`
* Copy data from server:
	* `$ bin/phing sync`

## How to use from a composer dependency

* `$ <path_to_project_root>/bin/phing -f <path_to_project_root>/build.xml <target>`

* Example: `$ ../../../../bin/phing -f ../../../../build.xml -l`

## Prerequisites

- PHP >= 7.0.*
- Mysql >= 5.7.*