<?php

namespace App\Exports;

use App\Student;
use App\Student_register;
use App\Year;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StudentExport_register implements FromCollection, WithHeadings
{

    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
     public function country($country)
    {
       $country1 = $country;
          if( $country1  == "AF")
         $country=  'Afghanistan';
     else if( $country1  == "AX")
     $country='Aland Islands';
    else if( $country1  == "AL")
    $country='Albania';
    else if( $country1  == "DZ")
    $country='Algeria';
    else if( $country1  == "AS")
     $country='American Samoa';
    else if( $country1  == "AD")
             $country='Andorra';
            else if( $country1  == "AO")
            $country='Angola';

            else if( $country1  == "AI")
            $country='Anguilla';

            else if( $country1  == "AQ") $country=
        'Antarctica';
            else if( $country1  == "AG") $country=
        'Anguilla';
            else if( $country1  == "AR") $country=
        'Argentina';
      else if( $country1  == "AW") $country=
      'Aruba';
      else if( $country1  == "AM") $country=
      'Armenia';
        else if( $country1  == "AU") $country=
      'Australia';
        else if( $country1  == "AT") $country=
      'Austria';
       else if( $country1  == "AZ") $country=
      'Azerbaijan';
         else if( $country1  == "BS") $country=
      'Bahamas';
       else if( $country1  == "BH") $country=
      'Bahrain';
       else if( $country1  == "BD") $country=
      'Bangladesh';
       else if( $country1  == "BB") $country=
      'Barbados';
           else if( $country1  == "BY") $country=
      'Belarus';
        else if( $country1  == "BE") $country=
      'Belgium';
             else if( $country1  == "BZ") $country=
      'Belize';
         else if( $country1  == "BJ") $country=
      'Benin';
       else if( $country1  == "BM") $country=
      'Bermuda';
        else if( $country1  == "BT") $country=
      'Bhutan';
       else if( $country1  == "BO") $country=
      'Bolivia';
           else if( $country1  == "BQ") $country='Bonaire, Sint Eustatius and Saba';
         else if( $country1  == "BA") $country=
     'Bosnia and Herzegovina';
 else if( $country1  == "BW") $country=
    'Botswana';
     else if( $country1  == "BV") $country=
    'Bouvet Island';
         else if( $country1  == "BR") $country=
    'Brazil';
      else if( $country1  == "IO") $country=
   'British Indian Ocean Territory';
     else if( $country1  == "BN") $country=
 'Brunei Darussalam';
    else if( $country1  == "BG") $country=
'Bulgaria';
  else if( $country1  == "BF") $country=
'Burkina Faso';
  else if( $country1  == "BI") $country=
'Burundi';
  else if( $country1  == "KH") $country=
'Cambodia';
  else if( $country1  == "CM") $country=
'Cameroon';
 else if( $country1  == "CA") $country=
'Canada';
 else if( $country1  == "CV") $country=
'Cape Verde';
 else if( $country1  == "KY") $country=
'Cayman Islands';
 else if( $country1  == "CF") $country=
'Central African Republic';
 else if( $country1  == "TD") $country=
'Chad';
else if( $country1  == "CL") $country=
'Chile';
else if( $country1  == "CN") $country=
'China';
else if( $country1  == "CX") $country=
'Christmas Island';
else if( $country1  == "CC") $country=
'Cocos (Keeling) Islands';
else if( $country1  == "CO") $country=
'Colombia';
else if( $country1  == "KM") $country=
'Comoros';
else if( $country1  == "CG") $country=
'Congo';
else if( $country1  == "CD") $country=
'Congo, Democratic Republic of the Congo';
else if( $country1  == "CK") $country=
'Cook Islands';
else if( $country1  == "CR") $country=
'Costa Rica';
else if( $country1  == "CI") $country=
"Cote D'Ivoire";
else if( $country1  == "HR") $country=
'Croatia';
else if( $country1  == "CU") $country=
'Cuba';
else if( $country1  == "CW") $country=
'Curacao';
else if( $country1  == "CY") $country=
'Cyprus';
else if( $country1  == "CZ") $country=
'Czech Republic';
else if( $country1  == "DK") $country=
'Denmark';
else if( $country1  == "DJ") $country=
'Djibouti';
else if( $country1  == "DM") $country=
'Dominica';
else if( $country1  == "DO") $country=
'Dominican Republic';
else if( $country1  == "EC") $country=
'Ecuador';
else if( $country1  == "EG") $country=
'Egypt';
   else if( $country1  == "SV") $country=
'El Salvador';
   else if( $country1  == "GQ") $country=
'Equatorial Guinea';
   else if( $country1  == "ER") $country=
'Eritrea';
     else if( $country1  == "EE") $country=

'Estonia';
else if( $country1  == "ET") $country=
'Ethiopia';
 else if( $country1  == "FK") $country=
'Falkland Islands (Malvinas)';
else if( $country1  == "FO") $country=
'Faroe Islands';
else if( $country1  == "FJ") $country=
'Fiji';
else if( $country1  == "FI") $country=
'Finland';
else if( $country1  == "FR") $country=
'France';
else if( $country1  == "GF") $country=
'French Guiana';
else if( $country1  == "PF") $country=
'French Polynesia';
else if( $country1  == "TF") $country=
'French Southern Territories';
else if( $country1  == "GA") $country=
'Gabon';
else if( $country1  == "GM") $country=
'Gambia';
else if( $country1  == "GE") $country=
'Georgia';
else if( $country1  == "DE") $country=
'Germany';
else if( $country1  == "GH") $country=
'Ghana';
else if( $country1  == "GI") $country=
'Gibraltar';
else if( $country1  == "GR") $country=
'Greece';
else if( $country1  == "GL") $country=
'Greenland';
   else if( $country1  == "GD") $country=
'Grenada';
else if( $country1  == "GP") $country=
'Guadeloupe';
else if( $country1  == "GU") $country=
'Guam';
else if( $country1  == "GT") $country=
'Guatemala';
else if( $country1  == "GG") $country=
'Guernsey';
else if( $country1  == "GN") $country=
'Guinea';
else if( $country1  == "GW") $country=
'Guinea-Bissau';
else if( $country1  == "GY") $country=
'Guyana';
else if( $country1  == "HT") $country=
'Haiti';
else if( $country1  == "HN") $country=
'Honduras';
else if( $country1  == "HM") $country=
'Heard Island and Mcdonald Islands';
else if( $country1  == "VA") $country=
'Holy See (Vatican City State)';
else if( $country1  == "HK") $country=
'Hong Kong';
else if( $country1  == "HU") $country=
'Hungary';
else if( $country1  == "IS") $country=
'Iceland';
else if( $country1  == "IN") $country=
'India';
else if( $country1  == "ID") $country=
'Indonesia';
else if( $country1  == "IR") $country=
'Iran, Islamic Republic of';
else if( $country1  == "IQ") $country=
'Iraq';
else if( $country1  == "IE") $country=
'Ireland';
else if( $country1  == "IM") $country=
'Isle of Man';
else if( $country1  == "IL") $country=
'Israel';
else if( $country1  == "IT") $country=
'Italy';
else if( $country1  == "JM") $country=
'Jamaica';
  else if( $country1  == "JP") $country=
'Japan';
  else if( $country1  == "JE") $country=
'Jersey';
  else if( $country1  == "JO") $country=
'Jordan';
   else if( $country1  == "KZ") $country=
'Kazakhstan';
else if( $country1  == "KE") $country=
'Kenya';
else if( $country1  == "KI") $country=
'Kiribati';
else if( $country1  == "KP") $country=
"Korea, Democratic People's Republic of";
else if( $country1  == "KR") $country=
'Korea, Republic of';
else if( $country1  == "XK") $country=
'Kosovo';
else if( $country1  == "KW") $country=
'Kuwait';
else if( $country1  == "KG") $country=
'Kyrgyzstan';
else if( $country1  == "LA") $country=
"Lao People's Democratic Republic";
else if( $country1  == "LV") $country=
'Latvia';
else if( $country1  == "LB") $country=
'Lebanon';
else if( $country1  == "LC") $country=
'Saint Lucia';
else if( $country1  == "LS") $country=
'Lesotho';
else if( $country1  == "LR") $country=
'Liberia';
else if( $country1  == "LY") $country=
'Libyan Arab Jamahiriya';
else if( $country1  == "LI") $country=
'Liechtenstein';
else if( $country1  == "LT") $country=
'Lithuania';
else if( $country1  == "LU") $country=
'Luxembourg';
else if( $country1  == "MO") $country=
'Macao';
else if( $country1  == "MK") $country=
'Macedonia, the Former Yugoslav Republic of';
else if( $country1  == "MG") $country=
'Madagascar';
else if( $country1  == "MW") $country=
'Malawi';
else if( $country1  == "MY") $country=
'Malaysia';
else if( $country1  == "MV") $country=
'Maldives';
else if( $country1  == "ML") $country=
'Mali';
else if( $country1  == "MT") $country=
'Malta';
else if( $country1  == "MH") $country=
'Marshall Islands';
else if( $country1  == "MQ") $country=
'Martinique';
else if( $country1  == "MR") $country=
'Mauritania';
else if( $country1  == "MU") $country=
'Mayotte';
else if( $country1  == "MX") $country=
'Mexico';
else if( $country1  == "FM") $country=
'Micronesia, Federated States of';
 else if( $country1  == "MD") $country=
'Moldova, Republic of';
else if( $country1  == "MC") $country=
'Monaco';
else if( $country1  == "MN") $country=
'Mongolia';
else if( $country1  == "ME") $country=
'Montenegro';

else if( $country1  == "MS") $country=
'Montserrat';

else if( $country1  == "MA") $country=
'Morocco';
else if( $country1  == "MZ") $country=
'Mozambique';
else if( $country1  == "MM") $country=
'Myanmar';
else if( $country1  == "NA") $country=
'Namibia';
else if( $country1  == "NR") $country=
'Nauru';
else if( $country1  == "NP") $country=
'Nepal';
else if( $country1  == "NL") $country=
'Netherlands';
else if( $country1  == "AN") $country=
'Netherlands Antilles';
else if( $country1  == "NC") $country=
'New Caledonia';
else if( $country1  == "NZ") $country=
'New Zealand';
else if( $country1  == "NI") $country=
'Nicaragua';
else if( $country1  == "NE") $country=
'Niger';
else if( $country1  == "NG") $country=
'Nigeria';
else if( $country1  == "NU") $country=
'Niue';
else if( $country1  == "NF") $country=
'Norfolk Island';
else if( $country1  == "MP") $country=
'Northern Mariana Islands';
else if( $country1  == "NO") $country=
'Norway';
else if( $country1  == "OM") $country=
'Oman';
else if( $country1  == "PK") $country=
'Pakistan';
else if( $country1  == "PW") $country=
'Palau';
else if( $country1  == "PS") $country=
'Palestinian Territory, Occupied';
else if( $country1  == "PA") $country=
'Panama';
else if( $country1  == "PG") $country=
'Papua New Guinea';
else if( $country1  == "PY") $country=
'Paraguay';
else if( $country1  == "PE") $country=
'Peru';
else if( $country1  == "PH") $country=
'Philippines';
else if( $country1  == "PN") $country=
'Pitcairn';
else if( $country1  == "PL") $country=
'Poland';
else if( $country1  == "PT") $country=
'Portugal';
else if( $country1  == "PR") $country=
'Puerto Rico';
else if( $country1  == "QA") $country=
'Qatar';
else if( $country1  == "RE") $country=
'Reunion';
else if( $country1  == "RO") $country=
'Romania';
else if( $country1  == "RU") $country=
'Russian Federation';
else if( $country1  == "RW") $country=
'Rwanda';
else if( $country1  == "BL") $country=
'Saint Barthelemy';
else if( $country1  == "SH") $country=
'Saint Helena';
else if( $country1  == "KN") $country=
'Saint Kitts and Nevis';
else if( $country1  == "SH") $country=
'Saint Lucia';
else if( $country1  == "MF") $country=
'Saint Martin';
else if( $country1  == "PM") $country=
'Saint Pierre and Miquelon';
else if( $country1  == "VC") $country=
'Saint Vincent and the Grenadines';
else if( $country1  == "WS") $country=
'Samoa';
else if( $country1  == "SM") $country=
'San Marino';

else if( $country1  == "ST") $country=
'Sao Tome and Principe';
else if( $country1  == "SA") $country=
'Saudi Arabia';
else if( $country1  == "SN") $country=
'Senegal';
else if( $country1  == "RS") $country=
'Serbia';
else if( $country1  == "CS") $country=
'Serbia and Montenegro';
else if( $country1  == "SC") $country=
'Seychelles';
else if( $country1  == "SL") $country=
'Sierra Leone';
else if( $country1  == "SX") $country=
'Sint Maarten';
else if( $country1  == "SK") $country=
'Slovakia';
else if( $country1  == "SI") $country=
'Slovenia';
else if( $country1  == "SB") $country=
'Solomon Islands';
else if( $country1  == "SO") $country=
'Somalia';
else if( $country1  == "ZA") $country=
'South Africa';
else if( $country1  == "GS") $country=
'South Georgia and the South Sandwich Islands';
 else if( $country1  == "SS") $country=
'South Sudan';
    else if( $country1  == "ES") $country='Spain';
 else if( $country1  == "LK") $country='Sri Lanka';
 else if( $country1  == "SD") $country=
'Sudan';

  else if( $country1  == "SR") $country=
'Suriname';
 else if( $country1  == "SJ") $country=
'Svalbard and Jan Mayen';
 else if( $country1  == "SZ") $country=
'Swaziland';
else if( $country1  == "SE") $country=
'Sweden';
else if( $country1  == "CH") $country=
'Switzerland';
else if( $country1  == "SY") $country=
'Syrian Arab Republic';
else if( $country1  == "TW") $country=
"Taiwan, Province of China";
else if( $country1  == "TJ") $country=
"Tajikistan";
else if( $country1  == "TZ") $country=
"Tanzania, United Republic of";
else if( $country1  == "TH") $country=
"Thailand";
else if( $country1  == "TL") $country=
"Timor-Leste";
else if( $country1  == "TG") $country=
"Togo";
else if( $country1  == "TK") $country=
"Tokelau";
else if( $country1  == "TO") $country=
"Tonga";
else if( $country1  == "TN") $country=
"Trinidad and Tobago";
else if( $country1  == "TR") $country=
"Turkey";
else if( $country1  == "TM") $country=
"Turkmenistan";
else if( $country1  == "TC") $country=
"Turks and Caicos Islands";
else if( $country1  == "TV") $country=
"Tuvalu";
else if( $country1  == "UG") $country=
"Uganda";
else if( $country1  == "UA") $country=
"Ukraine";
else if( $country1  == "AE") $country=
"United Arab Emirates";
else if( $country1  == "GB") $country=
"United Kingdom";
else if( $country1  == "US") $country=
"United States";
else if( $country1  == "UM") $country=

"United States Minor Outlying Islands";
else if( $country1  == "UY") $country="Uruguay";

else if( $country1  == "UZ") $country="Uzbekistan";
else if( $country1  == "VU") $country=
'Vanuatu';
else if( $country1  == "VE") $country=
'Venezuela';
else if( $country1  == "VN") $country=
'Viet Nam';
else if( $country1  == "VG") $country=
'Virgin Islands, British';
else if( $country1  == "VI") $country=
'Virgin Islands, U.s.';
else if( $country1  == "WF") $country=
'Wallis and Futuna';
else if( $country1  == "EH") $country=
"Western Sahara";
else if( $country1  == "EH")
$country="Yemen";

else if( $country1  == "ZM")
$country="Zambia";
else if( $country1  == "ZW") $country=
"Zimbabwe" ;



return $country;
    }

    public function headings(): array
    {

        return [
            'الاسم الأول',
            'الكنية',
            'اسم الأب',
            'اسم الأم',
             'كنية الام ',
              'رقم التواصل ',
              'مكان  الولادة',
            'تاريخ الولادة',
             'الجنس',
            'الجنسية',
            'الديانة',
            'رقم جواز السفر',
            ' الرقم الوطني',
            'مكان الاقامة ',
            'المدينة',
            
                'الايميل',
            '2 الهاتف',
             'الصف الدراسي',
        ];
    }
    public function collection()
    {

        set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');
        $product = DB::table('student_register')
     
        ->join('classes', 'student_register.class1', '=', 'classes.id')
        ->select('student_register.first_name','student_register.last_name','student_register.father_name','student_register.mather_name','student_register.last_mother_name',
       'student_register.phone','student_register.place_of_birth','student_register.date',DB::raw('(CASE
        WHEN student_register.gender = "1" THEN "ذكر"
        ELSE "انثى"
        END) AS gender') ,'student_register.nationality',DB::raw('(CASE
        WHEN student_register.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , 'student_register.passport_number',
        'student_register.the_ID_number',
        'student_register.country',
     
        'student_register.city',
        'student_register.email',
        'student_register.other_phone',
        
        'classes.name as class_name')->whereIn('student_register.id',$this->request->student)
        ->get();

        $collect = new Collection;
        foreach ($product as $item) {
             $item->nationality = $this->country($item->nationality);
            $item->country = $this->country($item->country);
            $collect->push($item);
        }
        // echo $collect;die;
        return $collect;
    }
}
