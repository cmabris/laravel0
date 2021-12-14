<?php

namespace App;

use Illuminate\Support\Arr;

class Sortable
{
    protected $currentColumn;
    protected $currentDirection;
    protected $currentUrl;

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public function setCurrentOrder($column, $direction)
    {
        $this->currentColumn = $column;
        $this->currentDirection = $direction;
    }

    public function classes($column)
    {
        if($this->isSortingBy($column, 'asc')) {
            return 'link-sortable link-sorted-up';
        }

        if ($this->isSortingBy($column, 'desc')) {
            return 'link-sortable link-sorted-down';
        }

        return 'link-sortable';
    }

    public function url($column)
    {
        if($this->isSortingBy($column, 'asc')) {
            return $this->buildSortableUrl($column, 'desc');
        }

        return $this->buildSortableUrl($column);
    }

    protected function buildSortableUrl($column, $direction = 'asc')
    {
        return $this->currentUrl . '?' . Arr::query(['order' => $column, 'direction' => $direction]);
    }

    protected function isSortingBy($column, $direction)
    {
        return $this->currentColumn == $column && $this->currentDirection == $direction;
    }
}