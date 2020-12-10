<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeePersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_personals')->truncate();  
        
        DB::table('employee_personals')->insert(array(
            array(
              'emp_code' => '11111',
              'emp_name' => 'Test User A',
              'nrc_number' => '6/KKT(N)0944884',
              'passport_number' => '022548487665',
              'dateofbirth' => '2020-12-07 14:18:22',
              'email' => 'tst@gmail.com',
              'phone' => '01-5885959',
              'address' => 'No.88, BoGyoke Street, NY, UK.',
              'gender' => 'M',
              'employee_type' => 1,
              'password' => '$2y$10$3NWF/Fzyc.UC1/EiZamBme/BTnHMGsPF7GMopEMrbsNiJ6A/SEO4y',//123456789
              'email_verified_at' => '2020-12-07 14:18:22',
              'flag' => '1',
              'created_emp' => '1',
              'updated_emp' => '1',
              'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
              'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            )
        ));
    }
}
