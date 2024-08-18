<?php

namespace App\Http\Controllers;

use App\Models\AdmissinForm;
use App\Models\CashMemoForm;
use App\Models\CashMemoInfo;
use App\Models\Due;
use App\Models\OutdoorModel;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    public function destroyPatient(string $id)
    {
        $admissionPatient = AdmissinForm::where('uuid', $id);
        $admissionPatientForm = CashMemoForm::where('patient_uuid', $id);
        $admissionPatientCashInfo = CashMemoInfo::where('patient_uuid', $id);
        $dueHistry = Due::where('refs_id', $id)->first();
        $dueColumn = Due::where('refs_id', $id);

        if ($dueHistry->due_amount > 0) {
            $duetk = $dueHistry->due_amount;
            return redirect()->back()->with('error', 'This Patient has Due Amount - Collect it first');
        } else {
            $dueColumn->delete();
        }

        $admissionPatient->delete();
        $admissionPatientForm->delete();
        $admissionPatientCashInfo->delete();


        return redirect()->back()->with('success', 'Patient History Deleted Successfully!');
    }


    public function destroyOutdoorPatient(string $id)
    {

        $outdoorPatient = OutdoorModel::where('uuid', $id);
        $outdoorPatient->delete();

        return redirect()->back()->with('success', 'Patient History Deleted Successfully!');
    }
}
