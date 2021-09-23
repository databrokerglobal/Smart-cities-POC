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

class UsersExport implements FromCollection,WithHeadings , WithEvents
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
            'User ID', 'Registered On', 'Company', 'Industry', 'Email','First Name','Last Name','Role','Users','Products','Status'
        ];
      }
    
      /**
      * @return \Illuminate\Support\Collection
      */
      public function collection() {
    
        $users = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
        //->whereIn('users.userStatus',[0,1])
        ->get(["users.*", 'companies.*', 'users.created_at as createdAt']);
        $user_array = [];
        foreach($users as $usersVal){
            $count_products = 0;
            $count_all = User::where('companyIdx', $usersVal->companyIdx)->where('userStatus', 2)->get()->count();
            $count_pending = LinkedUser::where('invite_userIdx', $usersVal->userIdx)->get()->count();
          
            $count_products = OfferProduct::join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
            ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
            ->join('users', 'users.userIdx', '=', 'providers.userIdx')
            ->where('users.userIdx', $usersVal->userIdx)
            ->get()
            ->count();

            $email_verified = '';
            if($usersVal->userStatus && $usersVal->email_verified_at != null)
                $email_verified = 'Active';
            else if(!$usersVal->userStatus && $usersVal->email_verified_at == null)
                $email_verified = 'Inactive';
            else if($usersVal->userStatus && $usersVal->email_verified_at == null)
                    $email_verified = 'Verifying';
                    
           $user_array[] =  array(
               'userIdx'=>$usersVal['userIdx'],
               'createdAt'=>date(DATE_FORMAT,strtotime($usersVal['createdAt'])),
               'companyName'=>isset($usersVal['companyName'])?$usersVal['companyName']:null,
               'businessName'=>isset($usersVal['businessName'])?$usersVal['businessName']:null,
               'email'=>isset($usersVal['email'])?$usersVal['email']:null,
               'firstname'=>isset($usersVal['firstname'])?$usersVal['firstname']:null,
               'lastname'=>isset($usersVal['lastname'])?$usersVal['lastname']:null,
               'role'=>isset($usersVal['role'])?$usersVal['role']:null,
               'users'=>$count_all . " invited " . "/" . $count_pending . " pending",
               'products'=>(int)$count_products,
               'status'=> $email_verified               
           );
         
             
          }

          return collect($user_array);
      }
}
