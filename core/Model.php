<?php

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    public static $tableName;
    public static $fields;

    public static function fields($fields) {
        static::$fields = '*';
        if (!empty(static::$fields)) {
            if (is_array($fields)) {
                static::$fields = implode(',', $fields);
            }
            static::$fields = $fields;
        }
        return new static;
    }

    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    public static function getAll()
    {
        $tableName = static::$tableName;
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM $tableName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get()
    {
        $tableName = static::$tableName;
        $fieldsName = static::$fields;
        $db = static::getDB();
        $stmt = $db->query("SELECT $fieldsName FROM $tableName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        if (empty($id)) {
            throw new \Exception("Id field is required");
        }
        $tableName = static::$tableName;
        $fieldsName = static::$fields;
        $db = static::getDB();
        $stmt = $db->query("SELECT $fieldsName FROM $tableName where id = $id limit 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function save($data)
    {
        if (empty($data) || !is_array($data)) {
            throw new \Exception("Data is not valid");
        }
        foreach($data as $field => $value) {
            
        }
        $fields = array_keys($data);
        $fields = implode(',', $fields);
        $values = array_values($data);
        $tableName = static::$tableName;
        $sql = "INSERT INTO $tableName ($fields) VALUES (?,?,?)";
        return static::getDB()->prepare($sql)->execute($values);
    }
}