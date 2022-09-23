<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $ownerID = 9999;
        DB::table('owners')->insert(
            [
                'id' => $ownerID,
                'first_name' => 'Jack',
                'last_name' => 'Farewell',
                'phone_number' => '(917)324-1818',
                'email' => 'jack@farewell.com',
                'profession' => 'Sales Associate',
                'city' => 'New York',
                'country' => 'United States',
                'description' => 'Hardworking student seeking employment. Ready to utilize my skills and passion to further the mission of the company. Technologically adept, offering experience with many different social media platforms, office technology programs and advanced computer skills. Bringing forth a positive attitude and willingness to learn new things.'
            ]
        );

        DB::table('education_institutions')->insert(
            [
                'owner_id' => $ownerID,
                'institution' => 'New York University',
                'field_of_study' => 'Communications',
                'degree' => 'Bachelor of Communications',
                'currently_attending' => 0,
                'started_at' => '2020-09-01',
                'ended_at' => '2022-09-01'
            ]
        );

        DB::table('work_history')->insert(
            [
                'owner_id' => $ownerID,
                'job_title' => 'Sales Associate',
                'employer' => 'Small Apple Bookstore',
                'description' => 'Greeted customers and assisted them with finding books. Offered literacy suggestions based on the needs and desires of the customer. Followed directions from my supervisor and managed projects with precision. Organized books and adhered to the policies and mission of the bookstore.',
                'start' => '2018-09-01',
                'end' => '2020-09-01'
            ]
        );

        DB::table('work_history')->insert(
            [
                'owner_id' => $ownerID,
                'job_title' => 'Sales Associate',
                'employer' => 'Big Apple Bookstore',
                'description' => 'Greeted customers and assisted them with finding books. Offered literacy suggestions based on the needs and desires of the customer. Followed directions from my supervisor and managed projects with precision. Organized books and adhered to the policies and mission of the bookstore.',
                'start' => '2020-09-01',
                'end' => '2022-09-01'
            ]
        );

        $skills = ['Communication', 'Social Media', 'Technology', 'Motivated Attitude'];
        foreach ($skills as $skill) {
            DB::table('skills')->insert(
                [
                    'owner_id' => $ownerID,
                    'skill' => $skill,
                ]
            );
        }

        $languages = ['English', 'French', 'Dutch'];
        foreach ($languages as $language) {
            DB::table('languages')->insert(
                [
                    'owner_id' => $ownerID,
                    'language' => $language,
                ]
            );
        }

        DB::table('socials')->insert(
            [
                'owner_id' => $ownerID,
                'type' => 'linkedin',
                'link' => 'https://www.linkedin.com/in/janis-snorins/',
            ]
        );

        DB::table('socials')->insert(
            [
                'owner_id' => $ownerID,
                'type' => 'github',
                'link' => 'https://github.com/janisjuniors',
            ]
        );

        DB::table('socials')->insert(
            [
                'owner_id' => $ownerID,
                'type' => 'website',
                'link' => 'https://www.youtube.com/',
            ]
        );
    }
}
