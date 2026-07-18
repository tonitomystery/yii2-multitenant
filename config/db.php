<?php

return [
    'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'dsn' => getenv("DB_DSN"),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
