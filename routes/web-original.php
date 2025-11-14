<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{
    WebsiteController,
    PageController as PageControllerF,
    TenderController as TenderControllerF,
    TechnicalEvaluationController as TechnicalEvaluationControllerF,
    FinalEvaluationController as FinalEvaluationControllerF,
    DirectorController,
    ManagementTeamController,
};
use App\Http\Controllers\Backend\{
    AdminController,
    RoleController,
    DashboardController,
    PermissionController,
    PageController,
    MenuController,
    ComponentController,
    PageComponentController,
    TenderPersonController,
    TenderCategoryController,
    TenderController,
    ProductTabController,
    ProductController,
    TabItemController,
    TabItemContentController,
    HotspotController,
    TenderAttachmentController,
    TechnicalEvaluationController,
    FinalEvaluationController,
    ManagementPersonController,
    ReportingController,
    GRCController,
};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\File;

Route::get('/logs', function () {
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
})->name('logs.read');

Route::get('/logs/clear', function () {
    $logPath = storage_path('logs/laravel.log');
    if (File::exists($logPath)) {
        File::put($logPath, '');
    }
    return redirect()->route('logs.read')->with('status', 'Log file cleared.');
})->name('logs.clear');

// Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
// });
Route::controller(WebsiteController::class)->as('website.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactPost')->name('contact.post');
    Route::prefix('page')->controller(PageControllerF::class)->as('page.')->group(function () {
        Route::get('/{id}', 'show')->name('show');
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

Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'loginPost'])->name('login.post');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::resources([
            'roles' => RoleController::class,
            'permissions' => PermissionController::class,
            'users' => AdminController::class,
        ]);
        Route::prefix('cms')->as('cms.')->group(function () {
            Route::prefix('pages')->controller(PageController::class)->as('pages.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{page}', 'edit')->name('edit');
                Route::put('/update/{page}', 'update')->name('update');
                Route::delete('/delete/{page}', 'destroy')->name('destroy');
                Route::post('/toggle-status', 'toggleStatus')->name('toggle-status');
            });
            Route::prefix('menus')->controller(MenuController::class)->as('menus.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{menu}', 'edit')->name('edit');
                Route::put('/update/{menu}', 'update')->name('update');
                Route::delete('/delete/{menu}', 'destroy')->name('destroy');
                Route::post('/toggle-status', 'toggleStatus')->name('toggle-status');
            });
            Route::prefix('components')->controller(ComponentController::class)->as('components.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{component}', 'edit')->name('edit');
                Route::get('/fields-render', 'fieldsRender')->name('fields-render');
                Route::put('/update/{component}', 'update')->name('update');
                Route::delete('/delete/{component}', 'destroy')->name('destroy');
                Route::post('/toggle-status', 'toggleStatus')->name('toggle-status');
            });
            Route::prefix('management-persons')->controller(ManagementPersonController::class)->as('management-persons.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{management_person}', 'edit')->name('edit');
                Route::put('/update/{management_person}', 'update')->name('update');
                Route::delete('/delete/{management_person}', 'destroy')->name('destroy');
                Route::post('/toggle-status', 'toggleStatus')->name('toggle-status');
                Route::get('/media-remove/{management_person}/{field}', 'mediaRemove')->name('media-remove');
            });
            Route::prefix('page-components')->controller(PageComponentController::class)->as('page-components.')->group(function () {
                Route::get('/{page}', 'index')->name('index');
                Route::get('/create/{page}', 'create')->name('create');
                Route::post('/store/{page}', 'store')->name('store');
                Route::get('/edit/{page}/{component}', 'edit')->name('edit');
                Route::delete('/delete/{page}/{component}', 'destroy')->name('destroy');
                Route::get('/media-remove/{component}/{field}', 'mediaRemove')->name('media-remove');
                Route::put('/update/{page}/{component}', 'update')->name('update');
            });
            Route::prefix('products')->controller(ProductController::class)->as('products.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{product}', 'edit')->name('edit');
                Route::put('/update/{product}', 'update')->name('update');
                Route::delete('/delete/{product}', 'destroy')->name('destroy');
                Route::get('/media-remove/{product}/{field}', 'mediaRemove')->name('media-remove');
            });
            Route::prefix('product-tabs')->controller(ProductTabController::class)->as('product-tabs.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create/{product}', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{product}/{product_tab}', 'edit')->name('edit');
                Route::put('/update/{product_tab}', 'update')->name('update');
                Route::delete('/delete/{product_tab}', 'destroy')->name('destroy');
            });
            Route::prefix('tab-items')->controller(TabItemController::class)->as('tab-items.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create/{product_tab}', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{tab_item}', 'edit')->name('edit');
                Route::put('/update/{tab_item}', 'update')->name('update');
                Route::delete('/delete/{tab_item}', 'destroy')->name('destroy');
                Route::get('/media-remove/{tab_item}/{field}', 'mediaRemove')->name('media-remove');
            });
            Route::prefix('tab-item-content')->controller(TabItemContentController::class)->as('tab-item-content.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create/{tab_item}', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{tab_item_content}', 'edit')->name('edit');
                Route::put('/update/{tab_item_content}', 'update')->name('update');
                Route::delete('/delete/{tab_item_content}', 'destroy')->name('destroy');
                Route::get('/media-remove/{tab_item_content}/{field}', 'mediaRemove')->name('media-remove');
            });
            Route::prefix('hotspots')->controller(HotspotController::class)->as('hotspots.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create/{tab_item_content}', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{hotspot}', 'edit')->name('edit');
                Route::put('/update/{hotspot}', 'update')->name('update');
                Route::delete('/delete/{hotspot}', 'destroy')->name('destroy');
                Route::get('/media-remove/{hotspot}/{field}', 'mediaRemove')->name('media-remove');
            });
        });
        Route::prefix('tender-persons')->controller(TenderPersonController::class)->as('tender-persons.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{tender_person}', 'edit')->name('edit');
            Route::put('/update/{tender_person}', 'update')->name('update');
            Route::delete('/delete/{tender_person}', 'destroy')->name('destroy');
        });
        Route::prefix('tender-categories')->controller(TenderCategoryController::class)->as('tender-categories.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{tender_category}', 'edit')->name('edit');
            Route::put('/update/{tender_category}', 'update')->name('update');
            Route::delete('/delete/{tender_category}', 'destroy')->name('destroy');
        });
        Route::prefix('tenders')->controller(TenderController::class)->as('tenders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{tender}', 'edit')->name('edit');
            Route::put('/update/{tender}', 'update')->name('update');
            Route::delete('/delete/{tender}', 'destroy')->name('destroy');
        });
        Route::prefix('tender-attachments')->controller(TenderAttachmentController::class)->as('tender-attachments.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{tender}', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{tender_attachment}', 'edit')->name('edit');
            Route::put('/update/{tender_attachment}', 'update')->name('update');
            Route::delete('/delete/{tender_attachment}', 'destroy')->name('destroy');
            Route::get('/media-remove/{tender_attachment}/{field}', 'mediaRemove')->name('media-remove');
        });
        Route::prefix('technical-evaluations')->controller(TechnicalEvaluationController::class)->as('technical-evaluations.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{technical_evaluation}', 'edit')->name('edit');
            Route::put('/update/{technical_evaluation}', 'update')->name('update');
            Route::delete('/delete/{technical_evaluation}', 'destroy')->name('destroy');
            Route::get('/media-remove/{technical_evaluation}/{field}', 'mediaRemove')->name('media-remove');
        });
        Route::prefix('final-evaluations')->controller(FinalEvaluationController::class)->as('final-evaluations.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{final_evaluation}', 'edit')->name('edit');
            Route::put('/update/{final_evaluation}', 'update')->name('update');
            Route::delete('/delete/{final_evaluation}', 'destroy')->name('destroy');
            Route::get('/media-remove/{final_evaluation}/{field}', 'mediaRemove')->name('media-remove');
        });
        Route::prefix('reporting')->controller(ReportingController::class)->as('reporting.')->group(function () {
            Route::get('/tenders', 'tenders')->name('tenders');
            Route::get('/technical-evaluations', 'technicalEvaluations')->name('technical-evaluations');
            Route::get('/final-evaluations', 'finalEvaluations')->name('final-evaluations');
        });
        Route::resource('grcs', GrcController::class);
    });
});
