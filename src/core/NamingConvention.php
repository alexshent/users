<?php

namespace alexshent\webapp\core;

class NamingConvention {
    
    public static function underscoreToCamelCase(string $source): string {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
    
    public static function camelCaseToUnderscore(string $source): string {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }
    
    public static function hyphenToStudlyCaps(string $string): string {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
    
    public static function hyphenToCamelCase(string $string): string {
        return lcfirst(self::hyphenToStudlyCaps($string));
    }
}
