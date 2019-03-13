Role Based Access Controll for yii2
===================================
Role Based Access Controll for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ayaalkaplin/yii2-rbac "*"
```

or add

```
"ayaalkaplin/yii2-rbac": "*"
```

to the require section of your `composer.json` file.

Models use yii2 DbManager class and required to run migration:

```
php yii migrate --migrationPath=@yii/rbac/migrations
```

Usage
-----

Once the extension is installed, simply use it in your code by adding url on your navigation bar:

```php
Url::toRoute('/rbac/permission/index');
Url::toRoute('/rbac/role/index');
Url::toRoute('/rbac/user/index');
```

This controllers are allowed for `admin` role