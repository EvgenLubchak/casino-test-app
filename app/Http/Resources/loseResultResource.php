<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class loseResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => "You louse! Number: {$this->resource['number']}. You got {$this->resource['prize']} $",
            'data' => [
                'number' => $this->resource['number'],
                'prize' => $this->resource['prize'],
                'currency' => '$',
                'timestamp' => now()->toISOString(),
            ]
        ];
    }
}
