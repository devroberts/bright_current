<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    class ProductionDataTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            $system1 = DB::table('systems')->where('customer_name', 'Alice Johnson')->first();
            $system2 = DB::table('systems')->where('customer_name', 'Bob Smith Inc.')->first();

            if ($system1) {
                DB::table('production_data')->insert([
                    [
                        'system_id' => $system1->id,
                        'date' => Carbon::now()->subDay(),
                        'energy_today' => 25.5, // kWh
                        'energy_yesterday' => 28.1, // kWh
                        'power_current' => 3.2, // kW
                        'efficiency' => 85.0, // percentage
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                    [
                        'system_id' => $system1->id,
                        'date' => Carbon::now(),
                        'energy_today' => 15.0, // kWh
                        'energy_yesterday' => 25.5, // kWh
                        'power_current' => 2.5, // kW
                        'efficiency' => 88.0, // percentage
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                ]);
            }

            if ($system2) {
                DB::table('production_data')->insert([
                    [
                        'system_id' => $system2->id,
                        'date' => Carbon::now()->subDay(),
                        'energy_today' => 120.0, // kWh
                        'energy_yesterday' => 115.5, // kWh
                        'power_current' => 15.0, // kW
                        'efficiency' => 90.0, // percentage
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                ]);
            }
        }
    }
