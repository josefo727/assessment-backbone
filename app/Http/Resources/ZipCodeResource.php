<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZipCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'zip_code' => $this->zip_code,
            'locality' => normalize($this->locality),
            'federal_entity' => [
                'key' => (int) $this->federalEntity->key,
                'name' => normalize($this->federalEntity->name),
                'code' => $this->federalEntity->code,
            ],
            'settlements' => $this->settlements->map(function ($settlement) {
                return [
                    'key' => (int) $settlement->key,
                    'name' => normalize($settlement->name),
                    'zone_type' => normalize($settlement->zone_type),
                    'settlement_type' => [
                        'name' => $settlement->settlement_type,
                    ],
                ];
            }),
            'municipality' => [
                'key' => (int) $this->municipality->key,
                'name' => normalize($this->municipality->name),
            ],
        ];
    }
}
