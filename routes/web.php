<?php

use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\MedicalController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\ExpenditureSubCategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeFieldController;
use App\Http\Controllers\IncomeSubCategoryController;
use App\Http\Controllers\OutdoorController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Auth::routes(['register' => false]);


Route::get('/home', [HomeController::class, 'index'])->name('home');



Route::group(['prefix' => 'users', 'middleware' => ['auth']], function () {
    Route::get('/view', [UserController::class, 'view'])->name('backUsersView');
    Route::get('/add', [UserController::class, 'add'])->name('backUsersAdd');
    Route::post('/store', [UserController::class, 'store'])->name('backUsersStore');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('backUsersEdit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('backUsersUpdate');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('backUsersDelete');
});


Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('/view', [ProfileController::class, 'view'])->name('profileView');
    Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('profileEdit');
    Route::post('/update/{id}', [ProfileController::class, 'update'])->name('profileUpdate');
    Route::get('/password/view', [ProfileController::class, 'passwordView'])->name('profilePasswordView');
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('updatePassword');
});

Route::group(['prefix' => 'patients', 'middleware' => ['auth']], function () {


    Route::get('/registration/form', [MedicalController::class, 'registration_form'])->name('registration_form');

    Route::get('/registered/admit/patients/view/{patient_id}', [MedicalController::class, 'regi_form_view'])->name('regi_form_view');
    Route::get('/admission/form/', [MedicalController::class, 'admission_form'])->name('admission_form');


    Route::post('/registration/form/save', [MedicalController::class, 'storeRegistration'])->name('storeRegistration');
});


Route::group(['prefix' => 'admission', 'middleware' => ['auth']], function () {

    Route::get('/form/view', [MedicalController::class, 'admission_form_view'])->name('admission_form_view');
    Route::post('/form/save', [MedicalController::class, 'admission_form_save'])->name('admission_form_save');
    Route::get('/registered/patients', [MedicalController::class, 'all_regi_patient'])->name('all_regi_patient');
});




Route::group(['prefix' => 'cash-memo', 'middleware' => ['auth']], function () {

    Route::get('/generate/form/{id}', [MedicalController::class, 'cash_memo_form'])->name('cash_memo_form');
    Route::post('/memo/generate/save', [MedicalController::class, 'cash_memo_form_save'])->name('cash_memo_form_save');
    Route::get('/generate/receipt', [MedicalController::class, 'receipt_generate'])->name('receipt_generate');
    Route::get('/form/view/{id}', [MedicalController::class, 'view_cash_memo'])->name('view_cash_memo');
    Route::get('/form/edit/{id}', [MedicalController::class, 'edit_cash_memo'])->name('edit_cash_memo');

    Route::post('/cash-memo/update/{id}', [MedicalController::class, 'updateDueAmount'])->name('updateDueAmount');
});


Route::group(['prefix' => 'outdoor', 'middleware' => ['auth']], function () {

    Route::get('/registration/form', [OutdoorController::class, 'outdoor_regi_form'])->name('outdoor_regi_form');
    Route::get('/registered/patients', [OutdoorController::class, 'all_out_regi_patient'])->name('all_out_regi_patient');
    Route::get('/registered/patients/view/{patient_id}', [OutdoorController::class, 'outdoor_regi_form_view'])->name('outdoor_regi_form_view');
    Route::post('/registration/form/save', [OutdoorController::class, 'storeOutdoor_regi_form'])->name('storeOutdoor_regi_form');


    // Outdoor Income show by Day Week Month and Year based 



});


Route::group(['prefix' => 'accounts', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/outdoor', [AccountController::class, 'outdoor_income'])->name('outdoor_income');

    Route::get('/getting-income', [AccountController::class, 'gettingIncome'])->name('gettingIncome');

    Route::get('/expenditure/', [AccountController::class, 'expenditureCalculation'])->name('expenditureCalculation');

    Route::get('/income/', [AccountController::class, 'incomeCalculation'])->name('incomeCalculation');

    Route::get('/outdoor', [AccountController::class, 'outdoor_income'])->name('outdoor_income');

    Route::get('/indoor', [AccountController::class, 'indoor_income'])->name('indoor_income');

    // Account Books Controller 
    Route::get('/account/books/todays', [AccountController::class, 'accountsBook'])->name('accountsBook');


    // Accounts Fetch Data by Date and Time

    // Outdoor
    Route::get('/outdoor/search/todays', [SearchController::class, 'dataTwentyFourHour'])->name('dataTwentyFourHour');
    Route::get('/outdoor/search/current-month', [SearchController::class, 'getCurrentMonthRevenue'])->name('getCurrentMonthRevenue');
    Route::get('/outdoor/search/last-month', [SearchController::class, 'getLastMonthRevenue'])->name('getLastMonthRevenue');

    // Indoor
    Route::get('/indoor/search/todays', [SearchController::class, 'indoorTwentyFourHour'])->name('indoorTwentyFourHour');
    Route::get('/indoor/search/current-month', [SearchController::class, 'indoorGetCurrentMonthRevenue'])->name('indoorGetCurrentMonthRevenue');
    Route::get('/indoor/search/last-month', [SearchController::class, 'indoorGetLastMonthRevenue'])->name('indoorGetLastMonthRevenue');

    // Expenditure
    Route::get('/expenditure/search/todays', [SearchController::class, 'expTwentyFourHour'])->name('expTwentyFourHour');
    Route::get('/expenditure/search/current-month', [SearchController::class, 'expGetCurrentMonthRevenue'])->name('expGetCurrentMonthRevenue');
    Route::get('/expenditure/search/last-month', [SearchController::class, 'expGetLastMonthRevenue'])->name('expGetLastMonthRevenue');

    // Others Income
    Route::get('/others/search/todays', [SearchController::class, 'othersTwentyFourHour'])->name('othersTwentyFourHour');
    Route::get('/others/search/current-month', [SearchController::class, 'othersGetCurrentMonthRevenue'])->name('othersGetCurrentMonthRevenue');
    Route::get('/others/search/last-month', [SearchController::class, 'othersGetLastMonthRevenue'])->name('othersGetLastMonthRevenue');


    Route::get('/search/date', [SearchController::class, 'getDatedData'])->name('getDatedData');
});











Route::group(['prefix' => 'data-entry', 'middleware' => ['auth']], function () {


    // Expenditure
    Route::get('/add-expenditure/category', [ExpenditureCategoryController::class, 'add_expenditure_index'])->name('add_expenditure_index');
    Route::post('/store-expenditure/category', [ExpenditureCategoryController::class, 'store_exp_category'])->name('store_exp_category');
    Route::get('category/delete/{id}', [ExpenditureCategoryController::class, 'delete'])->name('deleteCategory');


    // Income
    Route::get('/add-income/category', [IncomeCategoryController::class, 'add_income_index'])->name('add_income_index');
    Route::post('/store-income/category', [IncomeCategoryController::class, 'store_income_category'])->name('store_income_category');
    Route::get('category/income/delete/{id}', [IncomeCategoryController::class, 'delete'])->name('deleteIncomeCategory');


    // Sub category Expenditure
    Route::get('/add-expenditure/sub-category', [ExpenditureSubCategoryController::class, 'index'])->name('subcategory');
    Route::post('/store/expenditure/sub-category', [ExpenditureSubCategoryController::class, 'store'])->name('StoreSubcategory');
    // Route::get('/info/expenditure/sub/{id}', [ExpenditureSubCategoryController::class, 'show'])->name('showSub');


    // Sub category Income
    Route::get('/add-income/sub-category', [IncomeSubCategoryController::class, 'index'])->name('Incomesubcategory');
    Route::post('/store/income/sub-category', [IncomeSubCategoryController::class, 'store'])->name('StoreIncomeSubcategory');
    // Route::get('/info/expenditure/sub/{id}', [ExpenditureSubCategoryController::class, 'show'])->name('showSub');


    // Expenditure Form
    Route::get('/expenditure/form', [ExpenditureController::class, 'expenditure_form'])->name('expenditure_form');
    // Ajax calling Route
    Route::get('/get_subcategory/{id}', [ExpenditureController::class, 'getSubCategory'])->name('getSubCategory');
    Route::post('/store/get_subcategory', [ExpenditureController::class, 'store'])->name('storeExpForm');


    // Income Form
    Route::get('/income/form', [IncomeFieldController::class, 'income_form'])->name('income_form');
    // Ajax calling Route
    Route::get('/get_subcategory/income/{id}', [IncomeFieldController::class, 'getIncomeSubCategory'])->name('getIncomeSubCategory');

    Route::post('/store/income/get_subcategory', [IncomeFieldController::class, 'store'])->name('storeIncomeForm');



    // Add Service
    Route::get('/service/create', [MedicalController::class, 'service_index'])->name('service_index');
    Route::post('/service/store', [MedicalController::class, 'service_store'])->name('service_store');
    Route::get('/service/delete', [MedicalController::class, 'delete_service'])->name('delete_service');
});



// Delete Web Controller 

Route::group(['prefix' => 'delete', 'middleware' => ['auth']], function () {
    Route::get('/patient/history/{id}', [DeleteController::class, 'destroyPatient'])->name('destroyPatient');
    Route::get('/OUTDOOR/history/{id}', [DeleteController::class, 'destroyOutdoorPatient'])->name('destroyOutdoorPatient');
});
