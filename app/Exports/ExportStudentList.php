<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;


class ExportStudentList implements FromArray
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    public function array(): array
    {
        foreach ($this->list as $item){
            return $item;
        }

    }
}
