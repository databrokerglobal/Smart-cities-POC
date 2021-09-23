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

class PurchaseExport implements FromCollection,WithHeadings , WithEvents
{

    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:K1'; // All headers
                $columns = ['A'=>10,'B'=>20,'C'=>30,'D'=>20,'E'=>20,'F'=>20,'G'=>20,'H'=>20,'I'=>20,'J'=>10,'K'=>10];
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
                $event->sheet->getStyle('A1:K'.$rowsCount)->applyFromArray([
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
            'Purchase ID','Product Name', 'Buyer', 'Seller','Price','Valid From', 'Valid Till'
        ];
      }
    
      /**
      * @return \Illuminate\Support\Collection
      */
      public function collection() {
    
        $purchases = OfferProduct::with(['region'])
                    ->select("offerProducts.*", "offers.*", "providers.*", "users.*", "companies.*", "purchases.*", "purchases.userIdx as buyyer_id", "bids.*", "purchases.productIdx as productIDX")
                    ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                    ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                    ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                    ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                    ->join('purchases', 'purchases.productIdx', '=', 'offerProducts.productIdx')
                    ->leftjoin('bids', 'bids.bidIdx', '=', 'purchases.bidIdx')
                    ->orderby('purchases.created_at', 'asc')
                    ->get();
        $purchase_array = [];
        foreach($purchases as $purchase){
            $count_products = 0;
           $price = 'Free';
            if($purchase->productBidType !="free")
                $price = "€ ". $purchase->bidPrice!=0 ? $purchase->bidPrice : $purchase->amount;
            
           $purchase_user = User::where('userIdx', $purchase->buyyer_id)->first();
           $purchaseUserName = '';
           if($purchase_user){
                $purchaseUserName = $purchase_user->firstname." ".$purchase_user->lastname;
           }
           $purchase_array[] =  array(
               'purchaseIdx'=>$purchase['purchaseIdx'],
               'productTitle'=>$purchase['productTitle'],
               'buyyer_name'=> $purchaseUserName,
               'seller'=>$purchase->firstname." ".$purchase->lastname,
               'price'=>$price,
               'validFrom'=>date(DATE_FORMAT,strtotime($purchase->from)),
               'validTo'=>date(DATE_FORMAT,strtotime($purchase->to)),               
           );                      
          }
          return collect($purchase_array);
      }
}
