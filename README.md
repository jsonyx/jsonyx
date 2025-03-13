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
require 'vendor/autoload.php';

use Jsonyx\Jsonyx;

$json = '{"name": "John", "age": 30, "city": "New York"}';
$data = Jsonyx::parse($json);

echo $data->name; // Outputs: John
```

## Contributing

We welcome contributions! Please read our [contributing guidelines](CONTRIBUTING.md) for more details.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
