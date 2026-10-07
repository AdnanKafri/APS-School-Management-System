<?php

use Illuminate\Support\Facades\Route;

Route::prefix('complaint-portal')->name('complaint-portal.')->group(function () {
    Route::get('login', 'ComplaintOfficerLoginController@showLoginForm')->name('login');
    Route::post('login', 'ComplaintOfficerLoginController@login')->middleware('guest')->name('authenticate');
    Route::post('logout', 'ComplaintOfficerLoginController@logout')->middleware('complaint.portal:logout')->name('logout');
    Route::middleware('complaint.portal:view_complaints')->group(function () {
        Route::get('/', 'ComplaintPortalController@index')->name('index');
        Route::get('notifications', 'ComplaintPortalController@notifications')->middleware('complaint.portal:receive_complaint_notifications')->name('notifications');
        Route::post('notifications/{notificationId}/open', 'ComplaintPortalController@openNotification')->middleware('complaint.portal:receive_complaint_notifications')->name('notifications.open');
        Route::get('complaints/{id}', 'ComplaintPortalController@show')->name('show');
        Route::post('complaints/{id}/status', 'ComplaintPortalController@status')->middleware('complaint.portal:manage_complaints')->name('status');
        Route::post('complaints/{id}/archive', 'ComplaintPortalController@archive')->middleware('complaint.portal:archive_complaints')->name('archive');
    });
});
