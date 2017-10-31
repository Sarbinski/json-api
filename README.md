# JSON API

## Examples

#### Example 1 - create JSON API data object from array
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';


// Data loaded from database(for example)
$data = [
    ['id' => '1', 'name' => 'Foo'],
    ['id' => '2', 'name' => 'Bar'],
];

$api = new Sarbinski\JsonApi\Api();
$api->createData($dataObject, 'Sarbinski\JsonApi\Schemas\TestSchema');
echo $api->buildMainJSONStructure()->getPrintData(true);
```
will output:

```json
{
    "data": [
        {
            "type": "test-schema",
            "id": "1",
            "attributes": {
                "name": "1_Foo"
            }
        },
        {
            "type": "test-schema",
            "id": "2",
            "attributes": {
                "name": "2_Bar"
            }
        }
    ]
}
```

The ```TestSchema``` is an **Adapter** that extracts attributes for given entity

```php
<?php
class TestSchema extends Schema
{
    protected $type = 'test-schema';

    public function getAttributes($resource)
    {
        return [
            'name' => $resource['id'] . '_' . $resource['name'],
        ];
    }

    public function getId($resource)
    {
        return $resource['id'];
    }

    public function getRelationships($resource)
    {
        return false;
    }
}
```

#### Example 1 - create JSON API data object from Traversable object

Again we use ```TestSchema``` as a Schema adapter

```php
<?php
class DataClass implements Iterator {
    private $items = [];

    public function __construct()
    {
        $this->items = [
            ['id' => 1, 'name' => 'a'],
            ['id' => 2, 'name' => 'b'],
        ];
    }

    public function current()
    {
        return current($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function rewind()
    {
        return reset($this->items);
    }

    public function valid()
    {
        return key($this->items) !== null;
    }
}

$dataObject = new DataClass();
$api->createData($dataObject, 'Sarbinski\JsonApi\Schemas\TestSchema');
echo $api->buildMainJSONStructure()->getPrintData(true);
```

will output:

```json
{
    "data": [
        {
            "type": "test-schema",
            "id": 1,
            "attributes": {
                "name": "1_a"
            }
        },
        {
            "type": "test-schema",
            "id": 2,
            "attributes": {
                "name": "2_b"
            }
        }
    ]
}
```

#### Auto loading of Schema classes

This lib is PSR-4 compatible. You can put your Schema classes anywhere as long as you have a proper autoloading registered.
