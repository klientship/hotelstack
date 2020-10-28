import Vue from 'vue'
import Router from 'vue-router'
import store from './store/store'

Vue.use(Router)


const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [

    {
      // =============================================================================
      // MAIN LAYOUT ROUTES
      // =============================================================================
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {

          path: '/admin',
          name: 'admin',
          component: () => import('./views/pages/admin/Dashboard.vue'),
          meta: {
            requiresAuth: true
          }
        },

        {

          path: '/',
          redirect: { name: 'home' }
        },

        // {

        //   path: '/',
        //   redirect: { name: 'admin' }
        // },
        {
          path: '/admin/checkin',
          name: 'checkin',
          component: () => import('./views/pages/admin/booking/CheckIn.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/floors',
          name: 'floors',
          component: () => import('./views/pages/admin/hotel_config/Floor.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/room_types',
          name: 'room_types',
          component: () => import('./views/pages/admin/hotel_config/RoomType.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/rooms',
          name: 'rooms',
          component: () => import('./views/pages/admin/hotel_config/Room.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/paid_services',
          name: 'paid_services',
          component: () => import('./views/pages/admin/hotel_config/PaidService.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/reservations',
          name: 'reservations',
          component: () => import('./views/pages/admin/booking/Reservation.vue'),
          meta: {
            requiresAuth: true
          }
        },

        {
          path: '/admin/reservations/:id/generate_invoice',
          name: 'generate-invoice',
          component: () => import('@/views/pages/admin/booking/GenerateInvoice.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/reservations/:id/generate_paid_service_bill',
          name: 'generate-paid-service-bill',
          component: () => import('@/views/pages/admin/booking/GenerateExtraBill.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/expenses',
          name: 'expenses',
          component: () => import('@/views/pages/admin/Reports/Expenses.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/payments',
          name: 'payments',
          component: () => import('@/views/pages/admin/Reports/AllPayments.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/reservation_paid_services',
          name: 'reservation_paid_services',
          component: () => import('@/views/pages/admin/Reports/AllPaidServices.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/guests',
          name: 'guests',
          component: () => import('@/views/pages/admin/booking/Guest.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/invoices',
          name: 'invoices',
          component: () => import('@/views/pages/admin/Reports/Invoices.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/reports',
          name: 'invoices',
          component: () => import('@/views/pages/admin/Reports/Reports.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/oyo_reports',
          name: 'oyo_reports',
          component: () => import('@/views/pages/admin/Reports/OyoReports.vue'),
          meta: {
            requiresAuth: true
          }
        },
        // restaurant

        {
          path: '/admin/restaurant_pos',
          name: 'restaurant_pos',
          component: () => import('@/views/pages/admin/restaurant/Pos.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/admin/cold_drinks',
          name: 'cold_drinks',
          component: () => import('@/views/pages/admin/restaurant/ColdDrinks.vue'),
          meta: {
            requiresAuth: true
          }
        },

      ]
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
          path: '/login',
          name: 'login',
          component: () => import('@/views/pages/Login.vue')
        },



        {
          path: '/pages/error-404',
          name: 'page-error-404',
          component: () => import('@/views/pages/Error404.vue')
        },


      ]
    },

    // =============================================================================
    // FRONTEND LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/frontend/FrontLayout.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================



        {
          path: '/home',
          name: 'home',
          component: () => import('@/views/pages/front/Home.vue')
        },
        {
          path: '/about',
          name: 'about',
          component: () => import('@/views/pages/front/About.vue')
        },
        {
          path: '/rooms',
          name: 'rooms',
          component: () => import('@/views/pages/front/Rooms.vue')
        },
        {
          path: '/contact',
          name: 'contact',
          component: () => import('@/views/pages/front/Contact.vue')
        },
        {
          path: '/create_reservation',
          name: 'create_reservation',
          component: () => import('@/views/pages/front/CreateReservation.vue'),
          meta: {
            requiresAuth: true
          }
        },



      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    }
  ]
})






router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})


export default router
