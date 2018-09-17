<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntityController extends Controller
{
    private $openClasses = [
        'App\\Models\\Doctor',
        'App\\Models\\Pharmacy',
        'App\\Models\\Laboratory',
        'App\\Models\\Hospitals'
    ];

    public function index($type)
    {
        $model = $this->getEntity($type);

        if (class_exists($model) && $this->isOpen($type)) {
            return response()->json([
                $type => $model::latest()->paginate(30)
            ], 200);
        }

        return response()->json(['message' => 'Entity not found'], 404);
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
