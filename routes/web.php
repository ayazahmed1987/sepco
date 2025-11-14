<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{
    WebsiteController,
	SearchController,
    PageController as PageControllerF,
    TenderController as TenderControllerF,
    TechnicalEvaluationController as TechnicalEvaluationControllerF,
    FinalEvaluationController as FinalEvaluationControllerF,
    DirectorController,
    ManagementTeamController,
	
};

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\File;


Route::get('/read/logs', function () {
    try {
        $logFile = file(storage_path() . '/logs/laravel.log');
        if ($logFile) {
            $logCollection = [];
            foreach ($logFile as $line_num => $line) {
                $logCollection[] = array('line' => $line_num, 'content' => htmlspecialchars($line));
            }
            return $logCollection;
        }
    } catch (\Exception $e) {
        return "no file found";
    }
})->name('read.logs');

Route::get('/delete/logs', function () {
    $logPath = storage_path('logs/laravel.log');
    if (File::exists($logPath)) {
        File::put($logPath, '');
    }
    return redirect()->route('read.logs')->with('status', 'Log file cleared.');
})->name('delete.logs');

// Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
// });

Route::controller(WebsiteController::class)->as('website.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/contact', 'contact')->name('contact');
	Route::get('/sitemap', 'sitemap')->name('sitemap');
    Route::post('/contact', 'contactPost')->name('contact.post');
	Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::prefix('page')->controller(PageControllerF::class)->as('page.')->group(function () {
        Route::get('/{id}', 'show')->name('show');
    });
	Route::prefix('post')->controller(PageControllerF::class)->as('post.')->group(function () {
        Route::get('/{id}/{title?}', 'postshow')->name('show');
    });
    Route::prefix('GRC')->controller(PageControllerF::class)->as('grc.')->group(function () {
        Route::get('/', 'grc')->name('index');
    });
    Route::prefix('board-of-directors')->controller(DirectorController::class)->as('board-of-directors.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}/detail', 'detail')->name('detail');
    });
    Route::prefix('management-team')->controller(ManagementTeamController::class)->as('management-team.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}/detail', 'detail')->name('detail');
    });
    Route::prefix('tenders')->controller(TenderControllerF::class)->as('tender.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/attachments/{id}', 'getAttachments')->name('getAttachments');
    });
    Route::prefix('technical-evaluations')->controller(TechnicalEvaluationControllerF::class)->as('technical-evaluations.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    Route::prefix('final-evaluations')->controller(FinalEvaluationControllerF::class)->as('final-evaluations.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
});