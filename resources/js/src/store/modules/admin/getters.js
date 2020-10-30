

const getters = {
    getAllFloors(state) {
        return state.floors
    },
    getSingleFloor(state) {
        return state.floor
    },
    getAllRoomTypes(state) {
        return state.room_types
    },
    getAllRooms(state) {
        return state.rooms
    },
    getAllPaidServices(state) {
        return state.paid_services
    },
    getAllReservations(state) {
        return state.reservations
    },
    getAllAvailableRoomTypes(state) {
        return state.available_room_types
    },
    getSelectedRooms(state) {
        return state.selected_rooms
    },
    getInvoice(state) {
        return state.invoice
    },
    getSelectedPayments(state) {
        return state.selected_payments
    },
    getReservationPaidServices(state) {
        return state.reservation_paid_service
    },
    getRecentCheckins(state) {
        return state.recent_checkins;
    },
    getTodaysCheckins(state) {
        return state.todays_checkins;
    },
    getTodaysCheckouts(state) {
        return state.todays_checkouts;
    },
    getRoomTypesWithRooms(state) {
        return state.room_types_with_rooms;
    },
    getAvailableRoomsToday(state) {
        return state.available_rooms_today;
    },
    getType(state) {
        return state.type
    },
    getHouseKeepings(state) {
        return state.house_keepings
    },
    getHotelDetails(state) {
        return state.hotelDetails
    },
    getAllExpenses(state) {
        return state.expenses
    },
    getAllExpenseCategories(state) {
        return state.expense_categories
    },
    getAllGuests(state) {
        return state.guests
    },
    getAllInvoices(state) {
        return state.invoices
    },
    getReports(state) {
        return state.reports
    },
    getDashboardDetails(state) {
        return state.dashboard_details
    },
    getAllPayments(state) {
        return state.payments
    },
    getAllReservationPaidServices(state) {
        return state.all_paid_services
    },
    getAllColdDrinks(state) {
        return state.all_cold_drinks
    },

}

export default getters
