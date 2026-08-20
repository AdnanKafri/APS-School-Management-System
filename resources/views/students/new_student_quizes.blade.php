@extends('students.layouts.app4')

@section('title', 'المذاكرات والاختبارات')

@section('content')
    @include('students.partials.assessment_list', [
        'assessmentTitle' => 'المذاكرات والاختبارات',
        'assessmentSingular' => 'التقييم',
        'assessmentDescription' => 'تابع المذاكرات والاختبارات القصيرة ونتائجها.',
        'startLabel' => 'ابدأ التقييم',
    ])
@endsection

@section('js')
    @include('students.partials.assessment_scripts')
@endsection
