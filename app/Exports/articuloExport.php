<?php

namespace App\Exports;

use App\Models\Articulo;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class articuloExport implements FromCollection, WithHeadings, WithColumnWidths 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Articulo::all();
        return Articulo::select("Codigo","nombre","stock","pcompra","pventa","descuento")
        ->where([
            ['estado','=','Activo'],
            ['stock','>',0]
        ])
        ->get();
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Nombre',
            'stock',
            'precio de compra',
            'precio de venta',
            'descuento',
        ];
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 40,            
            'C' => 15,            
            'D' => 15,            
            'E' => 15,            
            'F' => 15,            
        ];
    }

    /*public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }*/
}
