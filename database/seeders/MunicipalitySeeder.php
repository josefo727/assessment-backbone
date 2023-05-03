<?php

namespace Database\Seeders;

use App\Models\FederalEntity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('municipalities')->truncate();

        $filename = database_path('seeders/data.txt');
        $file = new \SplFileObject($filename);
        $file->seek(2);

        $now = now();

        $data = [];

        $fe = FederalEntity::query()->pluck('id', 'name')->toArray();

        while (!$file->eof()) {
            $line = mb_convert_encoding(trim($file->fgets()), 'UTF-8', 'ISO-8859-1');
            if (empty($line)) {
                continue;
            }

            $fields = explode('|', $line);

            $municipalityName = $fields[3];
            $federalEntityName = $fields[4];
            $key = $fields[11];

            $federalEntityId = $fe[$federalEntityName];

            if (!!$federalEntityId) {
                $data[] = [
                    'name' => $municipalityName,
                    'key' => $key,
                    'federal_entity_id' => $federalEntityId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $data = array_unique($data, SORT_REGULAR);

                if (count($data) === 1000) {
                    DB::table('municipalities')
                        ->upsert($data, ['name', 'federal_entity_id']);
                    $data = [];
                }
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('municipalities')
                ->upsert($data, ['name', 'federal_entity_id']);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
