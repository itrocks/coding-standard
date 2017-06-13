# ITRocks PHP CodeSNiffer Codeing Standard
A coding standard to check against the ITRocks coding standards.

## Installation
### Composer
This standard can be installed with Composer dependency manager:

1. Install Composer
2. Install coding standard as a dependcy of your project

TODO
```
composer require --dev ...
```

3. Add the coding standard to the PHP_CodeSniffer install path
```
 vendor/bin/phpcs --config-set installed_paths vendor/itrocks/coding-standards
```

4. Check the installed coding standards for "ITRocks"
```
vendor/bin/phpcs -i
```

5. Done!
```
vendor/bin/phpcs --standard=ITRocks /path/to/code
```

### Stand-alone
1. Install PHP_CodeSniffer
2. Checkout this repository
```
git clone https://gitlab.bappli.com/itrocks/coding-standard
```

3. Add the coding standard to the PHP_CodeSniffer install path
```
 phpcs --config-set installed_paths path/to/ITRocks-coding-standards
```


4. Check the installed coding standards for "ITRocks"
```
phpcs -i
```

5. Done!
```
phpcs --standard=ITRocks /path/to/code
```

# Run unit tests
If you don't have already PHPUnit:
```
composer install
```

Then, run tests as following:
```
phpunit /path/to/ITRocks-coding-standards
```
