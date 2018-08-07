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
        $reference = $this->generateKey();


        $query = $model ? $model::whereReference($reference) :
            self::whereReference($reference);

        // Ensure Code does not exist
        // Generate new one if Code already exists
        while ($query->count() > 0) {
            $reference = $this->generateKey();
        }

        return $reference;
    }

    public static function generateCode()
    {
        return Keygen::numeric(5)->prefix(mt_rand(1, 9))
                    ->prefix('CH-')
                    ->generate(true);
    }
}