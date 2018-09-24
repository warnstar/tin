import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            redirect: '/dashboard'
        },

        {
            path: '/',
            component: resolve => require(['../components/common/Home.vue'], resolve),
            meta: { title: '自述文件' },
            children:[
                {
                    path: '/dashboard',
                    component: resolve => require(['../components/page/Dashboard.vue'], resolve),
                    meta: { title: '系统首页' }
                },
                {
                    path: '/test/index',
                    component: resolve => require(['../components/page/test/Index.vue'], resolve),
                    meta: { title: '测评管理' }
                },
                {
                    path: '/test/form',
                    component: resolve => require(['../components/page/test/form.vue'], resolve),
                    meta: { title: '新增测评' }
                },
                {
                    path: '/question/index',
                    component: resolve => require(['../components/page/question/Index.vue'], resolve),
                    meta: { title: '题目管理' }
                },
                {
                    path: '/question/form',
                    component: resolve => require(['../components/page/question/form.vue'], resolve),
                    meta: { title: '题目表单' }
                },
                {
                    path: '/desire/index',
                    component: resolve => require(['../components/page/desire/index.vue'], resolve),
                    meta: { title: '答题愿望配置' }
                },
                {
                    path: '/404',
                    component: resolve => require(['../components/page/404.vue'], resolve),
                    meta: { title: '404' }
                },
                {
                    path: '/403',
                    component: resolve => require(['../components/page/403.vue'], resolve),
                    meta: { title: '403' }
                }
            ]
        },
        {
            path: '/login',
            component: resolve => require(['../components/page/Login.vue'], resolve)
        },
        {
            path: '*',
            redirect: '/404'
        }
    ]
})
