<?php
/**
 * Created by PhpStorm.
 * User: chiemelachinedum
 * Date: 07/08/2018
 * Time: 7:09 PM
 */

namespace App\Traits;

use Keygen\Keygen;

trait CodeGenerator
{
    private function generateKey()
    {
        // prefixes the key with a random integer between 1 - 9 (inclusive)
        return Keygen::numeric(9)->prefix(mt_rand(1, 9))
            ->prefix($this->codePrefix)
            ->generate(true);
    }

    public function generateUniqueCode($model = null)
    {
        $code = $this->generateKey();


        $query = $model ? $model::whereChcode($code) :
            self::whereChcode($code);

        // Ensure Code does not exist
        // Generate new one if Code already exists
        while ($query->count() > 0) {
            $code = $this->generateKey();
        }

        return $code;
    }

    public static function generateCode()
    {
        return Keygen::numeric(5)->prefix(mt_rand(1, 9))
                    ->prefix('CH-')
                    ->generate(true);
    }
}