<?php

namespace core\Database;

use core\Application;

class Query
{
    private $tableName;
    private $fieldsToFetch;
    private $joins;
    private $conditionStrings;
    private $conditionValues;
    private $havings;
    private $limit;
    private $orderBy;

    public function __construct(string $tableName, array $fieldsToFetch)
    {
        $this->tableName = $tableName;
        $this->fieldsToFetch = $fieldsToFetch;
        $this->joins = [];
        $this->conditionStrings = [];
        $this->conditionValues = [];
        $this->havings = [];
        $this->limit = null;
        $this->orderBy = null;
    }

    public function addJoin(string $join): void
    {
        $this->joins[] = $join;
    }

    public function addCondition(string $condition, array $paramsToValues = []): void
    {
        $this->conditionStrings[] = $condition;
        if (!empty($paramsToValues)) {
            $this->conditionValues[] = $paramsToValues;
        }
    }

    public function addHaving(string $condition)
    {
        $this->havings[] = $condition;
    }

    public function set(int $limit): void
    {
        $this->limit = $limit;
    }

    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    public function debugSQL(): string
    {
        return $this->createSQL();
    }

    public function compile(): \PDOStatement
    {
        $sql = $this->createSQL();
        $query = Application::$app->database->pdo->prepare($sql);
        foreach ($this->conditionValues as $convalues) {
            foreach ($convalues as $key => $value) {
                $query->bindValue(":$key", $value);
            }
        }
        return $query;
    }

    private function createSQL(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->fieldsToFetch) . ' FROM ' . $this->tableName . ' '
            . implode(' ', $this->joins);
        if (count($this->conditionStrings) > 0) {
            $sql .= ' WHERE ' . '(' . implode(') AND (', $this->conditionStrings) . ')';
        }
        if (!is_null($this->orderBy)) {
            $sql .= ' ORDER BY ' . $this->orderBy;
        }
        if (count($this->havings) > 0) {
            $sql .= ' HAVING ' . implode(',', $this->havings);
        }
        return $sql;
    }
}
