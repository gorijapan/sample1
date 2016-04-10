# sample1

```
# API個別のschema 雛形を作る (hyper schema)
prmd init app > schemata/app.json
prmd init --yaml user > schemata/user.yml
## yamlで書きたいが、個別のvalidationをどうする？
## yaml→jsonをcombineでなくとも単体でできればいけるかも？

# API全体のschema
prmd combine --meta meta.json schemata/ > schema.json
prmd verify schema.json

# API全体のDocument生成
prmd doc schema.json > schema.md

```

#Schemaのvalidation
phpのがつかえる

```
./validator.php schema.json data.json

./validator.php schemata/app.json
```



```
!#/usr/bin/php
<?php
require 'vendor/autoload.php';

// ファイル取得
$schemaFile = $argv[1];
$dataFile = $argv[2];


// Get the schema and data as objects
$retriever = new \JsonSchema\Uri\UriRetriever;
$schema = $retriever->retrieve('file://' . realpath($schemaFile));
$data = json_decode(file_get_contents($dataFile));

// If you use $ref or if you are unsure, resolve those references here
// This modifies the $schema object
$refResolver = new \JsonSchema\RefResolver($retriever);
$refResolver->resolve($schema, 'file://' . __DIR__);

// Validate
$validator = new \JsonSchema\Validator();
$validator->check($data, $schema);

if ($validator->isValid()) {
    echo "The supplied JSON validates against the schema.\n";
} else {
    echo "JSON does not validate. Violations:\n";
    foreach ($validator->getErrors() as $error) {
        echo sprintf("[%s] %s\n", $error['property'], $error['message']);
    }
}
```

# Json to JsonSchema
既存API:レスポンスJsonからJsonSchemaをつくりたい
http://jsonschema.net/




