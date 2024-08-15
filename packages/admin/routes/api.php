<?php

use Admin\Http\Controllers\Api\AvatarUpload;
use Admin\Http\Controllers\Api\Charts;
use Admin\Http\Controllers\Api\CheckUpdates;
use Admin\Http\Controllers\Api\CustomerController;
use Admin\Http\Controllers\Api\FrontFaqController;
use Admin\Http\Controllers\Api\FrontFeatureController;
use Admin\Http\Controllers\Api\FrontLogoUpload;
use Admin\Http\Controllers\Api\LogoUpload;
use Admin\Http\Controllers\Api\Metrics;
use Admin\Http\Controllers\Api\Notifications;
use Admin\Http\Controllers\Api\NotificationsRead;
use Admin\Http\Controllers\Api\PlanController;
use Admin\Http\Controllers\Api\ProfileController;
use Admin\Http\Controllers\Api\SettingsEmailController;
use Admin\Http\Controllers\Api\SettingsGeneralController;
use Admin\Http\Controllers\Api\SettingsGeneralFrontController;
use Admin\Http\Controllers\Api\SettingsSocialFrontController;
use Admin\Http\Controllers\Api\SettingsStripeController;
use Admin\Http\Controllers\Api\SubscriptionController;
use Admin\Http\Controllers\Api\UpdateApp;
use Admin\Http\Controllers\Api\UpdateRecipe;
use Illuminate\Support\Facades\Route;

// Notifications
Route::get('notifications', Notifications::class);
Route::post('notifications/read', NotificationsRead::class);

// Metrics
Route::get('metrics', Metrics::class);
Route::get('charts', Charts::class);

Route::get('customers', [CustomerController::class, 'index']);
Route::get('subscriptions', [SubscriptionController::class, 'index']);
Route::resource('plans', PlanController::class);

// Profile
Route::get('profile/create', [ProfileController::class, 'create']);
Route::post('profile', [ProfileController::class, 'store']);
Route::post('avatar', AvatarUpload::class);

// Settings
Route::resource('settings/general', SettingsGeneralController::class)->only(['create', 'store']);
Route::resource('settings/email', SettingsEmailController::class)->only(['create', 'store']);
Route::resource('settings/stripe', SettingsStripeController::class)->only(['create', 'store']);
Route::post('logo', LogoUpload::class);

// Front Site Settings
Route::resource('settings/front/general', SettingsGeneralFrontController::class)->only(['create', 'store']);
Route::resource('settings/front/social', SettingsSocialFrontController::class)->only(['create', 'store']);
Route::post('front/logo', FrontLogoUpload::class);
Route::resource('front/features', FrontFeatureController::class);
Route::resource('front/faq', FrontFaqController::class);

// Updates
Route::post('check-updates', CheckUpdates::class)->middleware('can:setting');
Route::post('update-app', UpdateApp::class)->middleware('can:setting');
Route::post('update-recipe', UpdateRecipe::class)->middleware('can:setting');
