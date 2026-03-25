@extends('website.layouts.app')

@section('content')
    @php
        $locale = LaravelLocalization::getCurrentLocale();
        $isArabic = $locale === 'ar';

        $copy = [
            'hero_title' => $isArabic ? 'تسجيل طالب' : 'Student Registration',
            'hero_subtitle' => $isArabic
                ? 'ابدأ طلب التسجيل بخطوات واضحة وسهلة، وسيتابع فريق المدرسة بياناتكم بعد الإرسال.'
                : 'Start the registration request through a clear and comfortable form. Our school team will review your details after submission.',
            'home' => $isArabic ? 'الرئيسية' : 'Home',
            'intro_badge' => $isArabic ? 'نموذج التسجيل' : 'Enrollment Form',
            'intro_title' => $isArabic ? 'رحلة تسجيل منظمة وواضحة للأسرة' : 'A clear and polished registration experience',
            'intro_text' => $isArabic
                ? 'يرجى تعبئة البيانات التالية بدقة. صممنا هذا النموذج ليكون سهل القراءة والتنقل مع الحفاظ على جميع الحقول المطلوبة من نظام المدرسة.'
                : 'Please complete the following information carefully. This form is organized to make registration easier while preserving every field required by the school system.',
            'required' => $isArabic ? 'مطلوب' : 'Required',
            'optional' => $isArabic ? 'اختياري' : 'Optional',
            'success' => $isArabic
                ? 'تم إرسال طلب التسجيل بنجاح. سيقوم فريق المدرسة بمراجعة البيانات والتواصل معكم قريباً.'
                : 'Your registration request has been sent successfully. Our school team will review the details and contact you soon.',
            'sections' => [
                'student' => $isArabic ? 'بيانات الطالب' : 'Student Information',
                'family' => $isArabic ? 'بيانات الأسرة' : 'Family Information',
                'contact' => $isArabic ? 'معلومات التواصل والدراسة' : 'Contact & School Details',
                'documents' => $isArabic ? 'الوثائق المرفقة' : 'Uploaded Documents',
            ],
            'section_notes' => [
                'student' => $isArabic ? 'الاسم، الصف، والبيانات الأساسية الخاصة بالطالب.' : 'Core identity details, academic level, and student profile fields.',
                'family' => $isArabic ? 'بيانات الوالدين والمعلومات الرسمية المرتبطة بالطالب.' : 'Parent details and official identity information connected to the student.',
                'contact' => $isArabic ? 'وسائل التواصل ومعلومات السكن والسجل الدراسي السابق.' : 'Contact channels, residence details, and previous school information.',
                'documents' => $isArabic ? 'يمكنكم رفع الملفات الآن أو استكمالها لاحقاً عند تواصل فريق القبول.' : 'You may upload the documents now or complete them later when the admissions team contacts you.',
            ],
            'submit' => $isArabic ? 'إرسال طلب التسجيل' : 'Submit Registration',
        ];

        $labels = [
            'first_name' => $isArabic ? 'الاسم الأول' : 'First Name (Arabic)',
            'last_name' => $isArabic ? 'الكنية' : 'Last Name (Arabic)',
            'first_name_en' => $isArabic ? 'الاسم الأول بالإنجليزية' : 'First Name in English',
            'last_name_en' => $isArabic ? 'الكنية بالإنجليزية' : 'Last Name in English',
            'father_name' => $isArabic ? 'اسم الأب' : 'Father Name',
            'mather_name' => $isArabic ? 'اسم الأم' : 'Mother Name',
            'last_mather_name' => $isArabic ? 'كنية الأم' : 'Mother Last Name',
            'date' => $isArabic ? 'تاريخ الميلاد' : 'Date of Birth',
            'gender' => $isArabic ? 'الجنس' : 'Gender',
            'class1' => $isArabic ? 'الصف الدراسي' : 'Class',
            'religion' => $isArabic ? 'الديانة' : 'Religion',
            'country' => $isArabic ? 'بلد الإقامة الحالي' : 'Country of Residence',
            'city' => $isArabic ? 'المدينة' : 'City',
            'phone' => $isArabic ? 'رقم التواصل الأساسي' : 'Primary Phone Number',
            'other_phone' => $isArabic ? 'رقم تواصل إضافي' : 'Secondary Phone Number',
            'email' => $isArabic ? 'البريد الإلكتروني' : 'Email Address',
            'place_of_birth' => $isArabic ? 'مكان الولادة' : 'Place of Birth',
            'nationality' => $isArabic ? 'الجنسية' : 'Nationality',
            'the_ID_number' => $isArabic ? 'الرقم الوطني / رقم الهوية' : 'National ID Number',
            'passport_number' => $isArabic ? 'رقم جواز السفر' : 'Passport Number',
            'the_previous_school' => $isArabic ? 'اسم المدرسة أو المدارس السابقة' : 'Previous School / Schools',
            'con_sch' => $isArabic ? 'ملاحظات أو مرجع إضافي' : 'Additional Notes / Reference',
            'fourth_image' => $isArabic ? 'شهادة الميلاد أو بيان القيد' : 'Birth Certificate or Registration Record',
            'passbord' => $isArabic ? 'صورة جواز السفر' : 'Passport Copy',
            'personal_image' => $isArabic ? 'الصورة الشخصية للطالب' : 'Student Personal Photo',
            'certification' => $isArabic ? 'آخر شهادة علمية' : 'Latest Academic Certificate',
            'mather_page' => $isArabic ? 'صورة جواز سفر الأم' : 'Mother Passport Copy',
            'father_page' => $isArabic ? 'صورة جواز سفر الأب' : 'Father Passport Copy',
        ];

        $placeholders = [
            'first_name' => $isArabic ? 'أدخل الاسم الأول' : 'Enter the first name',
            'last_name' => $isArabic ? 'أدخل الكنية' : 'Enter the last name',
            'first_name_en' => $isArabic ? 'اكتب الاسم الأول باللغة الإنجليزية' : 'Enter the English first name',
            'last_name_en' => $isArabic ? 'اكتب الكنية باللغة الإنجليزية' : 'Enter the English last name',
            'father_name' => $isArabic ? 'أدخل اسم الأب' : 'Enter the father name',
            'mather_name' => $isArabic ? 'أدخل اسم الأم' : 'Enter the mother name',
            'last_mather_name' => $isArabic ? 'أدخل كنية الأم' : 'Enter the mother last name',
            'phone' => $isArabic ? 'مثل: 0940 000 000' : 'Example: 0940 000 000',
            'other_phone' => $isArabic ? 'رقم بديل عند الحاجة' : 'Alternate contact number',
            'email' => $isArabic ? 'name@example.com' : 'name@example.com',
            'city' => $isArabic ? 'اسم المدينة' : 'City name',
            'place_of_birth' => $isArabic ? 'مكان الولادة' : 'Place of birth',
            'passport_number' => $isArabic ? 'رقم الجواز إن وجد' : 'Passport number if available',
            'the_ID_number' => $isArabic ? 'أدخل رقم الهوية أو الرقم الوطني' : 'Enter the ID or national number',
            'the_previous_school' => $isArabic ? 'اذكر المدرسة أو المدارس السابقة' : 'Mention the previous school or schools',
            'con_sch' => $isArabic ? 'أي ملاحظة إضافية تساعد فريق التسجيل' : 'Any extra note that helps the admissions team',
        ];

        $genderOptions = [
            '' => $isArabic ? 'اختر الجنس' : 'Select gender',
            '1' => $isArabic ? 'ذكر' : 'Male',
            '2' => $isArabic ? 'أنثى' : 'Female',
        ];

        $religionOptions = [
            '' => $isArabic ? 'اختر الديانة' : 'Select religion',
            '0' => $isArabic ? 'مسلم' : 'Muslim',
            '1' => $isArabic ? 'مسيحي' : 'Christian',
        ];

        $countryLabelKey = $isArabic ? 'name_ar' : 'name_en';
        $countryOptions = collect($countries_currencies ?? [])->filter(function ($item) {
            return !isset($item->active) || (int) $item->active === 1;
        })->map(function ($item) use ($countryLabelKey) {
            $value = trim((string) ($item->key_country ?? ''));
            $label = trim((string) ($item->{$countryLabelKey} ?? $item->name_en ?? $item->name_ar ?? ''));

            return [
                'value' => $value !== '' ? $value : (string) $item->id,
                'label' => $label,
            ];
        })->filter(function ($item) {
            return $item['label'] !== '';
        })->unique('value')->values();
    @endphp

    <section class="sch-section sch-page-hero">
        <div class="container">
            <div class="sch-section-head">
                <h2>{{ $copy['hero_title'] }}</h2>
                <p>{{ $copy['hero_subtitle'] }}</p>
            </div>
            <div class="sch-page-breadcrumb">
                <a href="{{ route('website.index') }}">{{ $copy['home'] }}</a>
                <span class="sch-page-sep">/</span>
                <span>{{ $copy['hero_title'] }}</span>
            </div>
        </div>
    </section>

    <section class="sch-section register-modern-section">
        <div class="container">
            <div class="register-modern-shell">
                <div class="register-modern-intro">
                    <span class="register-modern-badge">{{ $copy['intro_badge'] }}</span>
                    <h3>{{ $copy['intro_title'] }}</h3>
                    <p>{{ $copy['intro_text'] }}</p>
                </div>

                @if (session()->has('success'))
                    <div class="register-modern-alert register-modern-alert--success">
                        {{ $copy['success'] }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="register-modern-alert register-modern-alert--error">
                        {{ $isArabic ? 'يرجى مراجعة الحقول المظللة أدناه قبل إعادة الإرسال.' : 'Please review the highlighted fields below before submitting again.' }}
                    </div>
                @endif

                <form action="{{ route('stu_register') }}" method="post" enctype="multipart/form-data" class="register-modern-form">
                    @csrf

                    <div class="register-modern-group">
                        <div class="register-modern-group-head">
                            <h4>{{ $copy['sections']['student'] }}</h4>
                            <p>{{ $copy['section_notes']['student'] }}</p>
                        </div>
                        <div class="register-modern-grid register-modern-grid--2">
                            <div class="register-modern-field">
                                <label for="first_name">{{ $labels['first_name'] }} <span>{{ $copy['required'] }}</span></label>
                                <input type="text" id="first_name" name="first_name" class="register-modern-input @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="{{ $placeholders['first_name'] }}" required>
                                @error('first_name')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="last_name">{{ $labels['last_name'] }} <span>{{ $copy['required'] }}</span></label>
                                <input type="text" id="last_name" name="last_name" class="register-modern-input @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="{{ $placeholders['last_name'] }}" required>
                                @error('last_name')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="first_name_en">{{ $labels['first_name_en'] }}</label>
                                <input type="text" id="first_name_en" name="first_name_en" class="register-modern-input @error('first_name_en') is-invalid @enderror" value="{{ old('first_name_en') }}" placeholder="{{ $placeholders['first_name_en'] }}">
                                @error('first_name_en')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="last_name_en">{{ $labels['last_name_en'] }}</label>
                                <input type="text" id="last_name_en" name="last_name_en" class="register-modern-input @error('last_name_en') is-invalid @enderror" value="{{ old('last_name_en') }}" placeholder="{{ $placeholders['last_name_en'] }}">
                                @error('last_name_en')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="date">{{ $labels['date'] }} <span>{{ $copy['required'] }}</span></label>
                                <input type="date" id="date" name="date" class="register-modern-input @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                                @error('date')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="class1">{{ $labels['class1'] }} <span>{{ $copy['required'] }}</span></label>
                                <select id="class1" name="class1" class="register-modern-input @error('class1') is-invalid @enderror" required>
                                    <option value="">{{ $isArabic ? 'اختر الصف الدراسي' : 'Select class' }}</option>
                                    @foreach ($classes as $item)
                                        @php
                                            $classLabel = $isArabic ? ($item->name ?? $item->name_en) : ($item->name_en ?? $item->name);
                                        @endphp
                                        <option value="{{ $item->id }}" {{ (string) old('class1') === (string) $item->id ? 'selected' : '' }}>{{ $classLabel }}</option>
                                    @endforeach
                                </select>
                                @error('class1')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="gender">{{ $labels['gender'] }}</label>
                                <select id="gender" name="gender" class="register-modern-input @error('gender') is-invalid @enderror">
                                    @foreach ($genderOptions as $value => $optionLabel)
                                        <option value="{{ $value }}" {{ (string) old('gender') === (string) $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                                @error('gender')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="religion">{{ $labels['religion'] }} <span>{{ $copy['required'] }}</span></label>
                                <select id="religion" name="religion" class="register-modern-input @error('religion') is-invalid @enderror" required>
                                    @foreach ($religionOptions as $value => $optionLabel)
                                        <option value="{{ $value }}" {{ (string) old('religion') === (string) $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                                @error('religion')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="register-modern-group">
                        <div class="register-modern-group-head">
                            <h4>{{ $copy['sections']['family'] }}</h4>
                            <p>{{ $copy['section_notes']['family'] }}</p>
                        </div>
                        <div class="register-modern-grid register-modern-grid--2">
                            <div class="register-modern-field">
                                <label for="father_name">{{ $labels['father_name'] }} <span>{{ $copy['required'] }}</span></label>
                                <input type="text" id="father_name" name="father_name" class="register-modern-input @error('father_name') is-invalid @enderror" value="{{ old('father_name') }}" placeholder="{{ $placeholders['father_name'] }}" required>
                                @error('father_name')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="mather_name">{{ $labels['mather_name'] }} <span>{{ $copy['required'] }}</span></label>
                                <input type="text" id="mather_name" name="mather_name" class="register-modern-input @error('mather_name') is-invalid @enderror" value="{{ old('mather_name') }}" placeholder="{{ $placeholders['mather_name'] }}" required>
                                @error('mather_name')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="last_mather_name">{{ $labels['last_mather_name'] }}</label>
                                <input type="text" id="last_mather_name" name="last_mather_name" class="register-modern-input @error('last_mather_name') is-invalid @enderror" value="{{ old('last_mather_name') }}" placeholder="{{ $placeholders['last_mather_name'] }}">
                                @error('last_mather_name')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="the_ID_number">{{ $labels['the_ID_number'] }}</label>
                                <input type="text" id="the_ID_number" name="the_ID_number" class="register-modern-input @error('the_ID_number') is-invalid @enderror" value="{{ old('the_ID_number') }}" placeholder="{{ $placeholders['the_ID_number'] }}">
                                @error('the_ID_number')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="nationality">{{ $labels['nationality'] }}</label>
                                <select id="nationality" name="nationality" class="register-modern-input @error('nationality') is-invalid @enderror">
                                    <option value="">{{ $isArabic ? 'اختر الجنسية' : 'Select nationality' }}</option>
                                    @foreach ($countryOptions as $item)
                                        <option value="{{ $item['value'] }}" {{ (string) old('nationality') === (string) $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('nationality')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="passport_number">{{ $labels['passport_number'] }}</label>
                                <input type="text" id="passport_number" name="passport_number" class="register-modern-input @error('passport_number') is-invalid @enderror" value="{{ old('passport_number') }}" placeholder="{{ $placeholders['passport_number'] }}">
                                @error('passport_number')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="place_of_birth">{{ $labels['place_of_birth'] }}</label>
                                <input type="text" id="place_of_birth" name="place_of_birth" class="register-modern-input @error('place_of_birth') is-invalid @enderror" value="{{ old('place_of_birth') }}" placeholder="{{ $placeholders['place_of_birth'] }}">
                                @error('place_of_birth')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="city">{{ $labels['city'] }}</label>
                                <input type="text" id="city" name="city" class="register-modern-input @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="{{ $placeholders['city'] }}">
                                @error('city')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="register-modern-group">
                        <div class="register-modern-group-head">
                            <h4>{{ $copy['sections']['contact'] }}</h4>
                            <p>{{ $copy['section_notes']['contact'] }}</p>
                        </div>
                        <div class="register-modern-grid register-modern-grid--2">
                            <div class="register-modern-field">
                                <label for="country">{{ $labels['country'] }} <span>{{ $copy['required'] }}</span></label>
                                <select id="country" name="country" class="register-modern-input @error('country') is-invalid @enderror" required>
                                    <option value="">{{ $isArabic ? 'اختر بلد الإقامة' : 'Select country of residence' }}</option>
                                    @foreach ($countryOptions as $item)
                                        <option value="{{ $item['value'] }}" {{ (string) old('country') === (string) $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('country')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="email">{{ $labels['email'] }}</label>
                                <input type="email" id="email" name="email" class="register-modern-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ $placeholders['email'] }}">
                                @error('email')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="phone">{{ $labels['phone'] }} <span>{{ $copy['required'] }}</span></label>
                                <input type="text" id="phone" name="phone" class="register-modern-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="{{ $placeholders['phone'] }}" inputmode="tel" required>
                                @error('phone')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field">
                                <label for="other_phone">{{ $labels['other_phone'] }}</label>
                                <input type="text" id="other_phone" name="other_phone" class="register-modern-input @error('other_phone') is-invalid @enderror" value="{{ old('other_phone') }}" placeholder="{{ $placeholders['other_phone'] }}" inputmode="tel">
                                @error('other_phone')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field register-modern-field--full">
                                <label for="the_previous_school">{{ $labels['the_previous_school'] }}</label>
                                <input type="text" id="the_previous_school" name="the_previous_school" class="register-modern-input @error('the_previous_school') is-invalid @enderror" value="{{ old('the_previous_school') }}" placeholder="{{ $placeholders['the_previous_school'] }}">
                                @error('the_previous_school')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="register-modern-field register-modern-field--full">
                                <label for="con_sch">{{ $labels['con_sch'] }}</label>
                                <textarea id="con_sch" name="con_sch" class="register-modern-input register-modern-textarea @error('con_sch') is-invalid @enderror" rows="4" placeholder="{{ $placeholders['con_sch'] }}">{{ old('con_sch') }}</textarea>
                                @error('con_sch')<small class="register-modern-error">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="register-modern-group">
                        <div class="register-modern-group-head">
                            <h4>{{ $copy['sections']['documents'] }}</h4>
                            <p>{{ $copy['section_notes']['documents'] }}</p>
                        </div>
                        <div class="register-modern-grid register-modern-grid--3">
                            @foreach (['fourth_image', 'passbord', 'personal_image', 'certification', 'mather_page', 'father_page'] as $uploadField)
                                <div class="register-modern-field register-modern-upload">
                                    <label for="{{ $uploadField }}">{{ $labels[$uploadField] }} <span>{{ $copy['optional'] }}</span></label>
                                    <input type="file" id="{{ $uploadField }}" name="{{ $uploadField }}" class="register-modern-input register-modern-file @error($uploadField) is-invalid @enderror">
                                    @error($uploadField)<small class="register-modern-error">{{ $message }}</small>@enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="register-modern-actions">
                        <button type="submit" class="register-modern-submit">{{ $copy['submit'] }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
