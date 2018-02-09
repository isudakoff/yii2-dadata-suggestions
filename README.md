# Yii2 DaData Suggestions

This extension allows you to easily get tips from service [DaData.ru](http://dadata.ru)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Run

```
php composer.phar require --prefer-dist isudakoff/yii2-dadata-suggestions "*"
```

or add

```json
"isudakoff/yii2-dadata-suggestions": "*"
```

to the `require` section of your composer.json.

## Usage

Add to config:

```php
'components' => [
    // ...
    'dadata' => [
        'class' => 'isudakoff\dadata\Suggest',
        'token' => 'your_token_here',
    ],
 ]
```

Get array of Address where needed

```php
$addresses = Yii::$app->dadata->getAddresses('москва проспект мира 10', 10);

$street = $addresses[0]->street
$city = $addresses[0]->city
$country = $addresses[0]->country
```

## TBD

- Add more types of suggestion
- Add docs
