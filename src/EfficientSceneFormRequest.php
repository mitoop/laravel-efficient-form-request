<?php

namespace Mitoop\LaravelEfficientFormRequest;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class EfficientSceneFormRequest extends EfficientFormRequest
{
    protected function validationRules(): array
    {
        $method = Str::after(Route::currentRouteAction(), '@');
        $scene = $method.'Rules';
        $rules = method_exists($this, $scene) ? $this->container->call([$this, $scene]) : [];

        return static::$globalBail ? $this->applyBailToRules($rules) : $rules;
    }
}
