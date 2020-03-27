# 🗓 PHP Simple Calendar

[![Latest Version on Packagist](https://img.shields.io/packagist/v/breadthe/php-simple-calendar.svg?style=flat-square)](https://packagist.org/packages/breadthe/php-simple-calendar)
[![Build Status](https://img.shields.io/travis/breadthe/php-simple-calendar/master.svg?style=flat-square)](https://travis-ci.org/breadthe/php-simple-calendar)
[![Quality Score](https://img.shields.io/scrutinizer/g/breadthe/php-simple-calendar.svg?style=flat-square)](https://scrutinizer-ci.com/g/breadthe/php-simple-calendar)
[![Total Downloads](https://img.shields.io/packagist/dt/breadthe/php-simple-calendar.svg?style=flat-square)](https://packagist.org/packages/breadthe/php-simple-calendar)

This PHP 7.3+ package generates a 7 x 6 (42) or 7 x 5 (35) element array of the days of the month for the desired date. Each date is an instance of `Carbon\Carbon`.

It automatically pads the beginning/end of the month with dates from the previous/next month. It can optionally pad with `null` instead.

While it does not include an UI, you may use the generated matrix to build a month-grid calendar in the front-end technology of your choice. 

**NOTE** For now, at least, weeks start with Monday.

## Requirements

- PHP 7.3+

## Installation

You can install the package via composer:

```bash
composer require breadthe/php-simple-calendar
```

## Usage

### Calendar grid generation

```php
use Breadthe\SimpleCalendar\Calendar;

$date = '2020-03-24'; // ISO date

$calendar = new Calendar($date);
$currentMonth = $calendar->grid();

// or use the static constructor
$currentMonth = Calendar::make($date)->grid();
```

### Start of previous/next months

The start (first day) of the previous and next months is a convenience that might come in handy when building the "previous month"/"next month" navigation in a calendar UI. These properties will exist even if `padWithNull()` is called.  

```php
$date = '2020-03-17';
$currentMonth = Calendar::make($date);

$currentMonth->startOfPrevMonth; // get the start of the previous month - instance of Carbon
$currentMonth->startOfPrevMonth->toDateString(); // '2020-02-01'

$currentMonth->startOfNextMonth; // get the start of the previous month - instance of Carbon
$currentMonth->startOfNextMonth->toDateString(); // '2020-04-01'
```

### UI Example

Here's an example of a simple calendar UI that can be built with this package.

![Simple calendar UI](https://user-images.githubusercontent.com/17433578/77709612-ae1c6f80-6f99-11ea-84cb-a7eeba1d0244.png)

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email omigoshdev@protonmail.com instead of using the issue tracker.

## Credits

- [breadthe](https://github.com/breadthe)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel/PHP Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
