<?php

namespace App\Http\Controllers\API\Patient;

use App\Models\Contact;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    use Utilities;

    private $patient;

    public function __construct()
    {
        $this->middleware('auth:patient-api');
        $this->middleware(function($request, $next) {

            $this->patient = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        return response()->json([
            'contacts' => $this->patient->contacts()->with('contact')->get()
        ], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'chcode' => 'required'
        ];

        try {
            $this->validate($request, $rules);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors(),
                'message' => $e->getMessage()
            ], 422);
        }

        // Get model
        $modelClass = $this->getProvider($request->chcode);

        if ($modelClass && $model = $modelClass::whereChcode($request->chcode)->first()) {

            if ($this->patient->ownsContact($request->chcode))
                return response()->json([
                    'message' => 'Contact already exists'
                ], 400);

            $contact = $this->patient->contacts()->create([
                'contact_id' => $model->id,
                'contact_type' => $modelClass
            ]);

            if ($contact)
                return response()->json([
                    'message' => 'contact added successfully',
                    'contact' => $contact->load('contact')
                ]);
        }

        return response()->json([
            'message' => 'Model not found'
        ], 404);
    }

    public function delete(Contact $contact)
    {
        if (!$this->patient->ownsContact($contact->contact->chcode))
            return response()->json([
                'message' => 'contact not found'
            ], 404);

        try {
            $contact->delete();

            return response()->json([
                'message' => 'Contact removed successfully'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
