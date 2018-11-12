<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function getImport()
    {
        return view('import');
    }

    public function parseImport(CsvImportRequest $request)
    {

        $path = $request->file('csv_file')->getRealPath();

        $data = array_map('str_getcsv', file($path));
            
        Excel::create('Data', function($excel) use ($data){
            $excel->setTitle('Data');
            $excel->sheet('Data', function($sheet) use ($data){
            $sheet->fromArray($data, null, 'A1', false, false);
            });
            })->download('xls');

        return redirect()->back();

    }

}
