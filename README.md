yii-airbrake
============

Allows errors and exceptions in yii to be sent to an airbrake server.

Usage
-----

yii-airbrake is installed by adding `Bogsey/yii-airbrake` to the "require" section of your `composer.json` file and running composer update.
This will install both the component and also the php-airbrake library.

Next update your config file as follows:

```php
return array(
  ...
  'aliases' => array(
    ...
    'Airbrake' => 'route to php-airbrake.src.Airbrake', // This is needed for the namespacing to work
    ...
  ),
  ...
  'components' => array(
    ...
    'errorHandler' => array(
      'class' => 'Route to MErrorHandler', // where composer puts your required file (eg. vendor)
      'errorAction' => 'site/error',
      'APIKey' => 'YOUR API KEY',
      'options' => array( // configuration options
          'host' => 'Airbrake Host Server',
      ),
      ...
  ),
```
You should then see your exceptions and errors appearing on your Airbrake server
