<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "count=" . App\Student_register::count() . PHP_EOL;
echo "max=" . (App\Student_register::max('id') ?: 0) . PHP_EOL;
$rows = App\Student_register::orderBy('id','desc')->take(10)->get(['id','first_name','last_name','personal_image','fourth_image','passbord','mather_page','father_page','certification','payment_receipt','mother_image','father_image','family_book','study_sequence','certification_nine']);
foreach ($rows as $r) {
  echo "ID={$r->id}|{$r->first_name}|{$r->last_name}" . PHP_EOL;
  foreach (['personal_image','fourth_image','passbord','mather_page','father_page','certification','payment_receipt','mother_image','father_image','family_book','study_sequence','certification_nine'] as $f) {
    $v = trim((string)$r->$f);
    if ($v !== '') {
      echo "  {$f}={$v}" . PHP_EOL;
    }
  }
}
