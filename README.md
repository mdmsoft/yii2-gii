yii2-generators
===============

Yii2 custom generator

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require mdmsoft/yii2-gii "~1.0"
```

or add

```
"mdmsoft/yii2-gii": "~1.0"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
...
if (!YII_ENV_TEST) {
//     configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => ['class' => 'mdm\gii\generators\crud\Generator'],
            'mvc' => ['class' => 'mdm\gii\generators\mvc\Generator'],
            'migration' => ['class' => 'mdm\gii\generators\migration\Generator'],
        ]
    ];
}

```
