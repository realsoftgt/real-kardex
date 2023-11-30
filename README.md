# Real Kardex

[![Latest Version on Packagist](https://img.shields.io/packagist/v/realsoftgt/real-kardex.svg?style=flat-square)](https://packagist.org/packages/realsoftgt/real-kardex)
[![Total Downloads](https://img.shields.io/packagist/dt/realsoftgt/real-kardex.svg?style=flat-square)](https://packagist.org/packages/realsoftgt/real-kardex)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Keep stock for Eloquent models. This package will track stock mutations for your models. You can increase, decrease, clear and set stock. It's also possible to check if a model is in stock (on a certain date/time).

## Installation

You can install the package via composer:

``` bash
composer require realsoftgt/real-kardex
```

By running `php artisan vendor:publish --provider="RealSoft\RealKardex\KardexServiceProvider"` in your project all files for this package will be published. Run `php artisan migrate` to migrate the table. There will now be a `stock_mutations` table in your database.

The configuration file looks this:
```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default table name
    |--------------------------------------------------------------------------
    |
    | Table name to use to store mutations.
    |
    */
    
    'table' => 'stock_mutations',
    
    'stock_mutation_model' => RealSoft\RealKardex\StockMutation::class,
];
```

## Usage

Adding the `HasKardex` trait will enable stock functionality on the Model.

> **Note:** If you need to use a custom Model for example for MongoDB you can update the model to use in the config file `kardex.php`.

``` php
use RealSoft\RealKardex\HasKardex;

class Item extends Model
{
    use HasKardex;
}
```

### Basic mutations

```php
$book->increaseStock(10);
$book->decreaseStock(10);
$book->mutateStock(10);
$book->mutateStock(-10);
```
With warehouse support
```php
$book->increaseStock(10, ['warehouse' => $warehouse_first]);
$book->decreaseStock(10, ['warehouse' => $warehouse_first]);
$book->mutateStock(10, ['warehouse' => $warehouse_first]);
$book->mutateStock(-10, ['warehouse' => $warehouse_first]);
```

### Clearing stock

It's also possible to clear the stock and directly setting a new value.

```php
$book->clearStock();
$book->clearStock(10);
// With warehouse
$book->clearStock(10, ['warehouse' => $warehouse_first]);
```

### Setting stock

It is possible to set stock. This will create a new mutation with the difference between the old and new value.

```php
$book->setStock(10);
```

### Check if model is in stock

It's also possible to check if a product is in stock (with a minimal value).

```php
$book->inStock();
$book->inStock(10);
```
With warehouse
```php
$book->inStock(); // anywhere
$book->inStock(10);
$book->inStock(10, ['warehouse' => $warehouse_first]);
```

### Current stock

Get the current stock value (on a certain date).

```php
$book->stock;
$book->stock(Carbon::now()->subDays(10));
```

> **Note:** If you are using MongoDb you need to set the date class in the config file.
> `'special_date_class' => \MongoDB\BSON\UTCDateTime::class,`

### Current stock in specific warehouse

Get the current stock value (on a certain date) in specific warehouse.

```php
$book->stock(null, ['warehouse' =>$warehouse_first]);
$book->stock(Carbon::now()->subDays(10), ['warehouse' =>$warehouse_first]);
```

### Move between warehouses

Move amount from source warehouse to destination warehouse.

```php
$book->moveBetweenStocks(5,$warehouse_first, $warehouse_second);
```

### Stock arguments

Add a description and/or reference model to de StockMutation.

```php
$book->increaseStock(10, [
    'description' => 'This is a description',
    'reference' => $otherModel,
]);
```

With warehouse
```php
$book->setStock(10, ['warehouse' => $warehouse_first]);
```

### Query Scopes

It is also possible to query based on stock.

```php
Book::whereInStock()->get();
Book::whereOutOfStock()->get();
```

## Testing

``` bash
composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/realsoftgt/real-kardex/graphs/contributors) :)

## About Real Software Solutions

Real Software Solutions is a small team from Guatemalan. We create (open source) tools for Web Developers and write about related subjects on [Gist](https://gists.github.com/realsoftgt). You can [follow us on Twitter](https://twitter.com/intelguasoft), [buy us a beer](https://www.paypal.me/realsoftgt/10) or [support us on Patreon](https://www.patreon.com/realsoftgt).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.