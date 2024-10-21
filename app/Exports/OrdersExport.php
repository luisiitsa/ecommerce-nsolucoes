<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Retorna a coleção de pedidos.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(): \Illuminate\Support\Collection
    {
        // Carrega os pedidos com o cliente
        return Order::with('customer')->get();
    }

    /**
     * Define os cabeçalhos das colunas no Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nome do Cliente',
            'Data de Criação',
            'Total',
            'Status',
        ];
    }

    /**
     * Mapeia os dados do pedido para as colunas corretas no Excel.
     *
     * @param \App\Models\Order $order
     * @return array
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->customer->name,
            $order->created_at->format('d/m/Y'),
            'R$ ' . number_format($order->total, 2, ',', '.'),
            ucfirst($order->status),
        ];
    }
}
