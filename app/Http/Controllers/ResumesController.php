<?php

namespace App\Http\Controllers;

use App\Services\CreateResumeService;
use App\Services\GetResumeDataService;
use App\Services\UpdateResumeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ResumesController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Resumes', [
            'owners' => DB::table('owners')->get()
        ]);
    }

    public function add(): Response
    {
        return Inertia::render('CreateResume');
    }

    public function store(Request $request)
    {
        CreateResumeService::execute($request->all());
    }

    public function preview($id): Response
    {
        return Inertia::render('Preview', GetResumeDataService::execute($id));
    }

    public function edit($id): Response
    {
        return Inertia::render('EditResume', GetResumeDataService::execute($id));
    }

    public function update(Request $request, $id)
    {
        UpdateResumeService::execute($request->all(), $id);
    }

    public function destroy($id)
    {
        DB::table('owners')->where('id', $id)->delete();
    }
}
