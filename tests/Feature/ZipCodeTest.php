<?php

namespace Tests\Feature;

use App\Models\ZipCode;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class ZipCodeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $dbConnection =  'mysql';

        Config::set('database.default', $dbConnection);
        Config::set("database.connections.{$dbConnection}.database", 'assessment_backbone');
    }

    /** @test */
    public function should_return_correct_information_for_zip_code_01000(): void
    {
        $response = $this->get('/api/zip-codes/01000');
        $response->assertStatus(200);
        $response->assertJson([
            "zip_code" => "01000",
            "locality" => "CIUDAD DE MEXICO",
            "federal_entity" => [
                "key" => 9,
                "name" => "CIUDAD DE MEXICO",
                "code" => null,
            ],
            "settlements" => [
                [
                    "key" => 1,
                    "name" => "SAN ANGEL",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
            ],
            "municipality" => [
                "key" => 10,
                "name" => "ALVARO OBREGON",
            ],
        ]);
    }

    /** @test */
    public function should_return_correct_information_for_zip_code_27984(): void
    {
        $response = $this->get('/api/zip-codes/27984');
        $response->assertStatus(200);
        $response->assertJson([
            "zip_code" => "27984",
            "locality" => "PARRAS DE LA FUENTE",
            "federal_entity" => [
                "key" => 5,
                "name" => "COAHUILA DE ZARAGOZA",
                "code" => null,
            ],
            "settlements" => [
                [
                    "key" => 1604,
                    "name" => "AGUA DE LOS PADRES",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
                [
                    "key" => 1605,
                    "name" => "OJO DE AGUA",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
                [
                    "key" => 1606,
                    "name" => "SALTILLO 400",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
                [
                    "key" => 2263,
                    "name" => "PRI 92",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
                [
                    "key" => 2427,
                    "name" => "SOL AZTECA",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
                [
                    "key" => 2958,
                    "name" => "EL MIRADOR",
                    "zone_type" => "URBANO",
                    "settlement_type" => [
                        "name" => "Colonia",
                    ],
                ],
            ],
            "municipality" => [
                "key" => 24,
                "name" => "PARRAS",
            ],
        ]);
    }

    /** @test */
    public function should_return_correct_structure_for_zip_code(): void
    {
        $response = $this->get('/api/zip-codes/01000');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'zip_code',
            'locality',
            'federal_entity' => [
                'key',
                'name',
                'code'
            ],
            'settlements' => [
                '*' => [
                    'key',
                    'name',
                    'zone_type',
                    'settlement_type' => [
                        'name'
                    ]
                ]
            ],
            'municipality' => [
                'key',
                'name'
            ]
        ]);
    }

    /** @test */
    function should_validate_responses_for_random_zip_codes(): void
    {
        // Get 25 random zip codes
        $zipCodes = ZipCode::query()
            ->inRandomOrder()
            ->take(25)
            ->pluck('zip_code');

        // Loop through each zip code and make requests to both API endpoints
        foreach ($zipCodes as $zipCode) {
            $response1 = $this->get("https://jobs.backbonesystems.io/api/zip-codes/{$zipCode}");
            $response2 = $this->get("/api/zip-codes/{$zipCode}");

            // Validate that the responses are identical
            $response1->assertStatus(200);
            $response2->assertStatus(200);
            $this->assertSame($response1->getContent(), $response2->getContent());
        }
    }

    /** @test */
    public function should_respond_within_300ms(): void
    {
        // Select a random zip_code from the database
        $zipCode = ZipCode::query()->inRandomOrder()->firstOrFail();

        // Make a request to the API and measure the response time
        $start = microtime(true);
        $this->get("/api/zip-codes/{$zipCode->zip_code}");
        $end = microtime(true);

        // Assert that the response time is less than 300 ms
        $responseTime = ($end - $start) * 1000; // Convert to milliseconds
        $this->assertLessThan(300, $responseTime);
    }

}
