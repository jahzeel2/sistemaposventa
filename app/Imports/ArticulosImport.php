<?php

namespace App\Imports;

//use App\Models\Articulo;
use Maatwebsite\Excel\Concerns\ToModel;

class ArticulosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Articulo([
            "columna1"=> $row[0],
            "columna2"=> $row[1],
            "columna3"=> $row[2],
            "columna4"=> $row[3],
            "columna5"=> $row[4],
            "columna6"=> $row[5],
            "columna7"=> $row[6],
        ]);
    }
}
