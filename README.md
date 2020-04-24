[![Travis](https://img.shields.io/travis/phpro/api-problem/master.svg)](http://travis-ci.org/phpro/api-problem)
[![Installs](https://img.shields.io/packagist/dt/phpro/api-problem.svg)](https://packagist.org/packages/phpro/api-problem/stats)
[![Packagist](https://img.shields.io/packagist/v/phpro/api-problem.svg)](https://packagist.org/packages/phpro/api-problem)

# Api Problem

This package provides a [RFC7807](https://tools.ietf.org/html/rfc7807) Problem details implementation.
It can be integrated everywhere in your code and should result in a general error response format for HTTP APis.

This package only provides a generic interface, an exception class and some built-in api problem messages.
Since handling the exceptions is up to the framework, here is a list of known framework integrations:

- **Symfony** `^4.1`: [ApiProblemBundle](https://www.github.com/phpro/api-problem-bundle)

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

- General problems
  - [ExceptionApiProblem](#exceptionapiproblem)
  - [HttpApiProblem](#httpapiproblem)

- Symfony integration problems
  - [ValidationApiProblem](#validationapiproblem)

- Http problems
  - 400 [BadRequestProblem](#badrequestproblem)
  - 401 [UnauthorizedProblem](#unauthorizedproblem)
  - 403 [ForbiddenProblem](#forbiddenproblem)
  - 404 [NotFoundProblem](#notfoundproblem)
  - 405 [MethodNotAllowedProblem](#methodnotallowedproblem)
  - 409 [ConflictProblem](#conflictproblem)
  - 412 [PreconditionFailedProblem](#preconditionfailedproblem)
  - 415 [UnsupportedMediaTypeProblem](#unsupportedmediatypeproblem)
  - 418 [IAmATeapotProblem](#iamateapotproblem)
  - 422 [UnprocessableEntityProblem](#unprocessableentityproblem)
  - 423 [LockedProblem](#lockedproblem)
  - 428 [PreconditionRequiredProblem](#preconditionrequiredproblem)

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
    "trace": [
         "#0 [internal function]: ...",
         "#1 [internal function]: ...",
         "#3 [internal function]: ...",
         "..."
    ],
    "previous": [
      {
        "message": "previous",
        "type": "InvalidArgumentException",
        "code": 0,
        "line": 20,
        "file": "exception.php",
        "trace": [
            "#0 [internal function]: ...",
            "#1 [internal function]: ...",
            "#3 [internal function]: ...",
            "..."
        ]
      }
    ]
  }
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

#### BadRequestProblem

```php
use Phpro\ApiProblem\Http\BadRequestProblem;

new BadRequestProblem('Bad request. Bad!.');
```

```json
{
    "status": 400,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Bad Request",
    "detail": "Bad request. Bad!"
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

#### MethodNotAllowedProblem

```php
use Phpro\ApiProblem\Http\MethodNotAllowedProblem;

new MethodNotAllowedProblem('Only POST and GET allowed.');
```

```json
{
    "status": 405,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Method Not Allowed",
    "detail": "Only POST and GET allowed."
}
````

#### ConflictProblem

```php
use Phpro\ApiProblem\Http\ConflictProblem;
new ConflictProblem('Duplicated key for book with ID 20.');
```

```json
{
    "status": 409,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Conflict",
    "detail": "Duplicated key for book with ID 20."
}
````

#### PreconditionFailedProblem

```php
use Phpro\ApiProblem\Http\PreconditionFailedProblem;

new PreconditionFailedProblem('Incorrect entity tag provided.');
```

```json
{
    "status": 412,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Precondition Failed",
    "detail": "Incorrect entity tag provided."
}
````

#### UnsupportedMediaTypeProblem

```php
use Phpro\ApiProblem\Http\UnsupportedMediaTypeProblem;

new UnsupportedMediaTypeProblem('Please provide valid JSON.');
```

```json
{
    "status": 415,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Unsupported Media Type",
    "detail": "Please provide valid JSON."
}
````

#### IAmATeapotProblem

```php
use Phpro\ApiProblem\Http\IAmATeapotProblem;

new IAmATeapotProblem('More tea please.');
```

```json
{
    "status": 418,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "I'm a teapot",
    "detail": "More tea please."
}
````

#### UnprocessableEntityProblem

```php
use Phpro\ApiProblem\Http\UnprocessableEntityProblem;

new UnprocessableEntityProblem('Unable to process the contained instructions.');
```

```json
{
    "status": 422,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Unprocessable Entity",
    "detail": "Unable to process the contained instructions."
}
````

#### LockedProblem

```php
use Phpro\ApiProblem\Http\LockedProblem;

new LockedProblem('This door is locked.');
```

```json
{
    "status": 423,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Locked",
    "detail": "This door is locked."
}
````

#### PreconditionRequiredProblem

```php
use Phpro\ApiProblem\Http\PreconditionRequiredProblem;

new PreconditionRequiredProblem('If-match header is required.');
```

```json
{
    "status": 428,
    "type": "http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html",
    "title": "Precondition Required",
    "detail": "If-match header is required."
}
````

### Creating your own problem

Creating problem sounds scary right!?
Since the RFC is very loose, we made the interface as easy as possible:

```php
use Phpro\ApiProblem\ApiProblemInterface;

class MyProblem implements ApiProblemInterface
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
            'title' => 'Got 99 problems but a glitch ain\'t one!',
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
