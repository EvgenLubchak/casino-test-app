<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WinResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => "You win! Number: {$this->resource['number']}. You got {$this->resource['prize']} $.",
            'data' => [
                'number' => $this->resource['number'],
                'prize' => $this->resource['prize'],
                'currency' => '$',
                'timestamp' => now()->toISOString(),
            ]
        ];
    }
}
