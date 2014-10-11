yii2-generators
===============

Yii2 custom generator

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

At your `composer.json` file, add the following code
```
	"repositories": [
        ...
        {
            "type": "git",
            "url": "https://github.com/mdmsoft/yii2-gii"
        }
    ],
	"require": {
		...
	},
	"require-dev": {
		...
		"mdmsoft/yii2-gii": "*"
	},
```

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
        ]
    ];
}

```
