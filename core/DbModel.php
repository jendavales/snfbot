<?php

namespace core;

abstract class DbModel extends Model
{
    public static abstract function tableName(): string;

    abstract public static function dbAttributes(): array;

    abstract public static function primaryKeys(): array;

    protected function afterFetch(): void
    {
    }

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

    public function update(array $fieldsToUpdate = []): void
    {
        $tableName = static::tableName();

        if (count($fieldsToUpdate) == 0) {
            $fieldsToUpdate = $this->dbAttributes();
        }
        $setValues = [];
        foreach ($fieldsToUpdate as $attribute) {
            $setValues[] = "$attribute = " . (is_null($this->{$attribute}) ? 'null' : ":$attribute");
        }

        $whereValues = [];
        foreach ($this->primaryKeys() as $attribute) {
            $whereValues[] = "$attribute = :$attribute";
        }

        $sql = "UPDATE $tableName SET " . implode(',', $setValues) . ' WHERE ' . implode(',', $whereValues);
        $query = Application::$app->database->pdo->prepare($sql);

        foreach ($fieldsToUpdate as $attribute) {
            if (is_null($this->{$attribute})) {
                continue;
            }

            $query->bindValue(":$attribute", $this->{$attribute});
        }
        foreach ($this->primaryKeys() as $attribute) {
            $query->bindValue(":$attribute", $this->{$attribute});
        }

        $query->execute();
    }

    public function fetch(array $fetchBy = [], array $additionalFields = ['id']): void
    {
        $selectParams = array_merge($additionalFields, $this->dbAttributes());
        $tableName = static::tableName();

        if (empty($fetchBy)) {
            $whereCond = "WHERE id = :id";
        } else {
            $conditions = [];
            foreach ($fetchBy as $key => $value) {
                $conditions[] = "$key = :$key";
            }

            $whereCond = "WHERE " . implode(' and ', $conditions);
        }

        $sql = "SELECT " . implode(', ', $selectParams) . " FROM $tableName " . $whereCond;
        $query = Application::$app->database->pdo->prepare($sql);

        if (empty($fetchBy)) {
            $query->bindValue(':id', $this->id);
        } else {
            foreach ($fetchBy as $key => $value) {
                $query->bindValue(":$key", $value);
            }
        }

        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return;
        }

        foreach ($result as $key => $value) {
            $this->{$key} = $value;
        }
        $this->afterFetch();
    }

    public static function fetchAll(array $fetchBy = [], array $additionalFields = ['id'], ?OrderBy $order = null, ?Limit $limit = null): array
    {
        $selectParams = array_merge(static::dbAttributes(), $additionalFields);
        $tableName = static::tableName();

        $conditions = [];
        foreach ($fetchBy as $key => $value) {
            $conditions[] = "$key = :$key";
        }

        $whereCond = "WHERE " . implode(' and ', $conditions);

        $sql = "SELECT " . implode(', ', $selectParams) . " FROM $tableName " . (count($fetchBy) > 0 ? $whereCond : '');

        if (!is_null($order)) {
            $sql .= " ORDER BY $order->orderBy $order->orderDir";
        }

        if (!is_null($limit)) {
            $sql .= " LIMIT $limit->limit";
        }

        $query = Application::$app->database->pdo->prepare($sql);

        foreach ($fetchBy as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        $query->execute();
        $results = $query->fetchAll(\PDO::FETCH_ASSOC);
        if ($results === false) {
            return [];
        }

        $return = [];
        foreach ($results as $result) {
            $model = new static($result);
            $model->afterFetch();
            $return[] = $model;
        }

        return $return;
    }

    public function delete(array $deleteBy = [])
    {
        $tableName = static::tableName();
        $conditions = [];

        if (empty($deleteBy)) {
            $deleteBy = ['id' => $this->id];
        }

        foreach ($deleteBy as $key => $value) {
            $conditions[] = "$key = :$key";
        }

        $sql = "DELETE FROM $tableName WHERE " . implode($conditions);
        $query = Application::$app->database->pdo->prepare($sql);

        foreach ($deleteBy as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        $query->execute();
    }

    public static function getNewestId(): int
    {
        $tableName = static::tableName();
        $sql = "SELECT id FROM $tableName ORDER BY ID DESC LIMIT 1";
        return Application::$app->database->pdo->query($sql)->fetchColumn();
    }
}
