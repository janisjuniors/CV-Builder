<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class GetResumeDataService
{
    static public function execute($id): array
    {
        return [
            'owner' => DB::table('owners')->where('id', $id)->first(),
            'workHistory' => DB::table('work_history')->where('owner_id', $id)->get(),
            'educationInstitutions' => DB::table('education_institutions')->where('owner_id', $id)->get(),
            'skills' => DB::table('skills')->where('owner_id', $id)->get(),
            'languages' => DB::table('languages')->where('owner_id', $id)->get(),
            'socials' => DB::table('socials')->where('owner_id', $id)->get(),
        ];
    }
}
