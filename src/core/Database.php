<?php

namespace alexshent\webapp\core;

use alexshent\webapp\application\Config;

class Database {
    private static $instance;
    private $pdo;
    
    private function __construct(array $config = null) {
        if (empty($config)) {
            throw new \InvalidArgumentException("empty config");
        }
        extract($config);
        try {
            $this->pdo = new \PDO(
            "$database_type:host=$host;dbname=$database_name;charset=$charset;",
            $user,
            $password
            );
        } catch (\PDOException $exception) {
            throw new \alexshent\webapp\core\exceptions\DatabaseException("database connection error: " . $exception->getMessage());
        }
    }
    
    public function query(string $sql, array $params = [], string $className = 'stdClass'): array {
        $result = [];
        $statement = $this->pdo->prepare($sql);
        if ($statement->execute($params)) {
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, $className);
        }
        return $result;
    }
    
    public static function getInstance(array $config = Config::PDO): self {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getLastInsertId(): int {
        return (int) $this->pdo->lastInsertId();
    }
}
