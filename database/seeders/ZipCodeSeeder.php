<?php

namespace Database\Seeders;

use App\Models\FederalEntity;
use App\Models\Municipality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZipCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('zip_codes')->truncate();

        $filename = database_path('seeders/data.txt');
        $file = new \SplFileObject($filename);
        $file->seek(2);

        $now = now();

        $data = [];

        $federalEntities = FederalEntity::query()
            ->pluck('id', 'key')
            ->toArray();
        $municipalities = Municipality::query()
            ->select('id', 'name', 'key')
            ->get();

        while (!$file->eof()) {
            $line = mb_convert_encoding(trim($file->fgets()), 'UTF-8', 'ISO-8859-1');
            if (empty($line)) {
                continue;
            }

            $fields = explode('|', $line);

            $zipCode = $fields[0];
            $locality = $fields[5];
            $municipalityKey = $fields[11];
            $municipalityName = $fields[3];
            $federalEntityKey = $fields[7];

            $federalEntityId = $federalEntities[$federalEntityKey];
            $municipalityId = optional($municipalities
                ->where('name', $municipalityName)
                ->where('key', $municipalityKey)
                ->first())->id;

            if (!!$federalEntityId && !!$municipalityId) {
                $data[] = [
                    'zip_code' => $zipCode,
                    'locality' => $locality,
                    'federal_entity_id' => $federalEntityId,
                    'municipality_id' => $municipalityId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            $data = array_unique($data, SORT_REGULAR);

            if (count($data) === 1000) {
                DB::table('zip_codes')
                    ->upsert($data, ['zip_code', 'locality']);
                $data = [];
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('zip_codes')
                ->upsert($data, ['zip_code', 'locality']);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
