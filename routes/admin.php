<?php
use Illuminate\Support\Facades\Route;
Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

Route::get('user_roles/list','Admin\UserRoleController@index')->name('user_roles.list');
Route::get('user_roles/create','Admin\UserRoleController@create')->name('user_roles.create');
Route::get('user_roles/edit/{id}','Admin\UserRoleController@create')->name('user_roles.edit');
Route::post('user_roles/submit','Admin\UserRoleController@submit')->name('user_roles.submit');
Route::post('user_roles/delete/{id}','Admin\UserRoleController@delete')->name('user_roles.delete');
Route::post('user_roles/get_role_list','Admin\UserRoleController@getroleList')->name('getRoleList');
Route::post('user_roles/status_change/{id}','Admin\UserRoleController@change_status')->name('user_roles.status_change');

// Customer Types
Route::get('customer_types/list','Admin\CustomerTypeController@index')->name('customer_types.list');
Route::get('customer_types/create','Admin\CustomerTypeController@create')->name('customer_types.create');
Route::get('customer_types/edit/{id}','Admin\CustomerTypeController@create')->name('customer_types.edit');
Route::post('customer_types/submit','Admin\CustomerTypeController@submit')->name('customer_types.submit');
Route::post('customer_types/delete/{id}','Admin\CustomerTypeController@delete')->name('customer_types.delete');
Route::post('customer_types/get_type_list','Admin\CustomerTypeController@getCustomeTypeList')->name('getCustomeTypeList');
Route::post('customer_types/status_change/{id}','Admin\CustomerTypeController@change_status')->name('customer_types.status_change');

//country
Route::get('countries/list','Admin\CountryController@index')->name('countries.list');
Route::get('countries/create','Admin\CountryController@create')->name('countries.create');
Route::get('countries/edit/{id}','Admin\CountryController@create')->name('countries.edit');
Route::post('countries/submit','Admin\CountryController@submit')->name('countries.submit');
Route::post('countries/delete/{id}','Admin\CountryController@delete')->name('countries.delete');
Route::post('countries/get_country_list','Admin\CountryController@getcountryList')->name('getcountryList');
Route::post('countries/status_change/{id}','Admin\CountryController@change_status')->name('countries.status_change');

//city
Route::get('cities/list','Admin\CityController@index')->name('cities.list');
Route::get('cities/create','Admin\CityController@create')->name('cities.create');
Route::get('cities/edit/{id}','Admin\CityController@create')->name('cities.edit');
Route::post('cities/submit','Admin\CityController@submit')->name('cities.submit');
Route::post('cities/delete/{id}','Admin\CityController@delete')->name('cities.delete');
Route::post('cities/get_cities_list','Admin\CityController@getcityList')->name('getcityList');
Route::post('cities/status_change/{id}','Admin\CityController@change_status')->name('cities.status_change');
Route::get('cities/get_cities_option','Admin\CityController@getcityOptions')->name('get.cities');


//langauges
Route::get('languages/list','Admin\LanguageController@index')->name('languages.list');
Route::get('languages/create','Admin\LanguageController@create')->name('languages.create');
Route::get('languages/edit/{id}','Admin\LanguageController@create')->name('languages.edit');
Route::post('languages/submit','Admin\LanguageController@submit')->name('languages.submit');
Route::post('languages/delete/{id}','Admin\LanguageController@delete')->name('languages.delete');
Route::post('languages/get_country_list','Admin\LanguageController@getlanguageList')->name('getlanguageList');
Route::post('languages/status_change/{id}','Admin\LanguageController@change_status')->name('languages.status_change');

//Catgory
Route::get('category/list','Admin\CategoryController@index')->name('category.list');
Route::get('category/create','Admin\CategoryController@create')->name('category.create');
Route::get('category/edit/{id}','Admin\CategoryController@create')->name('category.edit');
Route::post('category/submit','Admin\CategoryController@submit')->name('category.submit');
Route::post('category/delete/{id}','Admin\CategoryController@delete')->name('category.delete');
Route::post('category/get_brand_list','Admin\CategoryController@getCategoryList')->name('getCategoryList');
Route::post('category/status_change/{id}','Admin\CategoryController@change_status')->name('category.status_change');

//langauges
Route::get('malls/list','Admin\MallController@index')->name('malls.list');
Route::get('malls/create','Admin\MallController@create')->name('malls.create');
Route::get('malls/edit/{id}','Admin\MallController@create')->name('malls.edit');
Route::post('malls/submit','Admin\MallController@submit')->name('malls.submit');
Route::post('malls/delete/{id}','Admin\MallController@delete')->name('malls.delete');
Route::post('malls/get_mall_list','Admin\MallController@getmallList')->name('getmallList');
Route::post('malls/status_change/{id}','Admin\MallController@change_status')->name('malls.status_change');
Route::get('malls/zone/{id}','Admin\MallController@getZone')->name('malls.getZone');
//Users
Route::get('users/list','Admin\UserController@index')->name('users.list');
Route::post('users/get_user_list','Admin\UserController@getuserList')->name('getuserList');
Route::post('users/delete/{id}','Admin\UserController@delete')->name('users.delete');
Route::post('users/status_change/{id}','Admin\UserController@change_status')->name('users.status_change');
Route::get('users/create','Admin\UserController@create')->name('users.create');
Route::get('users/create/{id}','Admin\UserController@edit')->name('users.edit');
Route::get('users/view/{id}','Admin\UserController@view')->name('users.view');
Route::post('users/submit','Admin\UserController@submit')->name('users.submit');
Route::post('users/update','Admin\UserController@update')->name('users.update');

//Drivers
Route::get('drivers/list','Admin\DriverController@index')->name('drivers.list');
Route::post('drivers/get_user_list','Admin\DriverController@getdriversList')->name('getdriversList');
Route::post('drivers/delete/{id}','Admin\DriverController@delete')->name('drivers.delete');
Route::post('drivers/status_change/{id}','Admin\DriverController@change_status')->name('drivers.status_change');
Route::get('drivers/create','Admin\DriverController@create')->name('drivers.create');
Route::get('drivers/edit/{id}','Admin\DriverController@edit')->name('drivers.edit');
Route::get('drivers/view/{id}','Admin\DriverController@view')->name('drivers.view');
Route::post('drivers/submit','Admin\DriverController@submit')->name('drivers.submit');
Route::post('drivers/update/{id}','Admin\DriverController@update')->name('drivers.update');
Route::get('driver/earning/{id}','Admin\DriverController@earning')->name('drivers.earning');
Route::post('driver/get_earning_list','Admin\DriverController@getearningList')->name('driver.getearningList');
Route::post('drivers/delete_phone','Admin\DriverController@delete_phone')->name('drivers.delete_phone');
Route::get('driver/ExportDriver','Admin\DriverController@ExportDriver')->name('drivers.ExportDriver');
Route::post('driver/driver_import','Admin\DriverController@driver_import')->name('drivers.driver_import');
//Bookings
Route::get('bookings/list','Admin\BookingController@index')->name('bookings.list');
Route::post('bookings/get_booking_list','Admin\BookingController@getbookingList')->name('getbookingList');
Route::post('bookings/get_booking_qoutes/{id}','Admin\BookingController@getBookingQouteList')->name('getBookingQouteList');
Route::get('bookings/create','Admin\BookingController@create')->name('bookings.create');
Route::get('bookings/edit/{id}','Admin\BookingController@edit')->name('bookings.edit');
Route::get('bookings/view/{id}','Admin\BookingController@view')->name('bookings.view');
Route::post('bookings/store','Admin\BookingController@store')->name('bookings.store');
Route::post('bookings/update/{id}','Admin\BookingController@update')->name('bookings.update');
Route::post('bookings/get_drivers','Admin\BookingController@get_drivers')->name('get_drivers');
Route::get('bookings/qoutes/{id}','Admin\BookingController@booking_qoutes')->name('booking.qoutes');
Route::get('bookings/status/{id}/{status}','Admin\BookingController@change_status')->name('booking_status');
Route::post('bookings/delete/{id}','Admin\BookingController@delete')->name('bookings.delete');
Route::post('bookings/add_commission','Admin\BookingController@add_commission')->name('bookings.add.commission');
Route::post('bookings/assign_drvivers/{id}','Admin\BookingController@assign_drvivers')->name('bookings.assign.drvivers');
Route::get('bookings/payment/{id}/{status}','Admin\BookingController@payment_status')->name('payment_status');
Route::post('bookings/approve_qoutes','Admin\BookingController@approve_qoutes')->name('approve.qoutes');
Route::post('bookings/accept_qoutes','Admin\BookingController@accept_qoutes')->name('accept.qoutes');
Route::post('bookings/add_qoutes_commission','Admin\BookingController@add_qoutes_commission')->name('add.qoutes.commission');

Route::post('bookings/add_update_qoutes','Admin\BookingController@add_update_qoutes')->name('add.qoutes.save');

//Warehousing Booking
Route::post('bookings/update_warehousing/{id}','Admin\BookingController@update_warehousing')->name('bookings.update.warehousing');

//Air Freight Booking
Route::post('bookings/update_airfreight/{id}','Admin\BookingController@update_airfreight')->name('bookings.update.airfreight');

//Trucking Booking
Route::post('bookings/update_trucking/{id}','Admin\BookingController@update_trucking')->name('bookings.update.trucking');


Route::get('bookings/import','Admin\ImportBookingController@index')->name('bookings.import');

Route::get('bookings/download/csv','Admin\ImportBookingController@download_csv')->name('bookings.download.csv');

Route::post('bookings/import/csv','Admin\ImportBookingController@import')->name('bookings.import.csv');

Route::post('bookings/get_booking_charges','Admin\BookingController@get_booking_charges')->name('get.booking.charges');
Route::post('bookings/add_booking_charges','Admin\BookingController@add_booking_charges')->name('add.booking.charges');
Route::post('bookings/remove_booking_charges','Admin\BookingController@remove_booking_charges')->name('remove.booking.charges');

Route::post('bookings/get_booking_payments','Admin\BookingController@get_booking_payments')->name('get.booking.payments');
Route::post('bookings/add_booking_payments','Admin\BookingController@add_booking_payments')->name('add.booking.payments');

//Earnings
Route::get('earnings/list','Admin\EarningController@index')->name('earnings.list');
Route::post('bookings/get_earning_list/{from?}/{to?}','Admin\EarningController@getearningList')->name('getearningList');

//Reports
Route::get('reports/jobs_in_transit','Admin\ReportController@jobs_in_transit')->name('reports.jobs_in_transit');
Route::get('reports/customers','Admin\ReportController@customers')->name('reports.customers');
Route::post('reports/customers_list','Admin\ReportController@getcustomerTotalList')->name('reports.getcustomerreport');
Route::get('reports/drivers','Admin\ReportController@drivers')->name('reports.drivers');
Route::get('reports/companies','Admin\ReportController@companies')->name('reports.companies');

//Customers
Route::get('customers/list','Admin\CustomerController@index')->name('customers.list');
Route::post('customers/get_user_list','Admin\CustomerController@getcustomerList')->name('getcustomerList');
Route::post('customers/delete/{id}','Admin\CustomerController@delete')->name('customers.delete');
Route::post('customers/status_change/{id}','Admin\CustomerController@change_status')->name('customers.status_change');
Route::get('customers/edit/{id}','Admin\CustomerController@edit')->name('customers.edit');
Route::get('customers/view/{id}','Admin\CustomerController@view')->name('customers.view');
Route::post('customers/update/{id}','Admin\CustomerController@update')->name('customers.update');

//Events
Route::get('events','Admin\EventController@index')->name('events');
Route::get('events/create','Admin\EventController@create')->name('events.create');
Route::get('events/edit/{id}','Admin\EventController@create')->name('events.edit');
Route::post('events/submit','Admin\EventController@submit')->name('events.submit');
Route::post('events/delete/{id}','Admin\EventController@delete')->name('events.delete');
Route::post('events/datatable','Admin\EventController@getEventsList')->name('events.datatable');
Route::post('events/status_change/{id}','Admin\EventController@change_status')->name('events.status_change');

//Products
Route::get('products','Admin\ProductController@index')->name('products');
Route::get('products/create','Admin\ProductController@create')->name('products.create');
Route::get('products/edit/{id}','Admin\ProductController@create')->name('products.edit');
Route::post('products/submit','Admin\ProductController@store')->name('products.submit');
Route::post('products/delete/{id}','Admin\ProductController@delete')->name('products.delete');

Route::post('products/datatable','Admin\ProductController@getProductList')->name('products.datatable');
Route::post('products/status_change/{id}','Admin\ProductController@change_status')->name('products.status_change');


//Catgory
Route::get('product-categories/list','Admin\ProductCategoryController@index')->name('product-categories.list');
Route::get('product-categories/create','Admin\ProductCategoryController@create')->name('product-categories.create');
Route::get('product-categories/edit/{id}','Admin\ProductCategoryController@create')->name('product-categories.edit');
Route::post('product-categories/submit','Admin\ProductCategoryController@submit')->name('product-categories.submit');
Route::post('product-categories/delete/{id}','Admin\ProductCategoryController@delete')->name('product-categories.delete');
Route::post('product-categories/datatable','Admin\ProductCategoryController@getCategoryList')->name('product-categories.dataTable');
Route::post('product-categories/status_change/{id}','Admin\ProductCategoryController@change_status')->name('product-categories.status_change');

//CMS Pages
Route::get('pages/list','Admin\PageController@index')->name('cms.pages.list');
Route::get('pages/create','Admin\PageController@create')->name('cms.pages.create');
Route::get('pages/edit/{id}','Admin\PageController@create')->name('cms.pages.edit');
Route::post('pages/submit','Admin\PageController@submit')->name('cms.pages.submit');
Route::post('pages/delete/{id}','Admin\PageController@delete')->name('cms.pages.delete');
Route::post('pages/datatable','Admin\PageController@getPagesList')->name('cms.pages.dataTable');
Route::post('pages/status_change/{id}','Admin\PageController@change_status')->name('cms.pages.status_change');

Route::get('faq/list','Admin\FaqController@index')->name('cms.faq.list');
Route::get('faq/create','Admin\FaqController@create')->name('cms.faq.create');
Route::get('faq/edit/{id}','Admin\FaqController@create')->name('cms.faq.edit');
Route::post('faq/submit','Admin\FaqController@submit')->name('cms.faq.submit');
Route::post('faq/delete/{id}','Admin\FaqController@delete')->name('cms.faq.delete');
Route::post('faq/datatable','Admin\FaqController@getPagesList')->name('cms.faq.dataTable');
Route::post('faq/status_change/{id}','Admin\FaqController@change_status')->name('cms.faq.status_change');



Route::get('settings','Admin\PageController@appSettings')->name('settings');
Route::post('save_settings','Admin\PageController@saveSettings')->name('save_settings');


Route::get('help_request','Admin\PageController@helpRequest')->name('help_request');
Route::post('help_request_data','Admin\PageController@getHelpData')->name('help_request_data');
//Settings
Route::get('change-password','Admin\SettingController@index')->name('settings.change-password');
Route::post('change-password/submit','Admin\SettingController@changePassword')->name('settings.change-password.submit');

// company Types
Route::get('company/list','Admin\CompaniesController@index')->name('company.list');
Route::get('company/create','Admin\CompaniesController@create')->name('company.create');
Route::get('company/edit/{id}','Admin\CompaniesController@create')->name('company.edit');
Route::get('company/view/{id}','Admin\CompaniesController@view')->name('company.view');
Route::post('company/submit','Admin\CompaniesController@submit')->name('company.submit');
Route::post('company/delete/{id}','Admin\CompaniesController@delete')->name('company.delete');
Route::post('company/list','Admin\CompaniesController@getCompanyList')->name('getCompanyList');
Route::post('company/status_change/{id}','Admin\CompaniesController@change_status')->name('company.status_change');


//address
Route::get('address/list','Admin\AddressController@index')->name('address.list');
Route::get('address/create','Admin\AddressController@create')->name('address.create');
Route::get('address/edit/{id}','Admin\AddressController@create')->name('address.edit');
Route::post('address/delete/{id}','Admin\AddressController@delete')->name('address.delete');
Route::post('address/list','Admin\AddressController@getaddressList')->name('getaddressList');
Route::post('address/submit','Admin\AddressController@submit')->name('address.submit');
Route::post('address/get_list','Admin\AddressController@get_list')->name('address.get_list');


// customres

Route::get('customers/lists/all','Admin\CustomerController@listCust')->name('customers.list.all');
Route::post('customers/get_list_total/al','Admin\CustomerController@getcustomerTotalList')->name('getcustomerTotalList');
Route::get('customers/insert/view','Admin\CustomerController@detailView')->name('customer.detail.view');
Route::post('customers/status_active/{id}','Admin\CustomerController@change_status_cus')->name('customers.status_active');
Route::get('customerss/create/data','Admin\CustomerController@createCus')->name('customers.create.data');
Route::post('customer_csv/submit','Admin\CustomerController@submitCsv')->name('customer_csv.submit');
Route::post('customers/insert','Admin\CustomerController@insert')->name('customer.insert');
Route::get('customers/edit/data/{id}','Admin\CustomerController@detailView')->name('customer.edit.data');
Route::GET('customers/detail/show/{id}','Admin\CustomerController@detailShow')->name('customer.detail.show');
Route::get('/export_xlsx', 'Admin\CustomerController@exportXlsx')->name('export.xlsx');



// notification Types
Route::get('notifications/list','Admin\NotificationController@index')->name('notification.list');
Route::get('notifications/create','Admin\NotificationController@create')->name('notification.create');
Route::get('notifications/edit/{id}','Admin\NotificationController@edit')->name('notification.edit');
Route::post('notifications/delete/{id}','Admin\NotificationController@delete')->name('notification.delete');


Route::post('notifications/submit','Admin\NotificationController@submit')->name('notification.submit');
Route::post('notifications/update','Admin\NotificationController@update')->name('notification.update');
Route::post('notifications/list/data','Admin\NotificationController@getNotiList')->name('getNotiList');
Route::get('notifications/getListUser','Admin\NotificationController@getListUser')->name('getListUser');
Route::get('notifications/getSearchUser','Admin\NotificationController@getSearchUser')->name('getSearchUser');
Route::post('notifications/status_change/{id}','Admin\NotificationController@change_status')->name('notification.status_change');


//truck types
Route::get('truck_types/list','Admin\TruckTypeController@index')->name('truck_type.list');
Route::post('truck_types/list/show','Admin\TruckTypeController@getTruckTypeList')->name('getTruckTypeList');
Route::get('truck_types/create','Admin\TruckTypeController@create')->name('truck_type.create');
Route::get('truck_types/edit/{id}','Admin\TruckTypeController@create')->name('truck_type.edit');
Route::post('truck_types/submit','Admin\TruckTypeController@submit')->name('truck_type.submit');
Route::post('truck_types/delete/{id}','Admin\TruckTypeController@delete')->name('truck_type.delete');
Route::post('truck_types/status_change/{id}','Admin\TruckTypeController@change_status')->name('truck_type.status_change');
Route::get('truck_types/sort','Admin\TruckTypeController@sort')->name('truck_type.sort');
Route::post('truck_types/savesort','Admin\TruckTypeController@savesort')->name('truck_type.savesort');

// map
Route::get('/map','MapController@showMap')->name('showMap');


// deligates
Route::get("deligates", "Admin\DeligateController@index")->name('deligates.list');
Route::post("deligates/getdeligateList", "Admin\DeligateController@getdeligateList")->name('getdeligateList');
Route::get("deligate/create", "Admin\DeligateController@create")->name('deligates.create');
Route::post("deligates/change_status", "Admin\DeligateController@change_status")->name('deligates.change_status');
Route::get("deligates/edit/{id}", "Admin\DeligateController@edit")->name('deligates.edit');
Route::get("deligates/delete/{id}", "Admin\DeligateController@destroy")->name('deligates.destroy');
Route::post("save_deligate", "Admin\DeligateController@store")->name('deligates.store');

// type of storages
Route::get("storage_types", "Admin\StorageTypeController@index")->name('storage_types.list');
Route::post("storage_types/getstorageList", "Admin\StorageTypeController@getstorageList")->name('getstorageList');
Route::get("storage_types/create", "Admin\StorageTypeController@create")->name('storage_types.create');
Route::post("storage_types/change_status", "Admin\StorageTypeController@change_status")->name('storage_types.change_status');
Route::get("storage_types/edit/{id}", "Admin\StorageTypeController@edit")->name('storage_types.edit');
Route::get("storage_types/delete/{id}", "Admin\StorageTypeController@destroy")->name('storage_types.destroy');
Route::post("save_storage", "Admin\StorageTypeController@store")->name('storage_types.store');


// reviews
Route::get('reviews/list','Admin\ReviewsController@index')->name('reviews.list');
// Route::get('reviews/create','Admin\ReviewsController@create')->name('reviews.create');
Route::get('reviews/edit/{id}','Admin\ReviewsController@edit')->name('reviews.edit');
// Route::post('company/submit','Admin\ReviewsController@submit')->name('company.submit');
Route::post('reviews/delete/{id}','Admin\ReviewsController@delete')->name('reviews.delete');
Route::post('reviews/list','Admin\ReviewsController@getReviewList')->name('getReviewList');
Route::post('reviews/status_change/{id}','Admin\ReviewsController@change_status')->name('reviews.status_change');
Route::post('reviews/update','Admin\ReviewsController@update')->name('reviews.update');
// 


// wallet Types
Route::get('wallet/list','Admin\WalletController@index')->name('wallet.list');
Route::post('wallet/list','Admin\WalletController@getwalletList')->name('getwalletList');
Route::get('wallet/edit/{id}','Admin\WalletController@edit')->name('wallet.edit');
Route::post('wallet/update','Admin\WalletController@update')->name('wallet.update');
Route::get('wallet/add/{id}','Admin\WalletController@add')->name('wallet.add');
Route::post('wallet/update/amt','Admin\WalletController@updateamt')->name('wallet.add.amt');


// BlackLists

//Users
Route::get("blacklists", "Admin\BlackListController@index")->name('blacklists.list');
Route::post("blacklists/getblackList", "Admin\BlackListController@getblackList")->name('getblackList');
Route::get("blacklists/add/{id}", "Admin\BlackListController@add")->name('blacklists.add');
Route::get("blacklists/remove/{id}", "Admin\BlackListController@remove")->name('blacklists.remove');
Route::post("blacklists/remove_all", "Admin\BlackListController@remove_all")->name('remove.all.blacklists');
Route::post("blacklists/add_all", "Admin\BlackListController@add_all")->name('add.all.blacklists');

//Devices
Route::get("blacklists/devices", "Admin\BlackListController@device_index")->name('blacklists.devices');
Route::post("blacklists/getblackListDevices", "Admin\BlackListController@getblackListDevices")->name('getblackListDevices');
Route::post("blacklists/add_all_devices", "Admin\BlackListController@add_all_devices")->name('add.all.devices.blacklists');
Route::get("blacklists/remove_device/{id}", "Admin\BlackListController@remove_device")->name('blacklists.remove.device');
Route::post("blacklists/remove_all_devices", "Admin\BlackListController@remove_all_devices")->name('remove.all.devices.blacklists');


// shipping_methods
Route::get("shipping_methods", "Admin\ShippingMethodController@index")->name('shipping_methods.list');
Route::post("shipping_methods/getshipping_methodsList", "Admin\ShippingMethodController@getshipping_methodsList")->name('getshipping_methodsList');
Route::get("shipping_methods/create", "Admin\ShippingMethodController@create")->name('shipping_methods.create');
Route::post("shipping_methods/change_status", "Admin\ShippingMethodController@change_status")->name('shipping_methods.change_status');
Route::get("shipping_methods/edit/{id}", "Admin\ShippingMethodController@edit")->name('shipping_methods.edit');
Route::get("shipping_methods/delete/{id}", "Admin\ShippingMethodController@destroy")->name('shipping_methods.destroy');
Route::post("save_shipping_methods", "Admin\ShippingMethodController@store")->name('shipping_methods.store');

// Containers
Route::get("containers", "Admin\ContainerController@index")->name('containers.list');
Route::post("containers/getcontainersList", "Admin\ContainerController@getcontainersList")->name('getcontainersList');
Route::get("containers/create", "Admin\ContainerController@create")->name('containers.create');
Route::post("containers/change_status", "Admin\ContainerController@change_status")->name('containers.change_status');
Route::get("containers/edit/{id}", "Admin\ContainerController@create")->name('containers.edit');
Route::get("containers/delete/{id}", "Admin\ContainerController@destroy")->name('containers.destroy');
Route::post("save_containers", "Admin\ContainerController@store")->name('containers.store');


