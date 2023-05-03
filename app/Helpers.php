<?php

use Illuminate\Support\Str;

function normalize($string)
{
    return Str::upper(Str::ascii($string), 'UTF-8');
}
