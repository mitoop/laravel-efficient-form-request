# Laravel Efficient Form Request
高效的/支持多场景 FromRequest 验证

## Install
```shell
composer require mitoop/laravel-efficient-form-request
```

## Require
- Laravel ^10.43.0|^11|^12

## Use
几乎无感知

只需要继承 `Mitoop\LaravelEfficientFormRequest\EfficientFormRequest` 或 `Mitoop\LaravelEfficientFormRequest\EfficientSceneFormRequest` 即可


多场景demo
```php
<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rules\Password;
use Mitoop\LaravelEfficientFormRequest\EfficientSceneFormRequest;

class AuthRequest extends EfficientSceneFormRequest
{
    public function loginRules(): array
    {
        return [
            'email' => ['bail', 'required', 'string', 'email:filter', 'max:255'],
            'password' => ['bail', 'required', 'string'],
        ];
    }

    public function registerRules(): array
    {
        return [
            'email' => ['bail', 'required', 'string', 'email:filter', 'max:255', 'unique:users'],
            'password' => ['bail', 'required', 'string', 'confirmed', Password::min(6)],
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

class AuthController extends BaseController
{
    public function login(AuthRequest $request)
    {
        // 自动验证 loginRules 其他和原有保持一致
    }

    public function register(AuthRequest $request)
    {
        // 自动验证 registerRules 其他和原有保持一致

    }
}
```
