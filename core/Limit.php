<?php

namespace core;

class Limit
{
    public $limit;

    public function __construct(int $limit) {
        $this->limit = $limit;
    }
}
