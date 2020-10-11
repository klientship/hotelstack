


export default [
  {
    url: '/admin',
    name: 'Dashboard',
    slug: 'dashboard-analytics',
    icon: 'HomeIcon',
    i18n: 'Analytics'
  },

  {
    header: 'Booking',
    icon: 'PackageIcon',
    i18n: 'Apps',
    items: [
      {
        url: '/admin/checkin',
        name: 'Check in',
        slug: 'check-in',
        icon: 'ArrowUpCircleIcon',
        i18n: 'check in'
      },
      {
        url: '/admin/reservations',
        name: 'Reservation',
        slug: 'chat',
        icon: 'BookmarkIcon',
        i18n: 'Chat'
      },

      {
        url: null,
        name: 'Settings',
        icon: 'SettingsIcon',
        i18n: 'Restaurant',
        submenu: [
          {
            url: '/admin/floors',
            name: 'Floors',
            slug: 'check-in',
            icon: 'LayersIcon',
            i18n: 'floors'
          },
          {
            url: '/admin/room_types',
            name: 'Room Types',
            slug: 'chat',
            icon: 'FramerIcon',
            i18n: 'Chat'
          },
          {
            url: '/admin/rooms',
            name: 'Rooms',
            slug: 'chat',
            icon: 'HomeIcon',
            i18n: 'Chat'
          },
          // {
          //   url: '/admin/paid_services',
          //   name: 'Paid Service',
          //   slug: 'paid-service',
          //   icon: 'AwardIcon',
          //   i18n: 'Chat'
          // },

        ]
      },



    ]
  },

  {
    header: 'FOOD',
    icon: 'PackageIcon',
    i18n: 'Apps',
    items: [

      {
        url: null,
        name: 'Restaurant',
        icon: 'GridIcon',
        i18n: 'Restaurant',
        submenu: [
          {
            url: '/admin/restaurant_pos',
            name: 'POS',
            slug: 'check-in',
            icon: 'LayersIcon',
            i18n: 'floors'
          },
          {
            url: '/admin/food_list',
            name: 'Food List',
            slug: 'check-in',
            icon: 'LayersIcon',
            i18n: 'floors'
          },
          {
            url: '/admin/restaurant_settings',
            name: 'Settings',
            slug: 'check-in',
            icon: 'LayersIcon',
            i18n: 'floors'
          },

          {
            url: '/admin/restaurant_reports',
            name: 'Reports',
            slug: 'check-in',
            icon: 'LayersIcon',
            i18n: 'floors'
          },
        ]
      },





    ]
  },

  {
    header: 'Summary',
    icon: 'PackageIcon',
    i18n: 'Apps',
    items: [

      {
        url: null,
        name: 'Reports',
        icon: 'LayersIcon',
        i18n: 'Restaurant',
        submenu: [
          {
            url: '/admin/guests',
            name: 'Guests',
            slug: 'guests',
            icon: 'UserIcon',
            i18n: 'Chat'
          },
          {
            url: '/admin/payments',
            name: 'Payments',
            slug: 'payments',
            icon: 'TrendingUpIcon',
            i18n: 'payments'
          },
          {
            url: '/admin/expenses',
            name: 'Expenses',
            slug: 'expenses',
            icon: 'TrendingDownIcon',
            i18n: 'expense'
          },
          {
            url: '/admin/reservation_paid_services',
            name: 'Paid Services',
            slug: 'paid-service',
            icon: 'AwardIcon',
            i18n: 'Chat'
          },
          {
            url: '/admin/invoices',
            name: 'Invoices',
            slug: 'invoice',
            icon: 'FileTextIcon',
            i18n: 'invoices'
          },
          {
            url: '/admin/reports',
            name: 'Reports',
            slug: 'reports',
            icon: 'LayersIcon',
            i18n: 'reports'
          },
        ]
      },

    ]
  },
]
