<?php



use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
// use App\Http\Middleware\getAvailableLecture;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//هاد السطر لتعريف متحول قيمة paginte
define('paginate_num', '10');


Route::get("xxx", function(){
    return View::make("website.index ");
 });

// ============================================================
// SECURITY FIX: Artisan utility routes — admin-only access
// Previously: open to all (no auth). Now: auth + type=2 only.
// URLs are unchanged to preserve any existing bookmarks.
// ============================================================
Route::middleware(['auth', 'roleadmin'])->group(function () {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return 'Application cache has been cleared';
    });
    Route::get('/clear-config', function () {
        Artisan::call('config:clear');
        return 'Application config has been cleared';
    });
    Route::get('/make-job', function () {
        // NOTE: This route creates a test job — for dev use only.
        Artisan::call('make:job TestJob');
        return '-';
    });
    Route::get('publishpublish', function () {
        return Artisan::call('vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config');
    });
});

//روات التوجيه الى صفحة انتهاء فترة استقبال طلبات التوظيف
Route::get('/Recruitment_competition', function () {
    return view('website.Recruitment-competition');
})->name('Recruitment_competition');

Route::get('adh-login','websitecontroller@login')->name('website.login');

Route::post('/stu_register2', 'websitecontroller@stu_register')->name('website.stu_register');
Route::get('redirectTo404', function () {
  return view('errors.404');
});

Route::group([
  'prefix' => LaravelLocalization::setLocale(),
  'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

  Auth::routes();

  Route::get('/', 'websitecontroller@index')->name('website.index');
  Route::get('/faq', 'websitecontroller@faq')->name('website.faq');
  Route::get('/contact_us', 'websitecontroller@contact_us')->name('website.contact_us');

  Route::get('/contact', 'websitecontroller@contact')->name('website.contact');



  Route::post('/stu_register', 'websitecontroller@stu_register')->name('stu_register');

  Route::get('/lessons/{class_id}', 'websitecontroller@lessons')->name('website.lessons');

  Route::get('/about_us', 'websitecontroller@about_us')->name('website.about_us');


  Route::get('/contact', 'websitecontroller@contact')->name('website.contact');




  Route::get('/classes', 'websitecontroller@classes')->name('website.classes');



  Route::get('/events', 'websitecontroller@events')->name('website.events');
  Route::get('/book/{id}', 'websitecontroller@book')->name('website.book');


  Route::get('/event/single/{event_id}', 'websitecontroller@event_single')->name('website.event.single');


  Route::get('/blogs', 'websitecontroller@blogs')->name('website.blogs');


  Route::get('/blog/single/{blog_id}', 'websitecontroller@blog_single')->name('website.blog.single');


  Route::get('/news', 'websitecontroller@news')->name('website.news');

  Route::get('/employment', 'websitecontroller@employment')->name('website.employment');


  Route::get('/news/single/{news_id}', 'websitecontroller@news_single')->name('website.news.single');



  Route::get('/jobs', 'websitecontroller@jobs')->name('website.jobs');

  Route::post('/applicant/store', 'websitecontroller@applicant_store')->name('website.applicant.store');

  Route::post('/employee/store', 'websitecontroller@store_employee')->name('website.store_employee');

  Route::get('/register', 'websitecontroller@register')->name('website.register');

  Route::get('/faqs', 'websitecontroller@faqs')->name('website.faqs');


  Route::get('/search', 'websitecontroller@search')->name('website.search');
  Route::get('/ourteam', 'websitecontroller@ourteam')->name('website.ourteam');
});












Route::get('/SMARMANger', function () {
  if (Auth::check()) {

    if (auth()->user()->type == '2') {
      return redirect()->route('dashboard.index');
    } else if (auth()->user()->type == '1') {
      return redirect()->route('dashboard.teacher');
    } elseif (auth()->user()->type == '0') {
      return redirect()->route('dashboard');
    } elseif (auth()->user()->type == '3') {
      return redirect()->route('dashboard.supervisor');
    }
  }
  return redirect()->route('website.index');
});


Route::post('login1', 'websitecontroller@login1')->name('login1');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');






require base_path('routes/student.php');


require base_path('routes/supervisor.php');


require base_path('routes/coordinator.php');
require base_path('routes/acadsupervisor.php');


require base_path('routes/administrator.php');



require base_path('routes/teacher_legacy.php');
require base_path('routes/teacher.php');
require base_path('routes/admin.php');









require base_path('routes/smar_admin.php');


Route::get('/home', 'HomeController@index')->name('home');
Route::post('contact_website_store', 'websitecontroller@contact_store')->name('contact_store');

require base_path('routes/gradebook.php');

