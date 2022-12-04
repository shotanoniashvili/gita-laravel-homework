<?php

namespace App\Http\Requests;

use App\Http\Resources\BaseResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function formatErrors(Validator $validator)
    {
        return (new BaseResource('validation_errors',
                false,
                $validator->getMessageBag()->toArray()))
            ->toResponse($this);
    }
}
