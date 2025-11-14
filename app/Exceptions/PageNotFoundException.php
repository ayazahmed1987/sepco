<?php

namespace App\Exceptions;

use Exception;

class PageNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'Page not found.'
        ], 404);
    }

}
