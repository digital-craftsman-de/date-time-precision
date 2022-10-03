# Utility wrapper for DateTime to work with date and time

A Symfony bundle to work with id and id list value objects in Symfony. It includes Symfony normalizers for automatic normalization and denormalization and Doctrine types to store the ids and id lists directly in the database.  

As it's a central part of an application, it's tested thoroughly.

[![Latest Stable Version](http://poser.pugx.org/digital-craftsman/date-time-utils/v)](https://packagist.org/packages/digital-craftsman/date-time-utils)
[![PHP Version Require](http://poser.pugx.org/digital-craftsman/date-time-utils/require/php)](https://packagist.org/packages/digital-craftsman/date-time-utils)
[![codecov](https://codecov.io/gh/digital-craftsman-de/date-time-utils/branch/main/graph/badge.svg?token=BL0JKZYLBG)](https://codecov.io/gh/digital-craftsman-de/date-time-utils)
[![Total Downloads](http://poser.pugx.org/digital-craftsman/date-time-utils/downloads)](https://packagist.org/packages/digital-craftsman/date-time-utils)
[![License](http://poser.pugx.org/digital-craftsman/date-time-utils/license)](https://packagist.org/packages/digital-craftsman/date-time-utils)

## Installation and configuration

Install package through composer:

```shell
composer require digital-craftsman/date-time-utils
```

> ⚠️ This bundle can be used (and is being used) in production, but hasn't reached version 1.0 yet. Therefore, there will be breaking changes between minor versions. I'd recommend that you require the bundle only with the current minor version like `composer require digital-craftsman/date-time-utils:0.1.*`. Breaking changes are described in the releases and [the changelog](./CHANGELOG.md). Updates are described in the [upgrade guide](./UPGRADE.md).
