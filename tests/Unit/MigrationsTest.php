<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_exist_the_federal_entities_table_and_its_columns(): void
    {
        // Check that the table exists
        $this->assertTrue(Schema::hasTable('federal_entities'));

        // Check that the columns exist
        $this->assertTrue(Schema::hasColumn('federal_entities', 'id'));
        $this->assertTrue(Schema::hasColumn('federal_entities', 'name'));
        $this->assertTrue(Schema::hasColumn('federal_entities', 'code'));
        $this->assertTrue(Schema::hasColumn('federal_entities', 'key'));
        $this->assertTrue(Schema::hasColumn('federal_entities', 'created_at'));
        $this->assertTrue(Schema::hasColumn('federal_entities', 'updated_at'));
    }

    /** @test */
    public function should_exist_the_municipalities_table_and_its_columns(): void
    {
        // Check that the table exists
        $this->assertTrue(Schema::hasTable('municipalities'));

        // Check that the columns exist
        $this->assertTrue(Schema::hasColumn('municipalities', 'id'));
        $this->assertTrue(Schema::hasColumn('municipalities', 'name'));
        $this->assertTrue(Schema::hasColumn('municipalities', 'key'));
        $this->assertTrue(Schema::hasColumn('municipalities', 'federal_entity_id'));
        $this->assertTrue(Schema::hasColumn('municipalities', 'created_at'));
        $this->assertTrue(Schema::hasColumn('municipalities', 'updated_at'));
    }

    /** @test */
    public function should_exist_the_zip_codes_table_and_its_columns(): void
    {
        // Check that the table exists
        $this->assertTrue(Schema::hasTable('zip_codes'));

        // Check that the columns exist
        $this->assertTrue(Schema::hasColumn('zip_codes', 'id'));
        $this->assertTrue(Schema::hasColumn('zip_codes', 'zip_code'));
        $this->assertTrue(Schema::hasColumn('zip_codes', 'locality'));
        $this->assertTrue(Schema::hasColumn('zip_codes', 'federal_entity_id'));
        $this->assertTrue(Schema::hasColumn('zip_codes', 'municipality_id'));
        $this->assertTrue(Schema::hasColumn('zip_codes', 'created_at'));
        $this->assertTrue(Schema::hasColumn('zip_codes', 'updated_at'));
    }

    /** @test */
    public function should_exist_the_settlements_table_and_its_columns(): void
    {
        // Check that the table exists
        $this->assertTrue(Schema::hasTable('settlements'));

        // Check that the columns exist
        $this->assertTrue(Schema::hasColumn('settlements', 'id'));
        $this->assertTrue(Schema::hasColumn('settlements', 'key'));
        $this->assertTrue(Schema::hasColumn('settlements', 'name'));
        $this->assertTrue(Schema::hasColumn('settlements', 'zone_type'));
        $this->assertTrue(Schema::hasColumn('settlements', 'settlement_type'));
        $this->assertTrue(Schema::hasColumn('settlements', 'zip_code_id'));
        $this->assertTrue(Schema::hasColumn('settlements', 'created_at'));
        $this->assertTrue(Schema::hasColumn('settlements', 'updated_at'));
    }
}
