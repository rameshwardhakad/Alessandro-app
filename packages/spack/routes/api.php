<?php

use Illuminate\Support\Facades\Route;
use Spack\Http\Controllers\Api\AttachmentController;
use Spack\Http\Controllers\Api\AvatarUpload;
use Spack\Http\Controllers\Api\Charts;
use Spack\Http\Controllers\Api\CheckUpdates;
use Spack\Http\Controllers\Api\ChecklistItemController;
use Spack\Http\Controllers\Api\ColorOption;
use Spack\Http\Controllers\Api\CommentController;
use Spack\Http\Controllers\Api\FileUpload;
use Spack\Http\Controllers\Api\LogoUpload;
use Spack\Http\Controllers\Api\Metrics;
use Spack\Http\Controllers\Api\Notifications;
use Spack\Http\Controllers\Api\NotificationsRead;
use Spack\Http\Controllers\Api\ProfileController;
use Spack\Http\Controllers\Api\ProjectAll;
use Spack\Http\Controllers\Api\ProjectArchived;
use Spack\Http\Controllers\Api\ProjectController;
use Spack\Http\Controllers\Api\ProjectListController;
use Spack\Http\Controllers\Api\ProjectListSortController;
use Spack\Http\Controllers\Api\RoleController;
use Spack\Http\Controllers\Api\SettingsEmailController;
use Spack\Http\Controllers\Api\SettingsGeneralController;
use Spack\Http\Controllers\Api\TaskController;
use Spack\Http\Controllers\Api\TaskMove;
use Spack\Http\Controllers\Api\TaskSort;
use Spack\Http\Controllers\Api\UpdateApp;
use Spack\Http\Controllers\Api\UpdateRecipe;
use Spack\Http\Controllers\Api\UserAll;
use Spack\Http\Controllers\Api\UserController;

// Users
Route::get('/users/all', UserAll::class);

// Projects
Route::get('/projects/all', ProjectAll::class);
Route::get('/projects/archived', ProjectArchived::class);
Route::patch('/projects/{project}/archive', [ProjectController::class, 'archive']);
Route::patch('/projects/{project}/unarchive', [ProjectController::class, 'unarchive']);
Route::patch('/projects/{project}/sort', [ProjectController::class, 'sort']);
Route::patch('/projects/{project}/users', [ProjectController::class, 'users']);
Route::resource('/projects', ProjectController::class);
Route::get('/colors/options', ColorOption::class);
Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::resource('/users', UserController::class);

// Project Lists
Route::post('/project-lists', [ProjectListController::class, 'store']);
Route::patch('/project-lists/{projectList}', [ProjectListController::class, 'update']);
Route::delete('/project-lists/{projectList}', [ProjectListController::class, 'delete']);
Route::patch('/project-lists/{projectList}/sort', ProjectListSortController::class);

// Tasks
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::patch('/tasks/{task}/duedate', [TaskController::class, 'duedate']);
Route::patch('/tasks/{task}/archive', [TaskController::class, 'archive']);
Route::patch('/tasks/{task}/list', [TaskController::class, 'list']);
Route::patch('/tasks/{task}/assign', [TaskController::class, 'assign']);
Route::patch('/tasks/{task}/unassign', [TaskController::class, 'unassign']);
Route::patch('/tasks/{task}/title', [TaskController::class, 'title']);
Route::patch('/tasks/{task}/description', [TaskController::class, 'description']);
Route::post('/tasks/{task}/comments', [TaskController::class, 'comments']);
Route::patch('tasks/{task}/sort', TaskSort::class);
Route::patch('tasks/{task}/move', TaskMove::class);

// Checklist
Route::post('/checklist-items', [ChecklistItemController::class, 'store']);
Route::patch('/checklist-items/{checklistItem}', [ChecklistItemController::class, 'update']);
Route::patch('/checklist-items/{checklistItem}/toggle', [ChecklistItemController::class, 'toggle']);
Route::delete('/checklist-items/{checklistItem}', [ChecklistItemController::class, 'delete']);

// Comments
Route::delete('/comments/{comment}', [CommentController::class, 'delete']);

// Attachments
Route::post('/attachments', [AttachmentController::class, 'store']);
Route::delete('/attachments/{attachment}', [AttachmentController::class, 'delete']);

// Roles & Permissions
Route::resource('/roles', RoleController::class)->except('show');

// Notifications
Route::get('notifications', Notifications::class);
Route::post('notifications/read', NotificationsRead::class);

// General
// Route::resource('profile', ProfileController::class)->only(['create', 'store']);
Route::post('avatar', AvatarUpload::class);
Route::post('logo', LogoUpload::class);
Route::post('file', FileUpload::class);
Route::get('profile/create', [ProfileController::class, 'create']);
Route::post('profile', [ProfileController::class, 'store']);
Route::resource('settings/general', SettingsGeneralController::class)->only(['create', 'store']);
Route::resource('settings/email', SettingsEmailController::class)->only(['create', 'store']);

// Updates
Route::post('check-updates', CheckUpdates::class)->middleware('can:setting:updates');
Route::post('update-app', UpdateApp::class)->middleware('can:setting:updates');
Route::post('update-recipe', UpdateRecipe::class)->middleware('can:setting:updates');

// Home
Route::get('metrics', Metrics::class);
Route::get('charts', Charts::class);
