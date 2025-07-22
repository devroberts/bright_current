<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    class SystemsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            DB::table('systems')->insert([
                [
                    'system_id' => 'BC-2025-0142',
                    'customer_name' => 'Alice Johnson',
                    'customer_type' => 'residential',
                    'manufacturer' => 'solaredge',
                    'status' => 'active',
                    'location' => '123 Main St, Anytown',
                    'capacity' => 10.5, // kW
                    'install_date' => Carbon::now()->subMonths(6),
                    'last_seen' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'system_id' => 'BC-2025-0265',
                    'customer_name' => 'Bob Smith Inc.',
                    'customer_type' => 'commercial',
                    'manufacturer' => 'enphase',
                    'status' => 'warning',
                    'location' => '456 Business Ave, Othercity',
                    'capacity' => 50.0, // kW
                    'install_date' => Carbon::now()->subYear(),
                    'last_seen' => Carbon::now()->subMinutes(30),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        }
    }
