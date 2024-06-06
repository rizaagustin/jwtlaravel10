<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PemilikDataResource extends JsonResource
{
    public $status;
    public $message;
    public function __construct($tatus,$message,$resource){

        parent::__construct($resource);
        $this->status = $tatus;
        $this->message = $message;

    }

    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }
}
