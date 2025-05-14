<?php

namespace App\Protocols;

use Illuminate\Http\Request;

interface OrderFilterInterface
{
    public function apply($query, Request $request);
}