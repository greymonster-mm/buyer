// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import router from './router'
import Frame from './components/Frame.vue'
import ElementUI from 'element-ui'
import Iview from 'iview'
import _request from './tools/request.js'

//Vue.config.productionTip = false
Vue.use(ElementUI)
Vue.use(Iview)
Vue.use(_request)


router.beforeEach((to, from, next) => {
    let access_token = JSON.parse(localStorage.getItem('access_token'));
    if (access_token) {//如果有token
        next();
    }
    else {
        if (to.path == "/login" || to.path == "/About") {
            next();
        }
        else {
            next('/login'); // 否则全部重定向到登录页
        }
    }
});

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<Frame></Frame>',
  components: { Frame }
})
