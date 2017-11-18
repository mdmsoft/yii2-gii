Yii2-gii
========================
It add theming generator and new template for crud.It based on [yiisoft/yii2-gii](https://github.com/yiisoft/yii2-gii)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require-dev myzero1/yii2-gii：1.*
```

or add

```
"myzero1/yii2-gii": "~1.0.0"
```

to the require-dev section of your `composer.json` file.


Setting
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
...
if (!YII_ENV_TEST) {
    $config['bootstrap'][] = 'myzero1';
    $config['modules']['myzero1'] = [
        'class' => 'myzero1\gii\Module',
        'allowedIPs' => ['*'],
        // 'generators' => [
        //     'myzero1_mvc' => ['class' => 'myzero1\gii\generators\mvc\Generator'],
        //     'myzero1_crud' => [
        //         'class' => 'myzero1\gii\generators\crud\Generator',
        //         'templates' => [
        //             'adminlte' => '@myzero1/gii/generators/theming/default/adminlte/_gii_templates/crud',
        //         ],
        //         'template' => 'adminlte',
        //         'messageCategory' => 'backend'
        //     ],
        // ]
    ];
}
```


Usage
-----

You can then access Gii through the following URL:

```
http://localhost/path/to/index.php?r=myzero1
OR
http://localhost/path/to/index.php?r=myzero1/gii
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index.php/myzero1
OR
http://localhost/path/to/index.php/myzero1/gii
```
