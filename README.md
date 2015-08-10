[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tonis-io/oauth2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tonis-io/oauth2/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tonis-io/oauth2/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tonis-io/oauth2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tonis-io/oauth2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tonis-io/oauth2/build-status/master)

# Tonis\OAuth2

Tonis\OAuth2 is an OAuth2 server package on top of `league\oauth2-server` and `tonis-io\doctrine-orm`.

Composer
--------

```
composer require tonis-io/oauth2
```

Usage
-----

```php
$app = new Tonis\App;
$app->package(new Tonis\OAuth2\Package);
```
