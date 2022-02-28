<?php

namespace core;

class OrderBy
{
    public const DESC = 'desc';
    public const ASC = 'asc';

    public $orderBy;
    public $orderDir;

    public function __construct(string $orderBy, string $orderDir)
    {
        $this->orderBy = $orderBy;
        $this->orderDir = $orderDir;
    }
}
