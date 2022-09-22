<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CreateResumeService
{
    static public function execute(array $request): void
    {
        DB::table('owners')->insert([
            'first_name' => $request['firstName'],
            'last_name' => $request['lastName'],
            'phone_number' => $request['phoneNumber'],
            'profession' => $request['profession'],
            'email' => $request['email'],
            'city' => $request['city'],
            'country' => $request['country'],
            'description' => $request['ownerDescription']
        ]);

        $owner = DB::table('owners')->latest('id')->first();

        foreach ($request['employmentHistoryList'] as $employment) {
            DB::table('work_history')->insert([
                'owner_id' => $owner->id,
                'job_title' => $employment['jobTitle'],
                'employer' => $employment['employer'],
                'description' => $employment['descriptionAndAchievements'],
                'start' => $employment['startedJob'],
                'end' => $employment['endedJob'],
            ]);
        }

        foreach ($request['educationSummaryList'] as $education) {
            DB::table('education_institutions')->insert([
                'owner_id' => $owner->id,
                'institution' => $education['educationInstitution'],
                'field_of_study' => $education['fieldOfStudy'],
                'degree' => $education['degree'],
                'currently_attending' => $education['currentlyAttending'],
                'started_at' => $education['startedAt'],
                'ended_at' => $education['endedAt']
            ]);
        }

        foreach ($request['skills'] as $skill) {
            DB::table('skills')->insert([
                'owner_id' => $owner->id,
                'skill' => $skill,
            ]);
        }

        foreach ($request['languages'] as $language) {
            DB::table('languages')->insert([
                'owner_id' => $owner->id,
                'language' => $language,
            ]);
        }

        foreach ($request['socials'] as $social) {
            DB::table('socials')->insert([
                'owner_id' => $owner->id,
                'type' => $social['type'],
                'link' => $social['link']
            ]);
        }
    }
}
