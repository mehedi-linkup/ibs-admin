<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GmController;
use App\Http\Controllers\CadController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\FactoryController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CordinatorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SampleNameController;
use App\Http\Controllers\ProductDataController;
use App\Http\Controllers\WashingUnitController;
use App\Http\Controllers\ProductEntryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\WashCoordinatorController;
use App\Http\Controllers\FinishingCoordinatorController;
use App\Http\Controllers\MaterialsController;

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

// Authentication
Route::group(['middleware' => 'guest'], function(){
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'authCheack'])->name('login.check');
});


Route::group(['middleware' => ['auth']], function(){
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    // product
    Route::post('update_product', [ProductEntryController::class, 'updateProduct'])->name('update_product');
    Route::get('/product', [ProductEntryController::class, 'index'])->name('product.index');
    Route::post('/product', [ProductEntryController::class, 'store'])->name('product.store');
    Route::post('delete_product', [ProductEntryController::class, 'destroy'])->name('delete_product');
    Route::post('get_product', [ProductEntryController::class, 'getProduct']);
    Route::get('all_product', [ProductEntryController::class, 'productData']);
    Route::get('get_full_product', [ProductEntryController::class, 'getFullProduct'])->name('get.full.product');

    Route::get('product-search', [ProductEntryController::class, 'productSearch'])->name('product.search');
    Route::get('product-data-wise-search', [ProductEntryController::class, 'productDataWiseSearch'])->name('product.data.wise.search');
    Route::post('get_product_search', [ProductEntryController::class, 'getSearchResult']);

    // User Registration
    Route::get('/register',[RegistrationController::class, 'register'])->name('register');
    Route::get('get_user', [RegistrationController::class, 'getUser']);
    Route::post('save_user', [RegistrationController::class, 'SaveUser']);
    Route::post('update_user', [RegistrationController::class, 'updateUser']);
    Route::post('delete_user', [RegistrationController::class, 'deleteUser']);

    // User Role
    Route::get('role', [RoleController::class, 'index'])->name('role.index');
    Route::post('get_role', [RoleController::class, 'getRole']);
    Route::post('save_role', [RoleController::class, 'saveRole']);
    Route::post('update_role', [RoleController::class, 'updateRole']);
    Route::post('delete_role', [RoleController::class, 'deleteRole']);

    // Department 
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::post('get_department', [DepartmentController::class, 'getDepartment']);
    Route::post('save_department', [DepartmentController::class, 'saveDepartment']);
    Route::post('update_department', [DepartmentController::class, 'updateDepartment']);
    Route::post('delete_department', [DepartmentController::class, 'deleteDepartment']);
    // buyer
    Route::get('/buyer', [BuyerController::class, 'index'])->name('buyer.index');
    Route::post('get_buyer', [BuyerController::class, 'getBuyer']);
    Route::post('save_buyer', [BuyerController::class, 'saveBuyer']);
    Route::post('update_buyer', [BuyerController::class, 'updateBuyer']);
    Route::post('delete_buyer', [BuyerController::class, 'deleteBuyer']);

    // Factory
    Route::get('/factory', [FactoryController::class, 'index'])->name('factory.index');
    Route::post('get_factory', [FactoryController::class, 'getFactory']);
    Route::post('save_factory', [FactoryController::class, 'saveFactory']);
    Route::post('update_factory', [FactoryController::class, 'updateFactory']);
    Route::post('delete_factory', [FactoryController::class, 'deleteFactory']);

    // Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/get_supplier', [SupplierController::class, 'getSupplier']);
    Route::post('save_supplier', [SupplierController::class, 'saveSupplier']);
    Route::post('update_supplier', [SupplierController::class, 'updateSupplier']);
    Route::post('delete_supplier', [SupplierController::class, 'deleteSupplier']);

    // Color
    Route::get('/color', [ColorController::class, 'index'])->name('color.index');
    Route::post('get_color', [ColorController::class, 'getColor']);
    Route::post('save_color', [ColorController::class, 'saveColor']);
    Route::post('update_color', [ColorController::class, 'updateColor']);
    Route::post('delete_color', [ColorController::class, 'deleteColor']);

    // merchant
    Route::get('/merchant', [MerchantController::class, 'index'])->name('merchant.index');
    Route::post('get_merchant', [MerchantController::class, 'getMerchant']);
    Route::post('save_merchant', [MerchantController::class, 'saveMerchant']);
    Route::post('update_merchant', [MerchantController::class, 'updateMerchant']);
    Route::post('delete_merchant', [MerchantController::class, 'deleteMerchant']);
    
    // coordinator
    Route::get('/coordinator', [CordinatorController::class, 'index'])->name('coordinator.index');
    Route::post('get_coordinator', [CordinatorController::class, 'getCoordinator']);
    Route::post('save_coordinator', [CordinatorController::class, 'store']);
    Route::post('update_coordinator', [CordinatorController::class, 'update']);
    Route::post('delete_coordinator', [CordinatorController::class, 'delete']);

    // wash coordinator
    Route::get('/wash-coordinator', [WashCoordinatorController::class, 'index'])->name('wash.coordinator.index');
    Route::post('get_wash_coordinator', [WashCoordinatorController::class, 'getCoordinator']);
    Route::post('save_wash_coordinator', [WashCoordinatorController::class, 'store']);
    Route::post('update_wash_coordinator', [WashCoordinatorController::class, 'update']);
    Route::post('delete_wash_coordinator', [WashCoordinatorController::class, 'delete']);

    // Finishing coordinator
    Route::get('/finishing-coordinator', [FinishingCoordinatorController::class, 'index'])->name('finishing.coordinator.index');
    Route::post('get_finishing_coordinator', [FinishingCoordinatorController::class, 'getCoordinator']);
    Route::post('save_finishing_coordinator', [FinishingCoordinatorController::class, 'store']);
    Route::post('update_finishing_coordinator', [FinishingCoordinatorController::class, 'update']);
    Route::post('delete_finishing_coordinator', [FinishingCoordinatorController::class, 'delete']);

    // Wash Unit
    Route::get('/wash-unit', [WashingUnitController::class, 'index'])->name('wash.unit.index');
    Route::post('/get_wash_unit', [WashingUnitController::class, 'getWashUnit']);
    Route::post('save_wash_unit', [WashingUnitController::class, 'store']);
    Route::post('update_wash_unit', [WashingUnitController::class, 'update']);
    Route::post('delete_wash_unit', [WashingUnitController::class, 'delete']);
    
    // Unit
    Route::get('/unit', [UnitController::class, 'index'])->name('unit.index');
    Route::post('get_unit', [UnitController::class, 'getUnit']);
    Route::post('save_unit', [UnitController::class, 'saveUnit']);
    Route::post('update_unit', [UnitController::class, 'updateUnit']);
    Route::post('delete_unit', [UnitController::class, 'deleteUnit']);

    // Cad
    Route::get('/cad', [CadController::class, 'index'])->name('cad.index');
    Route::post('get_cads', [CadController::class, 'getCads']);
    Route::post('save_cad', [CadController::class, 'store']);
    Route::post('update_cad', [CadController::class, 'Update']);
    Route::post('delete_cad', [CadController::class, 'delete']);

    // GM
    Route::get('/gm', [GmController::class, 'index'])->name('gm.index');
    Route::post('get_gm', [GmController::class, 'getData']);
    Route::post('save_gm', [GmController::class, 'store']);
    Route::post('update_gm', [GmController::class, 'update']);
    Route::post('delete_gm', [GmController::class, 'delete']);

    // Sample Name
    Route::get('/sample_name', [SampleNameController::class, 'index'])->name('sample_name.index');
    Route::post('get_sample_name', [SampleNameController::class, 'getData']);
    Route::post('save_sample_name', [SampleNameController::class, 'store']);
    Route::post('update_sample_name', [SampleNameController::class, 'update']);
    Route::post('delete_sample_name', [SampleNameController::class, 'delete']);
    
    
    // productData 
    Route::get('product_data', [ProductDataController::class, 'index'])->name('product.data');
    Route::post('get_product_data', [ProductDataController::class, 'getData']);
    Route::post('save_product_data', [ProductDataController::class, 'store']);
    Route::post('update_product_data', [ProductDataController::class, 'update']);
    Route::post('delete_product_data', [ProductDataController::class, 'deleteData']);

    // permission
    Route::resource('/permission', PermissionController::class);

    // export table
    Route::get('order-file-export', [ExportController::class, 'productExport'])->name('product-file-export');
    Route::get('sample-file-export', [ExportController::class, 'sampleExport'])->name('sample-file-export');
    Route::get('order-details-file-export', [ExportController::class, 'ProductDataExport'])->name('order-details-export');

    // Order 
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order_data', [OrderController::class, 'OrderDataList'])->name('order.data');
    Route::post('/get_orders', [OrderController::class, 'getOrder']);
    Route::post('/save_order', [OrderController::class, 'saveOrder']);
    Route::post('/update_order', [OrderController::class, 'updateOrder']);
    Route::post('/delete_order', [OrderController::class, 'deleteOrder']);
    Route::post('/get_order_data', [OrderController::class, 'getOrderData']);
    Route::post('/save_order_data', [OrderController::class, 'AddOrderData']);
    Route::post('/update_order_data', [OrderController::class, 'UpdateOrderData']);
    Route::post('/delete_order_data', [OrderController::class, 'deleteOrderData']);
    Route::get('/order/details', [OrderController::class, 'OrderDetails'])->name('order.details');
    Route::post('/save_order_details', [OrderController::class, 'OrderDetailsSave']);
    Route::post('/get_order_details', [OrderController::class, 'getOrderDetails']);
    Route::post('/update_order_details', [OrderController::class, 'updateOrderDetails']);
    Route::post('/delete_order_details', [OrderController::class, 'deleteOrderDetails']);
    Route::post('/save_order_details_data', [OrderController::class, 'SaveOrderDetailsData']);
    // order details data
    Route::get('/order/details/data', [OrderController::class, 'OrderDetailsData'])->name('order.details.data');
    Route::post('/get_order_details_data', [OrderController::class, 'getOrderDetailsData']);
    Route::post('/update_order_details_data', [OrderController::class, 'UpdateOrderDetailsData']);
    Route::post('/delete_order_details_data', [OrderController::class, 'DeleteOrderDetailsData']);
    // oder search and filter
    Route::get('/order/search', [OrderController::class, 'OrderSearch'])->name('order.search');
    Route::get('/order/filter', [OrderController::class, 'OrderFilter'])->name('order.filter');
    Route::post('/get_order_search_result', [OrderController::class, 'getSearchResult']);

    // Sample 
    Route::get('/sample', [SampleController::class, 'index'])->name('sample.index');
    Route::get('/sample_data', [SampleController::class, 'SampleData'])->name('sample.data');
    Route::post('/get_samples', [SampleController::class, 'getSample']);
    Route::post('/save_sample', [SampleController::class, 'saveSample']);
    Route::post('/update_sample', [SampleController::class, 'updateSample']);
    Route::post('/delete_sample', [SampleController::class, 'deleteSample']);
    Route::post('/save_sample_data', [SampleController::class, 'AddSampleData']);
    Route::post('/get_sample_data', [SampleController::class, 'GetSampleData']);
    Route::post('/update_sample_data', [SampleController::class, 'UpdateSampleData']);
    Route::post('/delete_sample_data', [SampleController::class, 'DeleteSampleData']);
    Route::post('/cancel_sample_data', [SampleController::class, 'CancelSampleData']);
    Route::get('/get_accepted_date_data', [SampleController::class, 'GetAcceptedBlank']);
    Route::post('/insert_sample_data', [SampleController::class, 'insert']);
    Route::get('/blank_data', [SampleController::class, 'BlankData'])->name('blank.data');
    Route::post('/get_blank_data', [SampleController::class, 'GetBlankData']);
    Route::post('/active_sample_data', [SampleController::class, 'ActiveSampleData']);
    Route::post('/inactive_sample_data', [SampleController::class, 'InActiveSampleData']);
    Route::get('/inactive_data', [SampleController::class, 'InactiveData'])->name('inactive.data');
    Route::get('/sample/view/{id}', [SampleController::class, 'sampleDataView'])->name('sample.data.view');

    // Materials 
    Route::get('/materials', [MaterialsController::class, 'index'])->name('materials.index');
    Route::post('/get_materias', [MaterialsController::class, 'getMaterials']);
    Route::post('/save_materias', [MaterialsController::class, 'store']);
    Route::post('/update_materias', [MaterialsController::class, 'update']);
    Route::post('/delete_materias', [MaterialsController::class, 'destroy']);
    Route::post('/save_use_qty', [MaterialsController::class, 'addUseQty']);
    Route::get('/materials/view/{id}', [MaterialsController::class, 'viewMaterials']);
    Route::post('/get_used_qty', [MaterialsController::class, 'getUsedQty']);
    Route::post('/reset_quantity', [MaterialsController::class, 'resetData']);
    Route::get('/blank/materials', [MaterialsController::class, 'blankMaterials'])->name('blank.materials');

    //Cache clear
    Route::get('clear', function(){
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');
        return 'Done';
    });
});