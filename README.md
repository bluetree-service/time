Bluetree PSR-6 & PSR-16 time
=============================

[![Latest Stable Version](https://poser.pugx.org/bluetree-service/cache/v/stable.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/cache)
[![Total Downloads](https://poser.pugx.org/bluetree-service/cache/downloads.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/cache)
[![License](https://poser.pugx.org/bluetree-service/cache/license.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/cache)

[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=bugs)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=coverage)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_time&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)

[![SonarQube Cloud](https://sonarcloud.io/images/project_badges/sonarcloud-dark.svg)](https://sonarcloud.io/summary/new_code?id=bluetree-service_time)

PSR-6 and/or PSR-16 time system, based on file storage.

### Included libraries
* **BlueTime\Simple\Date** - Basic class for time handling, contain static methods
* **BlueTime\Calculation** - Abstract class, contain some time calculation methods
* **BlueTime\Date** - Time object, contain some methods for time handling

Documentation
--------------
* [PSR-6 time](https://github.com/bluetree-service/time/blob/develop/doc/psr-6-time.md "PSR-6 time")
* [PSR-16 time](https://github.com/bluetree-service/time/blob/develop/doc/psr-16-time.md "PSR-16 time")
* [File storage](https://github.com/bluetree-service/time/blob/develop/doc/FileStorage.md "File storage")


Install via Composer
--------------
To use packages you can just download package and pace it in your code. But recommended
way to use _BlueTime_ is install it via Composer. To include _BlueTime_
libraries paste into composer json:

```json
{
    "require": {
        "bluetree-service/time": "version_number"
    }
}
```

Project description
--------------

### Used conventions

* **Namespaces** - each library use namespaces
* **PSR-2** - [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standard
* **PSR-4** - [PSR-4](http://www.php-fig.org/psr/psr-4/) auto loading standard
* **PSR-6** - [PSR-6](http://www.php-fig.org/psr/psr-6/) time standard
* **PSR-16** - [PSR-16](http://www.php-fig.org/psr/psr-16/) time standard
* **Composer** - [Composer](https://getcomposer.org/)

### Requirements

* PHP 8.2 or higher

License
--------------
This bundle is released under the Apache license.  
[Apache license](https://github.com/bluetree-service/time/LICENSE "Apache license")
