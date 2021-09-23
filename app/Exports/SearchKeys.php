<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\User;
use App\Models\LinkedUser;
use App\Models\SearchedKeys;
use DB;

class SearchKeys implements FromCollection,WithHeadings , WithEvents
{

    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:C1'; // All headers
                $columns = ['A'=>30,'B'=>20,'C'=>20];
                foreach($columns as $key=>$column){
                    $event->sheet->getDelegate()->getColumnDimension($key)->setWidth($column);

                }
                
                $rowsCount = $event->sheet->getHighestRow();
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                ->setFillType('solid')
                ->getStartColor()->setARGB('b1a0c7');
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                    
                ]);
                $event->sheet->getStyle('A1:C'.$rowsCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);
            },
        ];
    }

    public function headings(): array {
        return [
            'Searched Keyword', 'Searched By', 'Searched On'
        ];
      }
    
      /**
      * @return \Illuminate\Support\Collection
      */
      public function collection() {
    
        $Query = "SELECT s.*,u.firstname,u.lastname,u.email FROM `searched_keys` s
                       LEFT JOIN users u ON s.searched_by = u.userIdx ORDER BY s.created_at DESC";
        $all_keys = DB::select($Query);
        $keys_array = [];
        foreach($all_keys as $key){
                    
           $keys_array[] =  array(
               'search_key'=>$key->search_key,               
               'searched_by'=>$key->searched_by != null ? $key->firstname.' '.$key->lastname : 'Unknown',
               'created_at'=>date(HOUR24_DATETIME, strtotime($key->created_at)),                        
           );
         
             
          }

          return collect($keys_array);
      }
}
