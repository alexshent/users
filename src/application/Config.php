<?php

namespace alexshent\webapp\application;

class Config {
    
    const PDO = [
        'database_type' => 'mysql',
        'host' => '172.17.0.2',
        'database_name' => 'hello',
        'user' => 'root',
        'password' => '1',
        'charset' => 'utf8'
    ];
    
    const Bootstrap = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">';
}
