import Main from '../pages/Main.vue'
import Login from '../pages/Login.vue'
import Front from '../pages/Front.vue'
import Dashboard from '../pages/Admin/Dashboard.vue'
// employee 
import Employee from '../pages/Admin/Employee/index.vue'
import AddEmployee from '../pages/Admin/Employee/includes/add.vue'
import About from '../pages/Admin/About.vue'
import Chat from '../layouts/includes/chat/index.vue'
import Settings from '../pages/settings'

// event 
import Event from '../pages/Admin/Event/index.vue'

// settings 
import NavSetting from '../pages/settings/navsetting.vue'
import Items from '../pages/settings/includes/item.vue'
import Delivery from '../pages/settings/includes/delivery.vue'
import Category from '../pages/settings/includes/category.vue'

import Attendance from '../pages/Attendance.vue'

import AllItems from '../pages/Items/index.vue'

import Services from '../pages/Admin/Service/index.vue'


export default [{
    path: '/dashboard',
    component: Main,
    meta: { authOnly: true },
    children: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: { authOnly: true },
        },
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard,
            meta: { authOnly: true },
        },
        // items 

        {
            path: '/allitems',
            component: AllItems,
            meta: { authOnly: true },
            children: [
                {
                    path: '/allitems',
                    name: 'items',
                    meta: { authOnly: true },
                    component : AllItems
                },
            ]
        },
        // employee 
        {
            path: '/patient',
            name: 'attendee',
            component: Employee,
            meta: { authOnly: true },
            children : [
               
            ]
        },
        {
            path: '/attendee/add',
            name: 'attendee-add',
            component: AddEmployee,
            meta: { authOnly: true },
        },

        {
            path: '/event',
            name: 'event',
            component: Event,
            meta: { authOnly: true },
        },

        {
            path: '/about',
            name: 'about',
            component: About,
            meta: { authOnly: true },
        },
        {
            path: '/service',
            name: 'service',
            component: Services,
            meta: { authOnly: true },
        },

        {
            path: '/chat',
            name: 'chat',
            component: Chat,
            meta: { authOnly: true }
        },
        {
            path: '/setting',
            component: Settings,
            meta: { authOnly: true },
            children: [
                {
                    path: '/setting',
                    name: 'items',
                    meta: { authOnly: true },
                    component : Items
                },
                {
                    path: '/setting/item',
                    name: 'items',
                    meta: { authOnly: true },
                    component : Items
                },
                {
                    path: '/setting/delivery',
                    name: 'delivery',
                    component: Delivery,
                    meta: { authOnly: true }
                },
                {
                    path: '/setting/category',
                    name: 'category',
                    component: Category,
                    meta: { authOnly: true }
                },

            ]
        },
       


    ]
},
{
    path: '/login',
    name: 'login',
    component: Login,
    meta: { authOnly: false },
},
{
    path: '/',
    name: 'login',
    component: Login,
    meta: { authOnly: false },
},
{
    path: '/attendance',
    name: 'attendance',
    component: Attendance,
    meta: {authOnly: true}
}
]

