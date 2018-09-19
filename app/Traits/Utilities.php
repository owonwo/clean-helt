<?php

namespace App\Traits;

trait Utilities
{
    private function getProvider($code)
    {
        $prefixes = config('ch.chcode_prefixes');

        $prefix = substr($code, 0, 3);

        return @$prefixes[$prefix];
    }
}