import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/home.vue'),
    props: true
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: () => import('../views/notfound.vue'),
  },
  {
    path: '/product/:slug',
    component: () => import('../views/productDetails.vue')
  },
  {
    path: '/cart',
    component: () => import('../views/cart.vue'),
    meta: { auth: true }
  },
  {
    path: '/checkout',
    name: 'checkout',
    component: () => import('../views/checkout.vue'),
    meta: { auth: true }
  },
  {
    path: '/favorite',
    name: 'favorite',
    component: () => import('../views/favorite.vue'),
    meta: { auth: true }
  },
  {
    path: '/listorder',
    name: 'listorder',
    component: () => import('../views/listorder.vue'),
    meta: { auth: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/auth/login.vue'),
    meta: { guest: true }
  },
  {
    path: '/register',
    component: () => import('../views/auth/register.vue'),
    meta: { guest: true }
  },
  {
    path: '/admin',
    component: () => import('../views/admin/default.vue'),
    redirect: '/admin/dashboard',
    meta: { auth: true },
    children: [
      {
        path: 'dashboard',
        component: () => import('../views/admin/dashboard.vue'),
      },
      {
        path: 'categories',
        name: 'ManageCategory',
        component: () => import('../views/admin/category/manage.vue'),
        props: true
      },
      {
        path: 'categories/create',
        component: () => import('../views/admin/category/create.vue')
      },
      {
        path: 'categories/:id/edit',
        component: () => import('../views/admin/category/edit.vue')
      },
      {
        path: 'products',
        name: 'ManageProduct',
        component: () => import('../views/admin/product/manage.vue'),
        props: true
      },
      {
        path: 'products/create',
        component: () => import('../views/admin/product/create.vue')
      },
      {
        path: 'products/:id/edit',
        component: () => import('../views/admin/product/edit.vue')
      },
      {
        path: 'orders',
        name: 'ManageOrder',
        component: () => import('../views/admin/order/manage.vue')
      }
    ]
  },
  
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  scrollBehavior(){
    window.scrollTo(0,0)
  }
})

router.beforeEach(async (to, from, next) => {
  const isAuth = await localStorage.getItem('token')
  if (to.matched.some(record => record.meta.auth)) {
    if (isAuth) next()
    else next({path: "/login", query: { requireAuth: true }})
  } else if (to.matched.some(record => record.meta.guest)) {
    if (!isAuth) next()
    else next({path: "/"})
  } else {
    next()
  }
})

export default router
