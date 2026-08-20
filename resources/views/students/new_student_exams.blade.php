@extends('students.layouts.app4')

@section('title', 'الامتحانات')

@section('content')
    @include('students.partials.assessment_list', [
        'assessmentTitle' => 'الامتحانات',
        'assessmentSingular' => 'الامتحان',
        'assessmentDescription' => 'تابع مواعيد الامتحانات، المتطلبات، والنتائج المتاحة.',
        'startLabel' => 'ابدأ الامتحان',
    ])
@endsection

@section('js')
    @include('students.partials.assessment_scripts')
@endsection
