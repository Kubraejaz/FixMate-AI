<?php

use App\Http\Controllers\Api\V1\BecomeTechnicianController;
use App\Http\Controllers\Api\V1\CommunityController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\PublicController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\TechnicianDirectoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public content & discovery (no authentication required)
|--------------------------------------------------------------------------
*/

Route::get('home', [PublicController::class, 'home'])->name('api.public.home');
Route::get('about', [PublicController::class, 'about'])->name('api.public.about');
Route::get('how-it-works', [PublicController::class, 'howItWorks'])->name('api.public.how-it-works');
Route::get('privacy-policy', [PublicController::class, 'privacyPolicy'])->name('api.public.privacy-policy');
Route::get('terms', [PublicController::class, 'terms'])->name('api.public.terms');
Route::get('how-it-works/steps', [PublicController::class, 'howItWorks'])->name('api.public.steps');

Route::get('services', [ServiceController::class, 'index'])->name('api.services.index');
Route::get('services/{slug}', [ServiceController::class, 'show'])->name('api.services.show');

Route::get('technicians', [TechnicianDirectoryController::class, 'index'])->name('api.technicians.index');
Route::get('technicians/{id}', [TechnicianDirectoryController::class, 'show'])->name('api.technicians.show');

Route::get('faqs', [FaqController::class, 'index'])->name('api.faqs.index');

Route::get('community', [CommunityController::class, 'index'])->name('api.community.index');
Route::get('community/{issue}', [CommunityController::class, 'show'])->name('api.community.show');
Route::middleware('throttle:api')->group(function () {
    Route::post('community/report', [CommunityController::class, 'store'])->name('api.community.store');
    Route::post('community/{issue}/upvote', [CommunityController::class, 'upvote'])->name('api.community.upvote');
    Route::post('contact', [ContactController::class, 'store'])->name('api.contact.store');
    Route::get('contact/track', [ContactController::class, 'track'])->name('api.contact.track');
    Route::post('become-technician', [BecomeTechnicianController::class, 'store'])->name('api.become-technician.store');
});
