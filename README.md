Sequoia
=======

A Cheeky Component library for PHP, using the Twig templating language library and an OOP approach. Built with Wordpress in mind but not limited to Wordpress.

## Prerequisites

* Php `^7.4 || ^8.0`
* Composer `^2.0`

## Installation

Require as dependency by either; adding it directly to your `composer.json`, or running:

```shell
$ composer require jascha030/sequoia
```

_Simple as that…_

## Usage

It’s all based around two interfaces:

**TwigTemplaterInterface** and the **TwigComponentInterface** and it’s main implementation **TwigComponentAbstract**.

### Templater

Create a Templater which requires a `Twig\Environment` instance.
(Preferably using a `FilesystemLoader`).

**Example** 

```php
<?php

use Jascha030\Sequoia\Templater\TwigTemplater;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Replace with the path to your templates folder.
$loader      = new FilesystemLoader('/Twig/Template/Folder');
$environment = new Environment($loader);
$templater = new TwigTemplater($environment);

```

Let’s say you have a template in your templates folder called `list-template.twig`

```twig
<ul>
    {% for item in items %}
        <li>{{ item.text }}</li>     
    {% endfor %}
<u>
```

Now you can extend the `TwigComponentAbstract`.

```php
<?php 

namespace Example\Component;

use Jascha030\Sequoia\Component\TwigComponentAbstract;

final class ListComponent extends TwigComponentAbstract 
{
    /**
     * @inheritDoc
     */
    public function getTemplate(): string
    {
        return 'list-template.twig';
    }
}

```

Which can then be rendered like:

```php
<?php

use Example\Component\ListComponent;
use Jascha030\Sequoia\Templater\TwigTemplater;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Replace with the path to your templates folder.
$loader      = new FilesystemLoader('/Twig/Template/Folder');
$environment = new Environment($loader);
$templater = new TwigTemplater($environment);

ListComponent::render(
    $templater, 
    [
        'items' => [
            ['text' => 'List item 1'],
            ['text' => 'List item 2']
        ]
    ]
);

```


**Using default values**

You can also provide, defaults for a component using the `HasDefaultContextTrait` like:

```php
…

final class ListComponent extends TwigComponentAbstract 
{
    use HasDefaultContextTrait;
    
    /**
     * @inheritDoc
     */
    public function getTemplate(): string
    {
        return 'list-template.twig';
    }
    
    /**
     * @inheritDoc
     */
    final public function getDefaults(): array
    {
        return [
            'items' => [
                ['text' => 'List item 1'],
                ['text' => 'List item 2']
            ]
        ];
    }
}

```

**With Wordpress**

When available the `getContext` method used in rendering, will have an automatically generated filter, to mutate the defaults following the pattern: 

`twig_template_context_{$this->getTemplateSlug()}`

Where `$this->getTemplateSlug()` will by default return the template name defined in the `getTemplate()` method, minus the `.twig` appendix, in the above example this would be: `twig_template_context_list-template`, which could then be used in the following context (in Wordpress):

```php

function edit_list_items(array $context): array
{
    $context['items'][] = ['text' => 'List item 3'];
    
    return $context;
}

\add_filter('twig_template_context_list-template', 'edit_list_items');

```

Now you would hypothetically have added a third list item and the output of the `ListComponent::render()` method would be:

```html

<ul>
    <li>List item 1</li>
    <li>List item 2</li>
    <li>List item 3</li>
<u>

```


## Running UnitTests

To check wether your implementation is allright or if there is something wrong with the library while extending it. you can use:

```shell
$ composer run phpunit
```

> Make sure to install with dev dependencies by using `composer install` instead of `composer install —no-dev`.


> More comming soon.

## Inspiration

This is the start of a library based around the frustration with Wordpress, their messy template system, their messy user base, and the sadly, lately rarely updated `timber/timber` library and 
it’s overkill set of features.

It’s pretty specific and built mainly for myself and to make Front-end features a bit more fun to develop. 

But maybe someone will ever find some use in this library as I hope to extend it and add loads of features, until it will reach a point of being just as overkill as `timber`.

That being said, `timber/timber` is a great library so support it if you use it, and even though Wordpress’ messy and old-timey nature, It’s a great tool for those who are learning or don’t aspire to be developers to build their website, which is obviously, why it has seen the great success, that it has.

And for those who are aspiring to be developers, beware of the fact that the coding styles of Wordpress are a great starting point, they are not how we develop code in the rest of the world, and based around old, long forgotten standards.

> Shout out to those few internet heroes, who are finding and teaching how to do Wordpress development, in a more modern fashion.

> If you are one who aspires to be one or is just plain bored by having to work with Wordpress, I suggest googling people like:
> * Carl Alexander
> * Josh Pollock
> * The people from Roots (from bedrock, sage)


