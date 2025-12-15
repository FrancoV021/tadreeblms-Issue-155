<?php

namespace App\Exports;

use App\Models\Stripe\SubscribeCourse;
use CustomHelper;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\courseAssignment;


class CourseAssignmentReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $records = courseAssignment::notPathway()
                                    ->with('assignedBy', 'course', 'department')
                                    ->orderBy('id', 'Desc')
                                    ->get();
        return $records; 
    }

    public function headings(): array
    {
        return ['Assign Title', 'Course Code', 'Course Name', 'Course Category', 'Assign By', 'Assign Date', 'Assign to Dept', 'Assign to Users', 'Due Date'];
    }

    public function map($data): array
    {
    

        return [
            @$data->title,
            @$data->course->course_code,
            @$data->course->title,
            @$data->course->category->name,
            @$data->assignedBy->full_name,
            @$data->assign_date,
            @$data->department->title,
            @$data->assigned_user_names,
            @$data->due_date,
        ];
    }
}
