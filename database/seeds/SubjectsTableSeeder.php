<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gradeCycle1 = \App\Grade::find(1)->id;
        $gradeCycle2 = \App\Grade::find(2)->id;
        $gradeCycle3 = \App\Grade::find(3)->id;

        $subject = new \App\Subject();
        $subject->name = 'Islamic Studies';
        $subject->slug = str_slug('Islamic Studies');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2, $gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Arabic';
        $subject->slug = str_slug('Arabic');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2, $gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'English';
        $subject->slug = str_slug('English');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2, $gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Social studies';
        $subject->slug = str_slug('Social studies');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2, $gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Math';
        $subject->slug = str_slug('Math');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2, $gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Art';
        $subject->slug = str_slug('Art');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2]);

        $subject = new \App\Subject();
        $subject->name = 'Design technology';
        $subject->slug = str_slug('Design technology');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2]);

        $subject = new \App\Subject();
        $subject->name = 'Science';
        $subject->slug = str_slug('Science');
        $subject->save();

        $subject->grades()->attach([$gradeCycle1, $gradeCycle2]);

        $subject = new \App\Subject();
        $subject->name = 'Physics';
        $subject->slug = str_slug('Physics');
        $subject->save();

        $subject->grades()->attach([$gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Biology';
        $subject->slug = str_slug('Biology');
        $subject->save();

        $subject->grades()->attach([$gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Chemistry';
        $subject->slug = str_slug('Chemistry');
        $subject->save();

        $subject->grades()->attach([$gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Computer science';
        $subject->slug = str_slug('Computer science');
        $subject->save();

        $subject->grades()->attach([$gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Business';
        $subject->slug = str_slug('Business');
        $subject->save();

        $subject->grades()->attach([$gradeCycle3]);

        $subject = new \App\Subject();
        $subject->name = 'Life skills';
        $subject->slug = str_slug('Life skills');
        $subject->save();

        $subject->grades()->attach([$gradeCycle3]);

    }
}
