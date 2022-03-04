# The Simple Prop Check
The Simple Prop Check is a simple property validator.   
Enjoy!

## Installation
Execute the following composer command.
```
composer require takemo101/simple-prop-check
```

## How to use
Please use as follows

### PHP Attribute
Validate properties using PHP's Attribute feature.
```php
<?php

use Takemo101\SimplePropCheck\PropCheckFacade;
use Takemo101\SimplePropCheck\Preset\String\ {
    Email,
    Between,
    Pattern,
};
use Takemo101\SimplePropCheck\Preset\Numeric\Min;
use Takemo101\SimplePropCheck\Preset\Array\TypedValue;
use Takemo101\SimplePropCheck\Preset\NotEmpty;

/**
 * You can check the value by setting Attribute to the property of the class.
 */
class Test
{
    #[Email]
    public static string $email = 'xxx@example.com',

    public function __construct(
        #[Between(1, 10)]
        private string $between,
        // Exception message can also be set.
        #[Pattern('/[a]+/', 'not match')]
        private string $pattern,
        #[Min(3)]
        private integer $min,
        // Validate array values ​​by type.
        #[TypedValue('integer|string')]
        private array $nums,
        #[NotEmpty]
        private $notEmpty = null,
    ) {
        //
    }
}

$test = new Test(
    'hello',
    'are',
    4,
    [
        1,
        2,
        'hello',
    ]
);

// Validate the property by passing the object to the check method.
// The result is true or false.
$result = PropCheckFacade::check($test); // $result == false

//　By passing an object to the exception method, the validation result will be returned as an exception.
PropCheckFacade::checkWithException($test); // throw exception

```
### Property Attribute provided
The following Attribute class is available.

| attribute class | detail |
| - | - |
| Takemo101\SimplePropCheck\Preset\String\URL | Validate URL string |
| Takemo101\SimplePropCheck\Preset\String\Email | Validate the email address string |
| Takemo101\SimplePropCheck\Preset\String\BetweenLength | Verify the number of characters |
| Takemo101\SimplePropCheck\Preset\String\MaxLength | Verify the number of characters |
| Takemo101\SimplePropCheck\Preset\String\MinLength | Verify the number of characters |
| Takemo101\SimplePropCheck\Preset\String\Pattern | Validate regular expressions |
| Takemo101\SimplePropCheck\Preset\Array\BetweenSize | Validate the size of the array |
| Takemo101\SimplePropCheck\Preset\Array\MaxSize | Validate the size of the array |
| Takemo101\SimplePropCheck\Preset\Array\MinSize | Validate the size of the array |
| Takemo101\SimplePropCheck\Preset\Array\Unique | Verify array duplication |
| Takemo101\SimplePropCheck\Preset\Array\TypedKey | Validate the key type of the array |
| Takemo101\SimplePropCheck\Preset\Array\TypedValue | Validate the value type of the array |
| Takemo101\SimplePropCheck\Preset\Array\TypedMap | Validate array key and value types |
| Takemo101\SimplePropCheck\Preset\Numeric\Between | Verify the range of numbers |
| Takemo101\SimplePropCheck\Preset\Numeric\Max | Verify the range of numbers |
| Takemo101\SimplePropCheck\Preset\Numeric\Min | Verify the range of numbers |
| Takemo101\SimplePropCheck\Preset\Numeric\Negative | Validate negative numbers |
| Takemo101\SimplePropCheck\Preset\Numeric\Positive | Validate positive numbers |
| Takemo101\SimplePropCheck\Preset\NotNull | Validate null value |
| Takemo101\SimplePropCheck\Preset\NotEmpty | Validate empty value |

## Customize
You can customize the Attribute class etc.

### How to customize Property Attribute
First, create an Attribute class that implements AbstractValidatable or Validatable.

```php
<?php

use Takemo101\SimplePropCheck\AbstractValidatable;

/**
 * Implement the AbstractValidatable class by extending it,
 * or implement the Validatable interface.
 * 
 * @extends AbstractValidatable<string>
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MatchText extends AbstractValidatable
{
    /**
     * constructor
     *
     * @param string|null $message
     */
    public function __construct(
        private ?string $message = null,
    ) {
        //
    }

    /**
     * Verify the value of $data with the verify method.
     * Returns true if the value is not invalid.
     *
     * @param string $data
     * @return boolean returns true if the data is OK
     */
    public function verify($data): bool
    {
        return $data == $this->text;
    }

    /**
     * Returns an error message if the value of the property is incorrect
     *
     * @return string
     */
    public function message(): string
    {
        // You can use the value set by the placeholders method in the error message as a placeholder.
        return $this->message ?? "data dose not match :text";
    }

    /**
     * Returns the value available in the error message placeholder.
     *
     * @return array<string,mixed>
     */
    public function placeholders(): array
    {
        return [
            'text' => $this->text, // The placeholder will be ':text'
        ];
    }

    /**
     * Return whether the value of the property is verifiable.
     * Basically check the value type.
     *
     * @param mixed $data
     * @return bool
     */
    public function isValid($data): bool
    {
        return is_string($data);
    }

}
```
Use the created Attribute class as follows.
```php
<?php

use Takemo101\SimplePropCheck\PropCheckFacade;

class Test
{
    public function __construct(
        #[MatchText('hello')]
        private string $hello,
    ) {
        //
    }
}

$test = new Test('hi');
$result = PropCheckFacade::check($test); // $result == false

$test = new Test('hello');
$result = PropCheckFacade::check($test); // $result == true

```

### How to customize Exception Attribute
First, create an Attribute class that implements AbstractException or ExceptionFactory.

```php
<?php

use Throwable;
use LogicException;
use Takemo101\SimplePropCheck\Exception\AbstractException;

/**
 * Implement the AbstractException class by extending it,
 * or implement the ExceptionFactory interface.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class TestException extends AbstractException
{
    /**
     * Generate an exception in the factory method and return.
     *
     * @param string $message
     * @return Throwable
     */
    public function factory(string $message): Throwable
    {
        return new LogicException("property logic error: {$message}");
    }
}
```
Use the created Attribute class as follows.
```php
<?php

use Takemo101\SimplePropCheck\PropCheckFacade;

class Test
{
    public function __construct(
        // You can set an exception to throw for the property you want to validate.
        #[MatchText('hello')]
        #[TestException]
        private string $hello,
    ) {
        //
    }
}

$test = new Test('hi');
PropCheckFacade::checkWithException($test); // throw LogicException

```

## About the Effect class
The Effect attribute allows you to apply a validation effect to the property of interest.
```php
<?php

use Takemo101\SimplePropCheck\Preset\NotEmpty;
use Takemo101\SimplePropCheck\ {
    PropCheckFacade,
    Effect,
};

class First
{
    public function __construct(
        #[NotEmpty]
        private string $text,
        // Validate the object.
        #[Effect]
        private Second $second,
    ) {}
}

class Second
{
    public function __construct(
        #[NotEmpty]
        private string $text,
        // Apply validation to object array.
        #[Effect]
        private array $third,

    ) {}
}

class Third
{
    public function __construct(
        #[NotEmpty]
        private string $text,
    ) {}
}

$first = new First(
    'text',
    new Second(
        'text',
        [
            new Third(
                'text',
            ),
            new Third(
                'text',
            ),
            // Invalid validation of this object
            new Third(
                '',
            ),
        ],
    ),
);

// When using Effect, use effect method
$result = PropCheckFacade::effect($first); // $result == false

// Use effectkWithException method to raise an exception
PropCheckFacade::effectWithException($first); // throw exception

```
## About the AfterCall class
The AfterCall attribute class allows you to set the method to be called after validating the value of the property.

```php
<?php

use Takemo101\SimplePropCheck\Preset\NotEmpty;
use Takemo101\SimplePropCheck\ {
    PropCheckFacade,
    AfterCall,
};

// Set the method name in the argument of AfterCall attribute class.
#[AfterCall('print')]
class CallClass
{
    public function __construct(
        #[NotEmpty]
        private string $text,
    ) {}

    private function print(): void
    {
        echo 'call';
    }

}

$call = new CallClass('text');

// If the value validation is successful, the specified method will be executed.
$result = PropCheckFacade::check($call); // $result == true

$call = new CallClass('');

// If the value validation fails, the specified method will not be executed.
$result = PropCheckFacade::check($call); // $result == false

```
