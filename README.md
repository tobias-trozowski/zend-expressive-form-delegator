# zend-expressive-form-delegator

[![License](https://poser.pugx.org/tobias/zend-expressive-form-delegator/license)](https://packagist.org/packages/tobias/zend-expressive-form-delegator)
[![Latest Stable Version](https://poser.pugx.org/tobias/zend-expressive-form-delegator/v/stable)](https://packagist.org/packages/tobias/zend-expressive-form-delegator)
[![PHP 7 ready](http://php7ready.timesplinter.ch/tobias-trozowski/zend-expressive-form-delegator/badge.svg)](https://travis-ci.org/tobias-trozowski/zend-expressive-form-delegator)
[![Build Status](https://travis-ci.org/tobias-trozowski/zend-expressive-form-delegator.svg?branch=master)](https://travis-ci.org/tobias-trozowski/zend-expressive-form-delegator)
[![Coverage Status](https://coveralls.io/repos/tobias-trozowski/zend-expressive-form-delegator/badge.svg?branch=master)](https://coveralls.io/r/tobias-trozowski/zend-expressive-form-delegator?branch=master)
[![Total Downloads](https://poser.pugx.org/tobias/zend-expressive-form-delegator/downloads)](https://packagist.org/packages/tobias/zend-expressive-form-delegator)


Delegator for Zend [FormElementManager](https://github.com/zendframework/zend-form)

This package provides a delegator for the FormElementManager which configures the PluginManager to use the service configuration from ```form_elements``` from your config.

The package is intended to be used with [Zend Expressive Skeleton](https://github.com/zendframework/zend-expressive-skeleton) or any other [Zend Expressive](https://github.com/zendframework/zend-expressive) application.


## Installation

The easiest way to install this package is through composer:

```bash
$ composer require tobias/zend-expressive-form-delegator
```

## Configuration

In the general case where you are only using a single connection, it's enough to define the delegator factory for the FormElementManager:

```php
return [
    'dependencies' => [
        'delegators' => [
            'FormElementManager' => [
                \Tobias\Expressive\Form\FormElementManagerDelegatorFactory::class,
            ],
        ],
    ],
];
```

### Using Expressive Config Manager

If you're using the [Expressive Config Manager](https://github.com/mtymek/expressive-config-manager) you can easily add the ConfigProvider class.

```php
$configManager = new ConfigManager(
    [
        \Tobias\Expressive\Form\ConfigProvider::class,
    ]
);
```