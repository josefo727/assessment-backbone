<?php

namespace Database\Seeders;

use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Models\ZipCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettlementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('settlements')->truncate();

        $filename = database_path('seeders/data.txt');
        $file = new \SplFileObject($filename);
        $file->seek(2);

        $now = now();

        $data = [];

        while (!$file->eof()) {
            $line = mb_convert_encoding(trim($file->fgets()), 'UTF-8', 'ISO-8859-1');
            if (empty($line)) {
                continue;
            }

            $fields = explode('|', $line);

            $key = $fields[12];
            $settlementName = $fields[1];
            $zoneType = $fields[13];
            $settlementType = $fields[2];
            $zipCode = $fields[0];
            $locality = $fields[5];

            $zipCodeId = ZipCode::query()
                ->where('zip_code', $zipCode)
                ->where('locality', $locality)
                ->value('id');

            if (!!$zipCodeId) {
                $data[] = [
                    'key' => $key,
                    'name' => $settlementName,
                    'zone_type' => $zoneType,
                    'settlement_type' => $settlementType,
                    'zip_code_id' => $zipCodeId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $data = array_unique($data, SORT_REGULAR);

                if (count($data) === 1000) {
                    DB::table('settlements')->insert($data);
                    $data = [];
                }
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('settlements')->insert($data);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
