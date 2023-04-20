<?php

namespace App\Traits;



trait Orderable
{

    private string $orderGroupColumn = "";

    /**
     * $direction is TRUE for UP, FALSE for DOWN
     */
    public function reorder(bool $direction)
    {
        $currentOrderIndex = $this->ordering;
        $toSwapWith = self::where('ordering', $currentOrderIndex + ($direction ? -1 : +1));

        if ($this->orderGroupColumn != "") {
            $toSwapWith = $toSwapWith->where($this->orderGroupColumn, $this->{$this->orderGroupColumn});
        }

        $toSwapWith = $toSwapWith->first();


        if ($toSwapWith == null) return false;

        $targetOrder = $toSwapWith->ordering;
        $toSwapWith->ordering = null;
        $toSwapWith->save();

        $this->ordering = $targetOrder;
        $this->save();

        $toSwapWith->ordering = $currentOrderIndex;
        $toSwapWith->save();

        return true;
    }

    public function setOrderGroupColumn(string $col)
    {
        $this->orderGroupColumn = $col;
    }

    public function orderSelf()
    {

        $highestOrder = null;
        if ($this->orderGroupColumn != "") {
            $highestOrder =  self::where($this->orderGroupColumn, $this->{$this->orderGroupColumn})->max('ordering');
        } else {
            $highestOrder = self::max('ordering');
        }

        $this->ordering = $highestOrder + 1;
        $this->save();
    }
}
