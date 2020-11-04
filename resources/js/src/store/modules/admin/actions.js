
import axios from 'axios'

const actions = {
    retrieveFloors(context) {
        axios
            .get("/api/floors")
            .then(response => (context.commit('retrieveFloors', response.data.data)))
            .catch(function (error) {

            })
    },

    retrieveSingleFloor(context, floor_id) {
        axios
            .get(`/api/floors/${floor_id}`).then(response => (context.commit('retrieveSingleFloor', response.data.data)))
            .catch(function (error) {

            })
    },

    deleteFloor(context, floor_id) {
        axios
            .delete(`/api/floors/${floor_id}`);

    },

    // room types
    retrieveRoomTypes(context) {
        axios
            .get("/api/room_types")
            .then(response => (context.commit('retrieveRoomTypes', response.data.data)))
            .catch(function (error) {

            })
    },

    deleteRoomType(context, floor_id) {
        axios
            .delete(`/api/room_types/${floor_id}`);

    },

    // rooms

    retrieveRooms(context) {
        axios
            .get("/api/rooms")
            .then(response => (context.commit('retrieveRooms', response.data.data)))
            .catch(function (error) {

            })
    },

    deleteRoom(context, room_id) {
        axios
            .delete(`/api/rooms/${room_id}`);

    },

    // paid services
    retrievePaidServices(context) {
        axios
            .get("/api/paid_services")
            .then(response => (context.commit('retrievePaidServices', response.data.data)))
            .catch(function (error) {

            })
    },
    deletePaidService(context, room_id) {
        axios
            .delete(`/api/paid_services/${room_id}`);

    },
    retrieveReservations(context) {
        axios
            .get("/api/reservations")
            .then(response => (context.commit('retrieveReservations', response.data.data)))
            .catch(function (error) {

            })
    },

    retrieveAvailableRooms(context, data) {

        if (data) {
            axios
                .post("/api/available_rooms", data)
                .then(response => (context.commit('retrieveAvailableRooms', response.data.data)))
                .catch(function (error) {

                })
        }

    },
    deleteAvailableRooms(context) {
        context.commit('deleteAvailableRooms');
    },
    selectRoomType(context, type) {
        // for ac 0r non ac
        context.commit('selectRoomType', type)
    },
    deleteReservation(context, reservation_id) {
        axios
            .delete(`/api/reservations/${reservation_id}`);

    },
    storeSelectedRoom(context, room) {

        context.commit('storeSelectedRoom', room)
    },

    deleteSelectedRoom(context, id) {
        context.commit('deleteSelectedRoom', id)
    },
    deleteBookedRoom(context, id) {
        axios
            .delete(`/api/reservation_rooms/${id}`).then(res => {

            })
    },
    toggleSelectedRoomEditing(context, id) {
        context.commit('toggleSelectedRoomEditing', id)
    },
    editSelectedRoom(context, room) {
        context.commit('editSelectedRoom', room)
    },
    deleteAllSelectedRoom(context) {
        context.commit('deleteAllSelectedRoom')
    },

    // payments

    retrieveAllReservationPayments(context, id) {
        axios
            .get(`/api/reservations/${id}/payments`)
            .then(response => (context.commit('retrieveAllReservationPayments', response.data.data)))
            .catch(function (error) {

            })
    },
    storeSelectedPayment(context, payment) {
        context.commit('storeSelectedPayment', payment)
    },

    deleteSelectedPayment(context, id) {
        // context.commit('deleteSelectedPayment', id)
        axios.delete(`/api/payments/${id}`);

    },
    toggleSelectedPaymentEditing(context, id) {
        context.commit('toggleSelectedPaymentEditing', id)
    },
    editSelectedPayment(context, Payment) {
        context.commit('editSelectedPayment', payment)
    },
    deleteAllSelectedPayment(context) {
        context.commit('deleteAllSelectedPayment')
    },

    retrieveCheckIns(context) {
        axios
            .get("/api/checkins")
            .then(response => (context.commit('retrieveCheckIns', response.data.data)))
            .catch(function (error) {

            })
    },
    retrieveInvoice(context, id) {
        axios
            .get(`/api/reservations/${id}/invoice`)
            .then(response => (context.commit('retrieveInvoice', response.data.data)))
            .catch(function (error) {

            })
    },
    retrieveReservationPaidServices(context, id) {

        axios
            .get(`/api/reservations/${id}/paid_service`)
            .then(response => (context.commit('retrieveReservationPaidServices', response.data.data)))
            .catch(function (error) {

            })
    },

    CHECK_IN(context, id) {

        axios
            .patch(`/api/reservations/${id}/check_in`)
            .then()
            .catch()
    },

    CHECK_OUT(context, id) {
        axios
            .patch(`/api/reservations/${id}/check_out`)
            .then()
            .catch()
    },
    NO_SHOW(context, id) {
        axios
            .patch(`/api/reservations/${id}/no_show`)
            .then()
            .catch()
    },


    deleteReservationPaidService(context, id) {
        axios
            .delete(`/api/reservation_paid_services/${id}`)
            .then()
            .catch()
    },

    deleteAllReservationPaidService(context) {
        context.commit('deleteAllReservationPaidService')
    },

    retrieveRecentCheckins(context) {
        axios
            .get("/api/reservations/checkins/recent")
            .then(response => (context.commit('retrieveRecentCheckins', response.data.data)))
            .catch(function (error) {

            })
    },
    retrieveTodaysCheckins(context) {
        axios
            .get("/api/reservations/checkins/today")
            .then(response => (context.commit('retrieveTodaysCheckins', response.data.data)))
            .catch(function (error) {

            })
    },
    retrieveTodaysCheckouts(context) {
        axios
            .get("/api/reservations/checkouts/today")
            .then(response => (context.commit('retrieveTodaysCheckouts', response.data.data)))
            .catch(function (error) {

            })
    },
    retrieveRoomTypesWithRooms(context) {
        axios
            .get("/api/room_types/rooms/get")
            .then(response => (context.commit('retrieveRoomTypesWithRooms', response.data.data)))
            .catch(function (error) {

            })
    },
    retrieveAvailableRoomsToday(context) {
        axios
            .get("/api/rooms/booked_rooms/today")
            .then(response => (context.commit('retrieveAvailableRoomsToday', response.data)))
            .catch(function (error) {

            })
    },
    retrieveHouseKeepingRooms(context) {
        axios
            .get("/api/house_keepings")
            .then(response => (context.commit('retrieveHouseKeepingRooms', response.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_ALL_EXPENSES(context) {
        axios
            .get("/api/expenses")
            .then(response => (context.commit('RETRIEVE_ALL_EXPENSES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_ALL_EXPENSE_CATEGORIES(context) {
        axios
            .get("/api/expense_categories")
            .then(response => (context.commit('RETRIEVE_ALL_EXPENSE_CATEGORIES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_ALL_GUESTS(context) {

        axios
            .get("/api/guests")
            .then(response => (context.commit('RETRIEVE_GUESTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_MONTH_GUESTS(context) {

        axios
            .get("/api/guests/this_month/get")
            .then(response => (context.commit('RETRIEVE_GUESTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_LAST_GUESTS(context) {

        axios
            .get("/api/guests/last_month/get")
            .then(response => (context.commit('RETRIEVE_GUESTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_PRESENT_GUESTS(context) {

        axios
            .get("/api/guests/present_guests/get")
            .then(response => (context.commit('RETRIEVE_GUESTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_ALL_INVOICES(context) {
        axios
            .get("/api/invoices")
            .then(response => (context.commit('RETRIEVE_INVOICES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_MONTH_INVOICES(context) {
        axios
            .get("/api/invoices/this_month/get")
            .then(response => (context.commit('RETRIEVE_INVOICES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_LAST_MONTH_INVOICES(context) {
        axios
            .get("/api/invoices/last_month/get")
            .then(response => (context.commit('RETRIEVE_INVOICES', response.data.data)))
            .catch(function (error) {

            })
    },
    DELETE_EXPENSE(context, id) {
        axios
            .delete(`/api/expenses/${id}`)
            .then()
            .catch()
    },

    RETRIEVE_ALL_REPORTS(context) {
        axios
            .get("/api/reports")
            .then(response => (context.commit('RETRIEVE_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_MONTH_REPORTS(context) {
        axios
            .get("/api/reports/this_month/get")
            .then(response => (context.commit('RETRIEVE_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_LAST_MONTH_REPORTS(context) {
        axios
            .get("/api/reports/last_month/get")
            .then(response => (context.commit('RETRIEVE_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_PRESENT_CHECKINS(context) {
        axios
            .get("/api/reports/present_checkins")
            .then(response => (context.commit('RETRIEVE_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_DASHBOARD_DETAILS(context) {
        axios
            .get("/api/payments/todays/details")
            .then(response => (context.commit('RETRIEVE_DASHBOARD_DETAILS', response.data)))
            .catch(function (error) {

            })
    },
    // payments
    RETRIEVE_ALL_PAYMENTS(context) {
        axios
            .get("/api/payments")
            .then(response => (context.commit('RETRIEVE_ALL_PAYMENTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_MONTH_PAYMENTS(context) {
        axios
            .get("/api/payments/this_month/get")
            .then(response => (context.commit('RETRIEVE_ALL_PAYMENTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_LAST_MONTH_PAYMENTS(context) {
        axios
            .get("/api/payments/last_month/get")
            .then(response => (context.commit('RETRIEVE_ALL_PAYMENTS', response.data.data)))
            .catch(function (error) {

            })
    },

    // reservation paid servcies
    RETRIEVE_ALL_RESERVATION_PAID_SERVICES(context) {
        axios
            .get("/api/reservation_paid_services")
            .then(response => (context.commit('RETRIEVE_ALL_RESERVATION_PAID_SERVICES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_MONTH_RESERVATION_PAID_SERVICES(context) {
        axios
            .get("/api/reservation_paid_services/this_month/get")
            .then(response => (context.commit('RETRIEVE_ALL_RESERVATION_PAID_SERVICES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_LAST_MONTH_RESERVATION_PAID_SERVICES(context) {
        axios
            .get("/api/reservation_paid_services/last_month/get")
            .then(response => (context.commit('RETRIEVE_ALL_RESERVATION_PAID_SERVICES', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_ALL_COLD_DRINKS(context) {
        axios
            .get("/api/cold_drinks")
            .then(response => (context.commit('RETRIEVE_ALL_COLD_DRINKS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_RESERVATION_COLD_DRINKS(context, id) {
        axios
            .get(`/api/reservation/${id}/cold_drinks`)
            .then(response => (context.commit('RETRIEVE_RESERVATION_COLD_DRINKS', response.data.data)))
            .catch(function (error) {

            })
    },
    DELETE_COLD_DRINK(context, id) {
        axios
            .delete(`/api/cold_drinks/${id}`)
            .then()
            .catch()
    },
    RETRIEVE_INVOICE_CARD_DETAILS(context) {
        axios
            .get(`/api/invoices/card_details/get`)
            .then(response => (context.commit('RETRIEVE_INVOICE_CARD_DETAILS', response.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_ALL_OYO_REPORTS(context) {
        axios
            .get(`/api/reports/oyo_reports`)
            .then(response => (context.commit('RETRIEVE_OYO_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_THIS_MONTH_OYO_REPORTS(context) {
        axios
            .get(`/api/reports/oyo_reports/this_month`)
            .then(response => (context.commit('RETRIEVE_OYO_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_LAST_MONTH_OYO_REPORTS(context) {
        axios
            .get(`/api/reports/oyo_reports/last_month`)
            .then(response => (context.commit('RETRIEVE_OYO_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_PRESENT_CHECKED_IN_OYO_REPORTS(context) {
        axios
            .get(`/api/reports/oyo_reports/present_checkins`)
            .then(response => (context.commit('RETRIEVE_OYO_REPORTS', response.data.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_OYO_CARD_DETAILS(context) {
        axios
            .get(`/api/reports/oyo_card_details`)
            .then(response => (context.commit('RETRIEVE_OYO_CARD_DETAILS', response.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_AWAITING_CHECKOUTS(context) {
        axios
            .get(`/api/awaiting_checkout_id`)
            .then(response => (context.commit('RETRIEVE_AWAITING_CHECKOUTS', response.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_OYO_BOOKINGS_ID(context) {
        axios
            .get(`/api/oyo_checkins_id`)
            .then(response => (context.commit('RETRIEVE_OYO_BOOKINGS_ID', response.data)))
            .catch(function (error) {

            })
    },
    RETRIEVE_TOTAL_ROOMS(context) {
        axios
            .get(`/api/total_rooms`)
            .then(response => (context.commit('RETRIEVE_TOTAL_ROOMS', response.data)))
            .catch(function (error) {

            })
    },
}

export default actions
