TQT
===
Yii2 TQT

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ginkgo/yii2-tqt "*"
```

or add

```
"ginkgo/yii2-tqt": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Use it in component :

```php
    'components' => [
        'tqt' => [
            'class' => 'ginkgo\tqt\Client',
            'appid' => 'YOUR_APPID',
            'secret' => 'YOUR_SECRET',
        ],
    ],

    $response = Yii::$app->tqt->get('URL', ['PARAMS']);
```
