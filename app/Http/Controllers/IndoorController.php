<?php

namespace App\Http\Controllers;

use App\Models\AdmissinForm;
use Illuminate\Http\Request;

class IndoorController extends Controller
{
    public function indoorRegiPrintView(string $patient_id)
    {
        $patient = AdmissinForm::where('uuid', $patient_id)->firstOrFail();
        return view('backend.indoor.indoor_regi_print_view', compact('patient'));
    }
}
