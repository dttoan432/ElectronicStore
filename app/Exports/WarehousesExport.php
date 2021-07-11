<?php

namespace App\Exports;

use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WarehousesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fromDate;
    protected $toDate;

    function __construct($fromDate, $toDate) {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Warehouse::with('product')->distinct()
            ->select('product_id', DB::raw('SUM(sold) as sold'))
            ->whereBetween('sale_date', [$this->fromDate, $this->toDate])
            ->groupBy('product_id')
            ->get('product_id');
    }

    public function map($warehouse) : array {
        return [
            $warehouse->product->name,
            $warehouse->sold,
            $warehouse->product->quantity,
            Carbon::parse($warehouse->created_at)->toFormattedDateString(),
            Carbon::parse($warehouse->updated_at)->toFormattedDateString()
        ] ;
    }

    public function headings() : array {
        return [
            'Tên sản phẩm',
            'Đã bán',
            'Tồn kho',
            'Ngày tạo',
            'Ngày cập nhật'
        ] ;
    }
}