
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter);
 
export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name:"测试",
            path:'/',
            component: resolve =>void(require(['./components/Example.vue'], resolve))
        },
        {
        	name: "登录",
        	path: '/user',
        	component: resolve => void(require(['./components/user/login.vue'], resolve))
        },
        {
            name: "后台首页",
            path: '/index',
            component: resolve => void(require(['./components/home/index.vue'], resolve))
        },
        {
            name: "欢迎页",
            path: '/welcome',
            component: resolve => void(require(['./components/home/welcome.vue'], resolve))
        }
    ]
})