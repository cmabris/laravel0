<?php

namespace App;

class Sortable
{
    protected $currentColumn;
    protected $currentDirection;

    public function setCurrentOrder($column, $direction)
    {
        $this->currentColumn = $column;
        $this->currentDirection = $direction;
    }

    public function classes($column)
    {
        if($this->currentColumn == $column && $this->currentDirection == 'asc') {
            return 'link-sortable link-sorted-up';
        }

        if ($this->currentColumn == $column && $this->currentDirection == 'desc') {
            return 'link-sortable link-sorted-down';
        }

        return 'link-sortable';
    }
}