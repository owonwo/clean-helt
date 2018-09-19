<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntityController extends Controller
{
    private $openClasses = [
        'doctors' => 'App\\Models\\Doctor',
        'pharmacies' => 'App\\Models\\Pharmacy',
        'laboratories' => 'App\\Models\\Laboratory',
        'hospitals' => 'App\\Models\\Hospital'
    ];

    public function index($type = null)
    {
        $data = [];
        if ($type) {
            $model = $this->getEntity($type);

            if (!(class_exists($model) && $this->isOpen($type)))
                return response()->json(['message' => 'Data not found'], 404);

            $data[$type] = $model::latest()->get();
        } else {
            foreach ($this->openClasses as $type => $class) {
                $data[$type] = $class::latest()->get();
            }
        }

        return response()->json([
            'data' => $data
        ], 200);

    }

    private function getEntity($type)
    {
        $class = str_singular(ucfirst($type));
        return "App\\Models\\{$class}";
    }

    private function isOpen($type)
    {
        $class = $this->getEntity($type);
        return in_array($class, $this->openClasses);
    }
}
