<?php

namespace alexshent\webapp\core;

use alexshent\webapp\core\NamingConvention;
use alexshent\webapp\core\Database;

abstract class ActiveRecord {
    private $idType;
    protected $id;
    
    public function __construct($idType = "auto") {
        if ($idType !== "auto" && $idType !== "uuid") {
            throw new \InvalidArgumentException("invalid it type");
        }
        $this->idType = $idType;
    }
    
    abstract protected static function getTableName(): string;
    
    public function __set(string $name, $value) {
        $camelCaseName = NamingConvention::underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId(?string $id) {
        $this->id = $id;
    }
    
    public static function findAll(): array {
        return Database::getInstance()->query(
        'SELECT * FROM `' . static::getTableName() . '`;',
        [],
        static::class
        );
    }
    
    public static function getById($id): ?self {
        $entities = Database::getInstance()->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public static function findOneByColumn(string $columnName, $value): ?self {
        $result = Database::getInstance()->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if ($result === []) {
            return null;
        }
        return $result[0];
    }

    public function delete(): void {
        Database::getInstance()->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }
    
    public static function bulkDelete(array $ids): void {
        $commaSeparatedIds = implode(',', $ids);
        Database::getInstance()->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id IN (:ids)',
            [':ids' => $commaSeparatedIds]
        );
    }

    public function save(): void {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id != null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }
    
    private function update(array $mappedProperties): void {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = :id';
        $params2values[':id'] = $this->id;
        Database::getInstance()->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void {
        $filteredProperties = array_filter($mappedProperties);
        
        if ($this->idType === "auto") {
            $filteredProperties['id'] = null;
        } elseif ($this->idType === "uuid") {
            $uuid = $this->uuidv4();
            $filteredProperties['id'] = $uuid;
            $this->id = $uuid;
        }
        
        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName. '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }
        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);
        $db = Database::getInstance();
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        $db->query($sql, $params2values, static::class);
        if ($this->idType === "auto") {
            $this->id = $db->getLastInsertId();
        }
        $this->refreshProperties();
    }
    
    private function refreshProperties(): void {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }
    
    private function mapPropertiesToDbFormat(): array {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameUnderscore = NamingConvention::camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }
    
    private function uuidv4($data = null) : string {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
