<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\User;
use App\Models\LinkedUser;
use App\Models\OfferProduct;
use App\Models\Offer;

class OfferExport implements FromCollection,WithHeadings , WithEvents
{

    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                $columns = ['A'=>10,'B'=>20,'C'=>30,'D'=>20,'E'=>20,'F'=>20,'G'=>20,'H'=>20,'I'=>20];
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
                $event->sheet->getStyle('A1:I'.$rowsCount)->applyFromArray([
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
            'ID', 'Title', 'Community', 'Provider', 'Region','Themes','Created Date','Last Updated','Status'
        ];
      }
    
      /**
      * @return \Illuminate\Support\Collection
      */
      public function collection() {
    
        $offers = Offer::with('theme','community','provider','region')->orderby('created_at', 'desc')
        ->get();
        $user_array = [];
        foreach($offers as $offersVal){
            $region = null;
            $theme = null;
            if(count($offersVal->region) > 0){
               foreach($offersVal->region as $key=>$regionVal){
                    $region[] = $regionVal->regionName;
               }
                $region = implode(',',$region);
            }
            if(count($offersVal->theme) > 0){
               foreach($offersVal->theme as $key=>$themeVal){
                    $theme[] = $themeVal->themeName;
               }
                $theme = implode(',',$theme);
            }

           $user_array[] =  array(
               'offerIdx'=>$offersVal['offerIdx'],
               'offerTitle'=>$offersVal['offerTitle'],
               'communityName'=>$offersVal->community->communityName,
               'companyName'=>$offersVal->provider->companyName,
               'region'=>$region,
               'theme'=>$theme,
               'createdAt'=>date(DATE_FORMAT,strtotime($offersVal['created_at'])),
               'updateAt'=>date(DATE_FORMAT,strtotime($offersVal['updated_at'])),
               
               'status'=>(isset(STATUS[$offersVal->status])) ? STATUS[$offersVal->status] : '',
            
           );
         
             
          }

          return collect($user_array);
      }
}
