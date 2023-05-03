<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FederalEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('federal_entities')->truncate();

        $filename = database_path('seeders/data.txt');
        $file = new \SplFileObject($filename);
        $file->seek(2);

        $now = now();

        $data = [];

        while (!$file->eof()) {
            $line = mb_convert_encoding(trim($file->fgets()), 'UTF-8', 'ISO-8859-1');
            /* $line = $file->fgets(); */
            if (empty($line)) {
                continue;
            }

            $fields = explode('|', $line);

            $name = $fields[4];
            $key = $fields[7];
            $code = $fields[9] ?: null;

            $data[] = [
                'name' => $name,
                'key' => $key,
                'code' => $code,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $data = array_unique($data, SORT_REGULAR);

            if (count($data) === 1000) {
                DB::table('federal_entities')
                    ->upsert($data, ['name']);
                $data = [];
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('federal_entities')
                ->upsert($data, ['name']);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
