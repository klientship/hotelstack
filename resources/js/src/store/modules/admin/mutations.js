

const mutations = {
    retrieveFloors(state, floors) {
        state.floors = floors;
    },
    retrieveSingleFloor(state, floor) {
        state.floor = floor;
    },
    retrieveRoomTypes(state, room_types) {
        state.room_types = room_types;
    },
    retrieveRooms(state, rooms) {
        state.rooms = rooms;
    },
    retrievePaidServices(state, paid_services) {
        state.paid_services = paid_services;
    },
    retrieveReservations(state, reservations) {
        state.reservations = reservations;
    },

    retrieveAvailableRooms(state, available_room_types) {
        state.available_room_types = available_room_types;
    },
    deleteAvailableRooms(state) {
        state.available_room_types = [];
    },

    storeSelectedRoom(state, room) {

        room.editing = false;
        state.selected_rooms.push(room);
    },

    toggleSelectedRoomEditing(state, id) {
        state.selected_rooms.forEach((element, index) => {
            if (element.id === id) {
                state.selected_rooms[index].editing = !state.selected_rooms[index].editing;
            }
        });
    },
    editSelectedRoom(state, room) {
        state.selected_rooms.forEach((element, index) => {
            if (element.id === room.id) {
                state.selected_rooms[index].price = room.price;
            }
        });
    },

    deleteSelectedRoom(state, id) {
        var ind = state.selected_rooms.findIndex(function (element) {
            return element.id === id;
        })
        if (ind !== -1) {
            state.selected_rooms.splice(ind, 1)
        }
    },
    deleteAllSelectedRoom(state) {
        state.selected_rooms = []
    },
    // payments
    retrieveAllReservationPayments(state, payments) {
        state.selected_payments = payments;
    },
    storeSelectedPayment(state, payment) {
        state.selected_payments.push(payment);
    },

    toggleSelectedPaymentEditing(state, id) {
        state.selected_payments.forEach((element, index) => {
            if (element.id === id) {
                state.selected_Payments[index].editing = !state.selected_Payments[index].editing;
            }
        });
    },
    editSelectedPayment(state, payment) {
        state.selected_payments.forEach((element, index) => {
            if (element.id === payment.id) {
                state.selected_payments[index].price = payment.price;
            }
        });
    },

    deleteSelectedPayment(state, id) {
        var ind = state.selected_payments.findIndex(function (element) {
            return element.id === id;
        })
        if (ind !== -1) {
            state.selected_payments.splice(ind, 1)
        }
    },
    deleteAllSelectedPayment(state) {
        state.selected_payments = []
    },


    retrieveCheckIns(state, reservations) {
        state.reservations = reservations;
    },
    retrieveInvoice(state, invoice) {
        state.invoice = invoice;
    },
    retrieveReservationPaidServices(state, reservation_paid_service) {
        state.reservation_paid_service = reservation_paid_service;
    },
    deleteAllReservationPaidService(state) {
        state.reservation_paid_service = [];
    },
    selectRoomType(state, type) {
        state.type = type;
    },
    retrieveRecentCheckins(state, recent_checkins) {
        state.recent_checkins = recent_checkins;
    },
    retrieveTodaysCheckins(state, todays_checkins) {
        state.todays_checkins = todays_checkins;
    },
    retrieveTodaysCheckouts(state, todays_checkouts) {
        state.todays_checkouts = todays_checkouts;
    },
    retrieveRoomTypesWithRooms(state, room_types_with_rooms) {
        state.room_types_with_rooms = room_types_with_rooms;
    },
    retrieveAvailableRoomsToday(state, available_rooms_today) {
        state.available_rooms_today = available_rooms_today;
    },
    retrieveHouseKeepingRooms(state, house_keepings) {
        state.house_keepings = house_keepings;
    },
    RETRIEVE_ALL_EXPENSES(state, expenses) {
        state.expenses = expenses;
    },
    RETRIEVE_ALL_EXPENSE_CATEGORIES(state, expense_categories) {
        state.expense_categories = expense_categories;
    },
    RETRIEVE_GUESTS(state, guests) {
        state.guests = guests;
    },
    RETRIEVE_INVOICES(state, invoices) {
        state.invoices = invoices;
    },
    RETRIEVE_REPORTS(state, reports) {
        state.reports = reports;
    },
    RETRIEVE_DASHBOARD_DETAILS(state, dashboard_details) {
        state.dashboard_details = dashboard_details;
    },
    RETRIEVE_ALL_PAYMENTS(state, payments) {
        state.payments = payments;
    },
    RETRIEVE_ALL_RESERVATION_PAID_SERVICES(state, all_paid_services) {

        state.all_paid_services = all_paid_services;
    },
    RETRIEVE_ALL_COLD_DRINKS(state, all_cold_drinks) {
        state.all_cold_drinks = all_cold_drinks;
    },
}

export default mutations
