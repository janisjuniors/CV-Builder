<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UpdateResumeService
{
    static public function execute(array $request, $id): void
    {
        DB::table('work_history')->where('owner_id', $id)->delete();
        DB::table('education_institutions')->where('owner_id', $id)->delete();
        DB::table('skills')->where('owner_id', $id)->delete();
        DB::table('languages')->where('owner_id', $id)->delete();
        DB::table('socials')->where('owner_id', $id)->delete();

        DB::table('owners')->where('id', $id)->update([
            'first_name' => $request['firstName'],
            'last_name' => $request['lastName'],
            'phone_number' => $request['phoneNumber'],
            'profession' => $request['profession'],
            'email' => $request['email'],
            'city' => $request['city'],
            'country' => $request['country'],
            'description' => $request['ownerDescription']
        ]);

        foreach ($request['employmentHistoryList'] as $employment) {
            DB::table('work_history')->insert([
                'owner_id' => $id,
                'job_title' => $employment['job_title'],
                'employer' => $employment['employer'],
                'description' => $employment['description'],
                'start' => $employment['start'],
                'end' => $employment['end'],
            ]);
        }

        foreach ($request['educationSummaryList'] as $education) {
            DB::table('education_institutions')->insert([
                'owner_id' => $id,
                'institution' => $education['institution'],
                'field_of_study' => $education['field_of_study'],
                'degree' => $education['degree'],
                'currently_attending' => $education['currently_attending'],
                'started_at' => $education['started_at'],
                'ended_at' => $education['ended_at']
            ]);
        }

        foreach ($request['skills'] as $skill) {
            DB::table('skills')->insert([
                'owner_id' => $id,
                'skill' => $skill['skill'],
            ]);
        }

        foreach ($request['languages'] as $language) {
            DB::table('languages')->insert([
                'owner_id' => $id,
                'language' => $language['language'],
            ]);
        }

        foreach ($request['socials'] as $social) {
            DB::table('socials')->insert([
                'owner_id' => $id,
                'type' => $social['type'],
                'link' => $social['link']
            ]);
        }
    }
}
