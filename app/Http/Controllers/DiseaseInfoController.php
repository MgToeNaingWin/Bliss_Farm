<?php

namespace App\Http\Controllers;

use App\Models\AnimalType;
use App\Models\DiseaseInfo;

class DiseaseInfoController extends Controller
{
    public function index()
    {
        $animals = AnimalType::all();
        return view('admin.disease.index', compact('animals'));
    }

    public function showAnimalDiseases($id)
    {
        $animal = AnimalType::with('diseases')->findOrFail($id);
        return view('admin.disease.show', compact('animal'));
    }

    public function showDiseaseDetail($id)
    {
        $disease = DiseaseInfo::findOrFail($id);
        return view('admin.disease.detail', compact('disease'));
    }
}
