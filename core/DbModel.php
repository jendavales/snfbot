<?php

namespace core;

abstract class DbModel extends Model
{
    public static abstract function tableName(): string;

    abstract public static function dbAttributes(): array;

    abstract public static function primaryKeys(): array;

    public function insert(): void
    {
        $tableName = $this->tableName();

        foreach ($this as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            $values[] = ":$key";
            $params[] = "$key";
        }

        $sql = "INSERT INTO $tableName (" . implode(',', $params) . ") VALUES (" . implode(',', $values) . ')';
        $query = Application::$app->database->pdo->prepare($sql);

        foreach ($params as $param) {
            $query->bindValue(":$param", $this->{$param});
        }

        $query->execute();
    }

    public function update(): void
    {
        $tableName = static::tableName();

        $setValues = [];
        foreach ($this->dbAttributes() as $attribute) {
            $setValues[] = "$attribute = " . $this->{$attribute};
        }

        $whereValues = [];
        foreach ($this->primaryKeys() as $attribute) {
            $whereValues[] = "$attribute = " . $this->{$attribute};
        }

        $sql = "UPDATE $tableName SET" . implode(',', $setValues) . 'WHERE ' . implode(',', $whereValues);
        $query = Application::$app->database->pdo->prepare($sql);

        $query->execute();
    }

    public function fetch(array $fetchBy = [], array $additionalFields = ['id']): void
    {
        $selectParams = array_merge($additionalFields, $this->dbAttributes());
        $tableName = static::tableName();

        if (empty($fetchBy)) {
            $id = $this->id;
            $whereCond = "WHERE id = $id";
        } else {
            $conditions = [];
            foreach ($fetchBy as $key => $value) {
                $conditions[] = "$key = \"$value\"";
            }

            $whereCond = "WHERE " . implode(' and ', $conditions);
        }

        $sql = "SELECT " . implode(', ', $selectParams) . " FROM $tableName " . $whereCond;
        $result = Application::$app->database->pdo->query($sql)->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return;
        }

        foreach ($result as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function fetchAll(array $fetchBy, array $additionalFields = ['id']): array
    {
        $selectParams = array_merge(static::dbAttributes(), $additionalFields);
        $tableName = static::tableName();

        $conditions = [];
        foreach ($fetchBy as $key => $value) {
            $conditions[] = "$key = \"$value\"";
        }

        $whereCond = "WHERE " . implode(' and ', $conditions);

        $sql = "SELECT " . implode(', ', $selectParams) . " FROM $tableName " . $whereCond;
        $results = Application::$app->database->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        if ($results === false) {
            return [];
        }

        $return = [];
        foreach ($results as $result) {
            $return[] = new static($result);
        }

        return $return;
    }
}
