<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Stripe\SubscribeCourse;
use CustomHelper;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class CoursesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $records = Course::query()->ofTeacher()
            ->whereHas('category')
            ->orderBy('created_at', 'desc')->get();
        return $records;
    }

    public function headings(): array
    {
        return ['Title', 'Code', 'Lang', 'CourseType', 'Category', 'Teachers', 'Total Students Enrolled', 'Status'];
    }

    public function map($data): array
    {
        $teachersData = $data->teachers->pluck('name')->toArray();
        $teachers = implode(", ", $teachersData);
        $totalStudentsEnrolled = CustomHelper::totalEnrolled($data->id);

        $statusText = $data->published == 1 ? trans('labels.backend.courses.fields.published') :  trans('labels.backend.courses.fields.unpublished');

        $course_type = null;
        if($data->is_online == 'Online') {
            $course_type = 'E-Learning';
        }
        if($data->is_online == 'Offline') {
            $course_type = 'Live-Online';
        }
        if($data->is_online == 'Live-Classroom') {
            $course_type = 'Live-Classroom';
        }

        return [
            @$data->title,
            @$data->course_code,
            @$data->course_lang,
            @$course_type,
            @$data->category->name,
            @$teachers,
            @(string)$totalStudentsEnrolled,
            @$statusText,
        ];
    }
}
