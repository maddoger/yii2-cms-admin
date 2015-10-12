Yii2 Admin Panel Module by maddoger

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist maddoger/yii2-admin "*"
```

or add

```
"maddoger/yii2-admin": "*"
```

to the require section of your `composer.json` file.


##Migration

```
./yii migrate --migrationPath="@maddoger/admin/migrations"
```

##Configuration

```
...
'modules' => [
    ...
    'admin' => [
            'class' => 'maddoger\admin\Module',
        ],
    ],
    ...
],

'defaultRoute' => 'admin/site/index',
'layout' => '@maddoger/admin/views/layouts/main.php',
...
```

##Components

```
'components' => [

    //Admin
    'urlManager' => [
        'rules' => [
            //Admin
            <action:(index|captcha|search)>' => 'admin/site/<action>',
            '<controller:(log|system-information|configuration)>/<action:(index|captcha|search)>' => 'admin/<controller>/<action>',
        ]
    ],
    'errorHandler' => [
        'errorAction' => 'admin/site/error',
    ],
...
]
```

