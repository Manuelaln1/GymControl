<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function academiaId(): int
    {
        $academiaId = auth()->user()?->academia_id;

        abort_if(!$academiaId, 403, 'Usuario sem academia vinculada.');

        return $academiaId;
    }
}
