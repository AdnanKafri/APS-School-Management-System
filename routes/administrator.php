<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'ADHAMMANger', 'middleware' => ['roleadministrator']], function () {
  Route::get('dashboard/administrator', 'administratorController@dashboard_administrator')->name('dashboard.administrator');
  Route::get('dashboard/administrator/sent_tasks', 'administratorController@administrator_sent_tasks')->name('dashboard.administrator_sent_tasks');
  Route::get('dashboard/administrator/pending_tasks', 'administratorController@administrator_pending_tasks')->name('dashboard.administrator_pending_tasks');
    Route::post('changeStatus/task', 'administratorController@changeStatusTask')->name('changeStatusTask');
    Route::post('dashboard/approveTask', 'administratorController@approveTask')->name('dashboard.approveTask');
    Route::post('dashboard/store_admin_task', 'administratorController@store_admin_task')->name('dashboard.store_admin_task');
    Route::post('dashboard/store_employee_task', 'administratorController@store_employee_task')->name('dashboard.store_employee_task');
});



Route::group(['prefix' => 'ADHAMMANger', 'middleware' => ['roleEmployeeAdmin']], function () {
    Route::get('dashboard/employeeAdmin', 'employeeAdministratorController@dashboard_employeeAdmin')->name('dashboard.employeeAdmin');
    Route::get('dashboard/employeeAdmin/sent_tasks', 'employeeAdministratorController@employeeAdmin_sent_tasks')->name('dashboard.employeeAdmin_sent_tasks');

    Route::post('changeStatusEmp/task', 'employeeAdministratorController@changeStatusTaskEmp')->name('changeStatusTaskEmp');

    Route::post('dashboard/store_inside_employee_task', 'employeeAdministratorController@store_inside_employee_task')->name('dashboard.store_inside_employee_task');
    Route::post('dashboard/store_outside_employee_task', 'employeeAdministratorController@store_outside_employee_task')->name('dashboard.store_outside_employee_task');

});
