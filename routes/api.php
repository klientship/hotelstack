<?php

use Illuminate\Http\Request;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response([
            'message' => ['These credentials do not match our records.']
        ], 404);
    }


    $token = $user->createToken('my-app-token')->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token
    ];

    return response($response, 201);
});


// guest
Route::apiResource("guests", 'GuestController');
Route::get("/guests/this_month/get", 'GuestController@this_month');
Route::get("/guests/present_guests/get", 'GuestController@present_guests');
Route::get("/guests/last_month/get", 'GuestController@last_month');
// floor
Route::apiResource("floors", 'FloorController');
// room types
Route::apiResource("room_types", 'RoomTypeController');
// rooms
Route::apiResource("rooms", 'RoomController');
// paid services
Route::apiResource("paid_services", 'PaidServiceController');
// reservations
Route::apiResource("reservations", 'ReservationController');
// reservations rooms
Route::apiResource("reservation_rooms", 'ReservationRoomController');
Route::get("/reservation_rooms/room/{id}/view", 'ReservationRoomController@view_room_details');
// reservations paid service
Route::apiResource("reservation_paid_services", 'ReservationPaidServiceController');
Route::get("/reservation_paid_services/this_month/get", 'ReservationPaidServiceController@this_month');
Route::get("/reservation_paid_services/last_month/get", 'ReservationPaidServiceController@last_month');
// check_ins
Route::apiResource("checkins", 'CheckInController');
// payments
Route::apiResource("payments", 'PaymentController');
Route::get("/payments/this_month/get", 'PaymentController@this_month');
Route::get("/payments/last_month/get", 'PaymentController@last_month');
// dashboard info
Route::get("/payments/todays/details", 'PaymentController@todays_details');
// invoice
Route::apiResource("invoices", 'InvoiceController');
Route::get("/invoices/this_month/get", 'InvoiceController@this_month');
Route::get("/invoices/last_month/get", 'InvoiceController@last_month');
Route::get("/invoices/card_details/get", 'InvoiceController@card_details');

// reports
Route::get("/reports", 'ReportController@index');
Route::get("/reports/this_month/get", 'ReportController@this_month');
Route::get("/reports/last_month/get", 'ReportController@last_month');
Route::get("/reports/present_checkins", 'ReportController@present_checkins');
// oyo reports
Route::get("/reports/oyo_reports", 'ReportController@oyo_bookings');
Route::get("/reports/oyo_reports/this_month", 'ReportController@this_month_oyo_bookings');
Route::get("/reports/oyo_reports/last_month", 'ReportController@last_month_oyo_bookings');
Route::get("/reports/oyo_reports/present_checkins", 'ReportController@present_checkedin_oyo_bookings');
Route::get("/reports/oyo_reports/present_checkins", 'ReportController@present_checkedin_oyo_bookings');
Route::get("/reports/oyo_card_details", 'ReportController@oyo_card_details');


// expense_categories
Route::apiResource("expense_categories", 'ExpenseCategoryController');
// expenses
Route::apiResource("expenses", 'ExpenseController');
// House keeping
Route::apiResource("house_keepings", 'HouseKeepingController');
// get available Rooms
Route::post('/available_rooms', 'RoomController@availableRooms');
// total rooms
Route::get('/total_rooms','RoomController@total_rooms');

// get invoice
Route::get('/reservations/{reservation}/invoice', 'ReservationController@getInvoice');
// check in & check out
Route::patch('/reservations/{reservation}/no_show', 'ReservationController@no_show');
Route::patch('/reservations/{reservation}/check_in', 'ReservationController@check_in');
Route::patch('/reservations/{reservation}/check_out', 'ReservationController@check_out');

// get paid services
Route::get('/reservations/{reservation}/paid_service', 'ReservationController@getPaidServices');

// get reservation payments
Route::get('/reservations/{reservation}/payments', 'ReservationController@getPayments');


// home
Route::get('/reservations/checkins/recent', 'ReservationController@recent_checkins');
Route::get('/reservations/checkins/today', 'ReservationController@todays_checkins');
Route::get('/reservations/checkouts/today', 'ReservationController@todays_checkouts');

Route::get("/room_types/rooms/get", 'RoomTypeController@room_types_with_rooms');
Route::get("/rooms/booked_rooms/today", 'RoomController@available_rooms_id');
// get awaiting checkouts
Route::get('/awaiting_checkout_id', 'RoomController@awaitingCheckoutId');
Route::get('/oyo_checkins_id', 'RoomController@oyoCheckinId');

// transaction
Route::apiResource("transactions", 'TransactionController');
Route::post("/transactions/initiate_payment", 'TransactionController@initiate');
Route::post("/transactions/verify", 'TransactionController@verify');
Route::post("/transactions/complete", 'TransactionController@Complete');

// cold drinks
Route::apiResource('/cold_drinks', 'ColdDrinkController');
Route::apiResource('/reservation_cold_drinks', 'ReservationColdDrinkController');
Route::get('/reservation/{id}/cold_drinks', 'ReservationColdDrinkController@reservation_cold_drinks');