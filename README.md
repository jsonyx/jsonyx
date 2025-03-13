## Overview

`jsonyx` is a powerful JSON manipulation library for PHP. It provides an easy-to-use API for parsing, generating, and transforming JSON data. It also supports plugins from the `pluggarray/pluggarray` package, offering an easy static API in the `Facade/Jsonyx` class.

## Features

- Simple and intuitive API
- High performance
- Support for complex JSON structures
- Flexible and extensible
- Plugin support via `pluggarray/pluggarray`

## Installation

You can install `jsonyx` via Composer:

```bash
composer require jsonyx/jsonyx
```

## Usage

Here is a basic example of how to use `jsonyx`:

```php

use Jsonyx\Facade\Jsonyx;

$json = '
    {
        "@import": "common/constants.json",
        "@const": {
            "FOO": "foo",
            "BAR": "bar"
        },
        "foo-refs": {
            "reference-node": {
                ...
            }
        },
        "user": {
            "name": "${user.name}",
            "age": 30,
            "foo": "@const(FOO) and @const(BAR)",
            "baz": "env value: @env(BAZ)",
            "ref": "@reference(foo-refs.reference-node),
            "address": "@include(user/${user.id}/address.json)"
        }
    }
';
$userData = [
    'id' => 1,
    'name': 'John Doe'
];

$jsonyx = \Jsonyx\Facade\Jsonyx::Jsonyx($userData); // or new Jsonyx($userData)

$jsonyx->withPlugin(
    function()
)


```

## Contributing

We welcome contributions! Please read our [contributing guidelines](CONTRIBUTING.md) for more details.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
