[![Travis](https://img.shields.io/travis/phpro/api-problem/master.svg)](http://travis-ci.org/phpro/api-problem)
[![Installs](https://img.shields.io/packagist/dt/phpro/api-problem.svg)](https://packagist.org/packages/phpro/api-problem/stats)
[![Packagist](https://img.shields.io/packagist/v/phpro/api-problem.svg)](https://packagist.org/packages/phpro/api-problem)


# Api Problem

This package provides a [RFC7807](https://tools.ietf.org/html/rfc7807) Problem details implementation.
It can be integrated everywhere in your code and should result in a general error response format for HTTP APis.

This package only provides a generic interface, an exception class and some built-in api problem messages.
Since handling the exceptions is up to the framework, here is a list of known framework integrations:

- **Symfony** `^4.1`: [ApiProblemBundle](https://www.github.com.phpro/api-problem-bundle)


## Installation

```sh
composer require phpro/api-problem
```

## Usage

This package provides a general interface for creating ApiProblem value objects.

```php
use Phpro\ApiProblem\Exception;

throw new ApiProblemException(
    new HttpApiProblem(418, ['detail' => 'Did you know 4,000 people are injured by teapots every year?!'])
);
```

### Built-in problems

- [ExceptionApiProblem](#exceptionapiproblem)
- [ForbiddenProblem](#forbiddenproblem)
- [HttpApiProblem](#httpapiproblem)
- [NotFoundProblem](#notfoundproblem)
- [UnauthorizedProblem](#unauthorizedproblem)
- [ValidationApiProblem](#validationapiproblem)

#### ExceptionApiProblem

*Debuggable*: The `exception` part will only be added in debug context!

```php
use Phpro\ApiProblem\Http\ExceptionApiProblem;

new ExceptionApiProblem(new \Exception('message', 500));
```

```json
{
  "status": 500,
  "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
  "title": "Internal Server Error",
  "detail": "message",
  "exception": {
    "message": "message",
    "type": "RuntimeException",
    "code": 500,
    "line": 23,
    "file": "exception.php",
    "trace": "#0 [internal function]: ...",
    "previous": [
      {
        "message": "previous",
        "type": "InvalidArgumentException",
        "code": 0,
        "line": 20,
        "file": "exception.php",
        "trace": "#0 [internal function]: ..."
      }
    ]
  }
}
````

#### ForbiddenProblem

```php
use Phpro\ApiProblem\Http\ForbiddenProblem;

new ForbiddenProblem('Not authorized to access gold.');
```

```json
{
  "status": 403,
  "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
  "title": "Forbidden",
  "detail": "Not authorized to access gold."
}
````

#### HttpApiProblem

```php
use Phpro\ApiProblem\Http\HttpApiProblem;

new HttpApiProblem(404, ['detail' => 'The book could not be found.']);
```

```json
{
    "status": 404,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Not found",
    "detail": "The book could not be found."
}
````

#### NotFoundProblem

```php
use Phpro\ApiProblem\Http\NotFoundProblem;

new NotFoundProblem('The book with ID 20 could not be found.');
```

```json
{
    "status": 404,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Not found",
    "detail": "The book with ID 20 could not be found."
}
````

#### UnauthorizedProblem

```php
use Phpro\ApiProblem\Http\UnauthorizedProblem;

new UnauthorizedProblem('You are not authorized to access X.');
```

```json
{
    "status": 401,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Unauthorized",
    "detail": "You are not authenticated. Please login."
}
````

#### ValidationApiProblem

```sh
composer require symfony/validator:^4.1
```

```php
use Phpro\ApiProblem\Http\ValidationApiProblem;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

new ValidationApiProblem(new ConstraintViolationList([
    new ConstraintViolation('Invalid email', '', [], '', 'email', '', null, '8615ecd9-afcb-479a-9c78-8bcfe260cf2a'),
]));
```

```json
{
    "status": 400,
    "type": "https:\/\/symfony.com\/errors\/validation",
    "title": "Validation Failed",
    "detail": "email: Invalid Email",
    "violations": [
        {
            "propertyPath": "email",
            "title": "Invalid email",
            "type": "urn:uuid:8615ecd9-afcb-479a-9c78-8bcfe260cf2a"
        }
    ]
}
````


### Creating your own problem

Creating problem sounds scarry right!?
Since the RFC is very loose, we made the interface as easy as possible:

```php
use Phpro\ApiProblem\ApiProblemInterface;

class MyProblem implements ApiProbelmInterface
{
    public function toArray(): array
    {
        return [
            'type' => 'about:blank',
            'status' => '99',
            'title' => 'Got 99 problems but a glitch aint one!',
        ];
    }
}
```

A lot of problems will be detected in an HTTP context. Therefore, we also provided a base `HttpApiProblem` class.
This one will automatically fill in the type and title section based on the HTTP code.
The only thing you'll need to do, is add some additional data to it:

```php
use Phpro\ApiProblem\Http\HttpApiProblem;

class MyProblem extends HttpApiProblem
{
    public function __construct(string $details)
    {
        parent::__construct(500, ['details' => $details]);
    }
}
```

If you want to log additional information in a debug context, it is possible to implement an additional `DebuggableApiProblemInterface`:

```php
use Phpro\ApiProblem\DebuggableApiProblemInterface;

class MyProblem implements DebuggableApiProblemInterface
{
    public function toArray(): array
    {
        return [
            'type' => 'about:blank',
            'status' => '99',
            'title' => 'Got 99 problems but a glitch aint one!',
        ];
    }

    public function toDebuggableArray(): array
    {
        return array_merge(
            $this->toArray(),
            [
                'situation' => 'If you are having code problems, I feel bad for you son',
            ]
        );
    }
}
```

## About

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/phpro/api-problem/issues).
Please take a look at our rules before [contributing your code](CONTRIBUTING).

### License

api-problem is licensed under the [MIT License](LICENSE).
