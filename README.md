
# TECHNICAL STACK

- PHP 8.2.6

# PACKAGES
- PHPUnit 10.2.1
- PHPStan 10.10.16
- Mockery 1.6.1
- php-cs-fixer 3.17.0
- symfony/config 6.3.0
- symfony/console 6.3.0
- symfony/dependency-injection 6.3.0
- symfony/yaml 6.3.0

# USAGE
First:
```shell
composer install
```

Provide API key in config/services.yaml
```yaml
    App\Services\ExchangeRateClient:
    arguments:
      $http_client: '@App\Services\CurlHttpClient'
      $api_key: ''
```
Run tests:
```shell
composer tests
```

Run test coverage:
```shell
composer coverage
```

Run PHPStan:
```shell
composer phpstan
```

Run php-cs-fixer:
```shell
composer php-cs-fixer
```

Run command:
```shell
php app.php input.txt
```

# My comment
I was thinking if adding all this packages like symfony/console or symfony/dependency-injection is required and I decided to add it because it was easier for me to test it.

Package symfony/console is added only to have exception handler in one place and it is easy to remove.

Package symfony/dependency-injection I used to have DI in application to allows easier testing.
Declarations of services used in DI are in file config/services.yaml.

# Requirements

1. It **must** have unit tests. If you haven't written any previously, please take the time to learn it before making the task, you'll thank us later.
    1. Unit tests must test the actual results and still pass even when the response from remote services change (this is quite normal, exchange rates change every day). This is best accomplished by using mocking.
    > I made unit tests which are not using physical API so API key for example is not required to run tests. 
2. As an improvement, add ceiling of commissions by cents. For example, `0.46180...` should become `0.47`.
    > Rounding is made on the last step - in the presentation layer. All values which are inside services have the greatest accuracy they can have.
1. It should give the same result as original code in case there are no failures, except for the additional ceiling.
    > Values are mostly close to the example but as we know the currency rate is changing.
1. Code should be extendible – we should not need to change existing, already tested functionality to accomplish the following:
    1. Switch our currency rates provider (different URL, different response format and structure, possibly some authentication);
    > Just create new implementation of interface IExchangeRateClient and replace definition in services.yaml
    2. Switch our BIN provider (different URL, different response format and structure, possibly some authentication);
    > Same as above, just make changes in services.yaml
    3. Just to note – no need to implement anything additional. Just structure your code so that we could implement that later on without braking our tests;
    > No additional code added.
1. It should look as you'd write it yourself in production – consistent, readable, structured. Anything we'll find in the code, we'll treat as if you'd write it yourself. Basically it's better to just look at the existing code and re-write it from scratch. For example, if `'yes'`/`'no'`, ugly parsing code or `die` statements are left in the solution, we'd treat it as an instant red flag.
    > Tried to do my best to provide clean and understandable code.
1. Use composer to install testing framework and any needed dependencies you'd like to use, also for enabling autoloading.
    > Composer was used and all packages which I wanted are added into required section.
1. Do not use *** name in titles, descriptions or the code itself. This helps others to find the libraries that are really related to our services and/or are developed and maintained by our team.
    > Checked.

# TODO:
- maybe rewrite HTTP client to use PSR-7 and PSR-18 rules 
