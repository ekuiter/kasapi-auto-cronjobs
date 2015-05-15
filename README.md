#kasapi-auto-cronjobs

##(De)activate your All-Inkl cronjobs automatically

If you need to control your All-Inkl / KAS cronjobs in an automatic way, you might want to check out this script.
It activates / deactivates cronjobs based on a condition - your cronjobs can be activated in the morning
and deactivated in the evening, for example.

Personally, I use this to keep my free Heroku instances awake during the day and make them sleep during the night
because Heroku now forces free apps to sleep at least 6 hours a day - which is why my "wake-up" cronjobs can't run
all the time.

To configure your cronjobs, check out `config.inc.template.php` and remember to rename it to `config.inc.php`.

Whenever the script changes one of your cronjobs' status, it adds an `[auto]` hint before the cronjob comment. This
helps you to recognize in KAS which cronjobs are managed by this script. If you want to change / remove the `[auto]`
notice, take a look at `KasApi/KasCronjob.php`.

The script relies on [Composer](https://getcomposer.org) and the [wazaari/kasapi-php](https://packagist.org/packages/wazaari/kasapi-php)
package. Run `composer update` to update the dependency. (You don't need Composer to just use the script.)

With some modifications, you could change the script to not (de)activate your cronjobs but set some other properties.
It could even be used for something entirely else - dynamic subdomain creation etc. Feel free to contribute if you like,
just submit a pull request or mail me: [info@elias-kuiter.de](info@elias-kuiter.de)