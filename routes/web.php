<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    //Logout
	Route::get('/logout', function () {
	    Auth::logout();
	    return redirect('/');
	});
	
	//Test
	Route::get('/test', ['uses'=>'TestController@index']);
	
	//Change password
	Route::get('/changepassword','ChangepasswordController@index');
	Route::post('/changepassword','ChangepasswordController@save');
	
	//Edit Profile
	Route::get('/editprofile','EditprofileController@index');
	Route::post('/editprofile','EditprofileController@save');
	
	//Dashboard
	Route::get('/dashboard','WelcomeController@index');
	
	//Member Type - List
	Route::get('/membertype','MembertypeController@index');
	//Member Type - create
	Route::get('/membertype/add','MembertypeController@add');
	Route::post('/membertype/save','MembertypeController@save');
	//Member Type - update
	Route::get('/membertype/edit/{id}','MembertypeController@edit');
	Route::post('/membertype/update/{id}','MembertypeController@update');
	//Member Type - Delete
	Route::get('/membertype/delete/{id}','MembertypeController@delete');
	
	//Facility Type - List
	Route::get('/facilitytype','FacilitytypeController@index');
	//Facility Type - create
	Route::get('/facilitytype/add','FacilitytypeController@add');
	Route::post('/facilitytype/save','FacilitytypeController@save');
	//Facility Type - update
	Route::get('/facilitytype/edit/{id}','FacilitytypeController@edit');
	Route::post('/facilitytype/update/{id}','FacilitytypeController@update');
	//Facility Type - Delete
	Route::get('/facilitytype/delete/{id}','FacilitytypeController@delete');
	
	//Member - List
	Route::get('member', ['uses'=>'MemberController@index']);
	Route::get('member/list', ['as'=>'datatable.getMembers','uses'=>'MemberController@members']);
	// Download Excel
	Route::get('downloadMember/{type}', 'MemberController@downloadMember');
	//Member - create
	Route::get('/member/add','MemberController@add');
	Route::post('/member/save','MemberController@save');
	//Member - update
	Route::get('/member/edit/{id}','MemberController@edit');
	Route::post('/member/update/{id}','MemberController@update');
	//Member - Delete
	Route::get('/member/delete/{id}','MemberController@delete');
	
	//Accounthead - List
	Route::get('/accounthead','AccountheadController@index');
	//Accounthead - create
	Route::get('/accounthead/add','AccountheadController@add');
	Route::post('/accounthead/save','AccountheadController@save');
	//Accounthead - update
	Route::get('/accounthead/edit/{id}','AccountheadController@edit');
	Route::post('/accounthead/update/{id}','AccountheadController@update');
	//Accounthead - Delete
	Route::get('/accounthead/delete/{id}','AccountheadController@delete');
	
	//Bank - List
	Route::get('/bank','BankController@index');
	//Bank - create
	Route::get('/bank/add','BankController@add');
	Route::post('/bank/save','BankController@save');
	//Bank - update
	Route::get('/bank/edit/{id}','BankController@edit');
	Route::post('/bank/update/{id}','BankController@update');
	//Bank - Delete
	Route::get('/bank/delete/{id}','BankController@delete');
	
	//Contractor - List
	Route::get('/contractor','ContractorController@index');
	//Contractor - create
	Route::get('/contractor/add','ContractorController@add');
	Route::post('/contractor/save','ContractorController@save');
	//Contractor - update
	Route::get('/contractor/edit/{id}','ContractorController@edit');
	Route::post('/contractor/update/{id}','ContractorController@update');
	//Contractor - Delete
	Route::get('/contractor/delete/{id}','ContractorController@delete');
	
	//Facility - List
	Route::get('/facility','FacilityController@index');
	//Facility - View
	Route::get('/facility/view/{id}','FacilityController@view');
	//Facility - create
	Route::get('/facility/add','FacilityController@add');
	Route::post('/facility/save','FacilityController@save');
	//Facility - update
	Route::get('/facility/edit/{id}','FacilityController@edit');
	Route::post('/facility/update/{id}','FacilityController@update');
	//Facility - Delete
	Route::get('/facility/delete/{id}','FacilityController@delete');
	
	//Booking - List
	Route::get('/booking','BookingController@index');
	//Booking - View
	Route::get('/booking/view/{id}','BookingController@view');
	//Booking - create
	Route::get('/booking/add','BookingController@add');
	Route::post('/booking/save','BookingController@save');
	//Booking - update
	Route::get('/booking/edit/{id}','BookingController@edit');
	Route::post('/booking/update/{id}','BookingController@update');
	//Booking - Delete
	Route::get('/booking/delete/{id}','BookingController@delete');
	//Booking - Partial Cancel
	Route::get('/booking/partialedit/{id}','BookingController@partialedit');
	Route::post('/booking/partialupdate/{id}','BookingController@partialupdate');
	//Booking - Cancel
	Route::post('/booking/cancel/{id}','BookingController@cancel');
	//Booking - ChangeStatus
	Route::post('/booking/changestatus/{id}','BookingController@change_status');
	//Booking - Create Receipt
	Route::get('/booking/receipt/{id}','BookingController@create_receipt');
	//AddFacility - Ajax
	Route::get('/addfacility/ajax','BookingController@addfacility_ajax');
	Route::get('/booking/ajax-member','BookingController@member_ajax');
	
	//Receipt - List
	Route::get('/receipt','ReceiptController@index');
	//Receipt - View
	Route::get('/receipt/view/{id}','ReceiptController@view');
	//Receipt - View
	Route::get('/receipt/view-old/{id}','ReceiptController@viewOld');
	//Receipt - Cancel
	Route::get('/receipt/cancel/{id}','ReceiptController@cancel');
	
	//Receipt Booking
	Route::get('/receipt-booking','ReceiptbookingController@index');
	
	//Receipt Tentage
	Route::get('/receipt-tentage','ReceipttentageController@index');
	//Old Tentage Receipt - List
	Route::get('/receipt-tentage-old','ReceipttentageController@old');
	//Receipt Tentage - create
	Route::get('/receipt-tentage/add','ReceipttentageController@add');
	Route::post('/receipt-tentage/save','ReceipttentageController@save');
	
	//Receipt Catering
	Route::get('/receipt-catering','ReceiptcateringController@index');
	//Old catering Receipt - List
	Route::get('/receipt-catering-old','ReceiptcateringController@old');
	//Receipt catering - create
	Route::get('/receipt-catering/add','ReceiptcateringController@add');
	Route::post('/receipt-catering/save','ReceiptcateringController@save');
	
	//Receipt Rebate
	Route::get('/receipt-rebate','ReceiptrebateController@index');
	//Receipt Rebate - create
	Route::get('/receipt-rebate/add','ReceiptrebateController@add');
	Route::post('/receipt-rebate/save','ReceiptrebateController@save');
	Route::get('/receiptrebate/ajax','ReceiptrebateController@ajax');
	
	//Receipt Others
	Route::get('/receipt-others','ReceiptothersController@index');
	//Receipt Others - create
	Route::get('/receipt-others/add','ReceiptothersController@add');
	Route::post('/receipt-others/save','ReceiptothersController@save');
	
	//Rent Receipt
	Route::get('/receipt-rent','ReceiptrentController@index');
	Route::get('/receipt-rent/add','ReceiptrentController@add');
	Route::post('/receipt-rent/save','ReceiptrentController@save');
	
	//FD Receipt
	Route::get('/receipt-fd','ReceiptfdController@index');
	Route::get('/receipt-fd/add','ReceiptfdController@add');
	Route::post('/receipt-fd/save','ReceiptfdController@save');
	
	//Booking Details - Ajax
	Route::get('/receipt/ajax','ReceiptController@bookingdetails_ajax');
	
	//CGST Liability - List
	Route::get('/receipt-stl','StlController@index');
	//CGST Liability - View
	Route::get('/receipt-stl/view/{id}','StlController@view');
	//CGST Liability - create
	Route::post('/receipt-stl/save/{id}','StlController@save');
	
	//Calendar
	Route::get('/calendar','CalendarController@index');
	
	//Refundvoucher - List
	Route::get('/refund-voucher','RefundvoucherController@index');
	//Refundvoucher - create
	Route::get('/refund-voucher/add','RefundvoucherController@add');
	Route::post('/refund-voucher/save','RefundvoucherController@save');
	//Refundvoucher - View
	Route::get('/refund-voucher/view/{id}','RefundvoucherController@view');
	//Refundvoucher - partial cancel
	Route::get('/refund-voucher/partialcancel','RefundvoucherController@partialcancel');
	Route::post('/refund-voucher/partialupdate/{id}','RefundvoucherController@partialupdate');
	//Refund voucher Booking Details - Ajax
	Route::get('/refund-voucher/ajax','RefundvoucherController@bookingdetails_ajax');
	
	//Debitvoucher - List
	Route::get('/debit-voucher','DebitvoucherController@index');
	//Debitvoucher - create
	Route::get('/debit-voucher/add','DebitvoucherController@add');
	Route::post('/debit-voucher/save','DebitvoucherController@save');
	//Debitvoucher - View
	Route::get('/debit-voucher/view/{id}','DebitvoucherController@view');
	//Debitvoucher - update
	Route::get('/debit-voucher/edit/{id}','DebitvoucherController@edit');
	Route::post('/debit-voucher/update/{id}','DebitvoucherController@update');
	//Debitvoucher - Delete
	Route::get('/debit-voucher/delete/{id}','DebitvoucherController@delete');
	
	//CGST Register
	Route::get('/servicetax-register','StrController@index');
	Route::post('/servicetax-register','StrController@search');
	//Member List Report
	Route::get('/memberlist-report','MemberlistreportController@index');
	Route::post('/memberlist-report','MemberlistreportController@search');
	//Security Amount Register
	Route::get('/securityamount-register','SecurityamountregisterController@index');
	Route::post('/securityamount-register','SecurityamountregisterController@search');
	//Booking Register
	Route::get('/booking-register','BookingregisterController@index');
	Route::post('/booking-register','BookingregisterController@search');
	//Booking Details Report
	Route::get('/booking-details','BookingdetailsController@index');
	Route::post('/booking-details','BookingdetailsController@search');
	//Booking Cancellation Report
	Route::get('/booking-cancellation','BookingcancellationController@index');
	Route::post('/booking-cancellation','BookingcancellationController@search');
	//Vat Register
	Route::get('/vat-register','VatregisterController@index');
	Route::post('/vat-register','VatregisterController@search');
	//Rebate Register
	Route::get('/rebate-register','RebateregisterController@index');
	Route::post('/rebate-register','RebateregisterController@search');
	//Tentage Register
	Route::get('/tentage-register','TentageregisterController@index');
	Route::post('/tentage-register','TentageregisterController@search');
	//Catering Register
	Route::get('/catering-register','CateringregisterController@index');
	Route::post('/catering-register','CateringregisterController@search');
	//TDS Register
	Route::get('/tds-register','TDSregisterController@index');
	Route::post('/tds-register','TDSregisterController@search');
	//Party Bill Printing
	Route::get('/party-bill','PartybillController@index');
	Route::post('/party-bill','PartybillController@search');
	//Ledger Report
	Route::get('/ledger-report','LedgerreportController@index');
	Route::post('/ledger-report','LedgerreportController@search');
	
});

Route::get('/', function () {
	if(Auth::check()){
		// return view('welcome');
		 return redirect()->action('WelcomeController@index');
	}
	else{
		// return view('login');
		return redirect()->action('LoginController@index');
	}
});

//Login
Route::get('/login','LoginController@index');
Route::post('/login','LoginController@login');
