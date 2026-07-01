<?php

namespace App\Http\Controllers;
use App\Models\DiseaseInfo;
use App\Models\AnimalType;
use Illuminate\Http\Request;

class DiseaseInfoController extends Controller
{
    public function index(DiseaseInfo $diseaseInfo){
        $diseaseInfo= DiseaseInfo::all();
        
        return view('user.disease-info.index', compact('diseaseInfo'));
    }
    

public function type_show(AnimalType $diseaseType)
{
    $diseaseInfo = DiseaseInfo::where('animal_type_id', $diseaseType->id)->get();
    return view('user.disease-info.type-info', compact('diseaseType', 'diseaseInfo'));
}
    
    public function detail_show(AnimalType $diseaseType, DiseaseInfo $diseaseInfo)
    {
        return view('user.disease-info.disease-detail', compact('diseaseType', 'diseaseInfo'));
    }
}
