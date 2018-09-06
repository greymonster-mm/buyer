import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/GoodsList',
      name: 'GoodsList',
      component: function (resolve) {
          require(['../components/GoodsList'], resolve)
      }
    },
    {
        path: '/CategoryManagement',
        name: 'CategoryManagement',
        component: function (resolve) {
            require(['../components/CategoryManagement'], resolve)
        }
    },
    {
	    path: '/GoodsManagement',
	    name: 'GoodsManagement',
	    component: function (resolve) {
	    	require(['../components/GoodsManagement'], resolve)
	    }
    },
    
    {
        path: '/About',
        name: 'About',
        component: function (resolve) {
            require(['../components/About'], resolve)
        }
    },
    {
        path: '/Login',
        name: 'Login',
        component: function (resolve) {
            require(['../components/Login'], resolve)
        }
    },
    {
        path: '/',
        redirect: 'GoodsList',
    }
  ]
})
