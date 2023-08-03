# php-proxies-redirects


**Maybe the simplest proxy and/or redirect engine (written in PHP)**


_Initial statement: I'm not a programmer. I'm a Systems Engineer._

Some point in time, I have been asked for help with some proxy and/or redirect engine without the ability to install any apps.

By the time I only had access to PHP and Apache to do so and additionally access to cron and to an existing lsyncd (and rsync) installation.

I made the decision to share this, maybe it is useful to someone else too and / or easily adapted to some other use cases.

So that's it: maybe an awful code but a working one.

Big help and initial inspiration from this proxy.php file from **Ioannis Varouchakis** at [https://gist.github.com/iovar/9091078](https://gist.github.com/iovar/9091078).

Tested with PHP 7.4 and 8.2.

Find the **_/path/to/backend_** and **_/path/to/frontend_** and change it to match your systems paths.

To Do:

+ listen on Path rather than Domains only;
+ logging;
+ debugging.

## Schematic

![Diagram](https://pe.soeirinho.com/img/github/php-proxies-redirects/diagram.png?v1)

## Backend

Back-office stuff.

There are some [cron](cron) config and some writable directory permissions mandatory (for control files under _synchronize folder and for backup generation).

Maybe you want to restrict writable permissions for security reasons, so all files in _synchronize directory (!! **EXCEPT** action.sh and .htaccess !!), rules.ini and *.txt (backup) files under root.

"Important" files:

+ [index.php](backend/index.php) is a simple bootstrap back-office to manage the rules creation and edition;

+ [rules.ini](backend/rules.ini) is a PHP configuration file where all rules, proxy or redirect, are written. It will synchronized to one frontend by the [action.sh](backend/_synchronize/action.sh);

+ [action.sh](backend/_synchronize/action.sh) is a bash script to be called through [cron](cron) to upload the rules.ini to one of the frontends. It requires the execute permission to the user where [cron](cron) was configured;

+ [cron](cron) runs every minute in the attached file, you may customize it to your needs.

To Do:

+ _Delete rules_

## Frontend

The [lsyncd](https://github.com/lsyncd/lsyncd) is mandatory! The config is on the [lsyncd.conf](lsyncd.conf) file.

"Important" files:

+ [.htaccess](frontend/.htaccess) config all requests to go to [index.php](frontend/index.php) using the mod_rewrite Apache module;

+ [index.php](frontend/index.php) is the one who will get all requests and make proxy or redirect stuff based on the requests received;

+ [lsyncd.conf](lsyncd.conf) is the [lsyncd](https://github.com/lsyncd/lsyncd) config file. It must be installed and configured in all frontends (3 frontends are considered: srv1.local, srv2.local and srv3.local. The attached [config example](lsyncd.conf) is for srv1.local that synchronize to srv2 and srv3. Config for srv2.local would synchronize to srv1 and srv3 and, at last, config for srv3.local would synchronize to srv1 ans srv2 for full redundancy and synchronization).

