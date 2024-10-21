<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): \Illuminate\Support\Collection
    {
        return Order::all(['id', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Data de Criação',
        ];
    }
}
