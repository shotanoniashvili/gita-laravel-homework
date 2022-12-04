<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class BaseResource implements Responsable
{
    public function __construct(private string $message,
                                private bool $success = true,
                                private mixed $data = [],
                                private int $total = 0)
    {
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $data = [
            'success' => $this->success,
            'message' => $this->message,
            'data'    => $this->data
        ];

        if($this->total != 0) {
            $data['total'] = $this->total;
        }

        return response()->json($data, $this->getResponseCode());
    }

    /**
     * @return int
     */
    private function getResponseCode(): int {
        if($this->success) {
            return Response::HTTP_OK;
        }

        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }
}
