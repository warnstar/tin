import axios from 'axios';
import { route } from '../../main';

// axios.defaults.baseURL =  "http://oo:1400";
axios.defaults.baseURL =  "https://hou-api.72ou.com";

axios.interceptors.request.use (
    config => {
        config.headers['X-Request-Token'] = localStorage.getItem("access_token");
        config.headers['Content-Type'] = 'application/json;charset=utf-8';
        return config;
    },
    err => {
        return Promise.reject(err);
    });

axios.interceptors.response.use (
    response => {
        if (response.data.status != 200) {
            switch (response.data.status) {
                case 401 :
                    route.replace({
                        path: 'login',
                        query: {redirect: route.currentRoute.fullPath}
                    });
                default :

            }
        }
        return response;
    },
    error => {
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    // 返回 401 清除token信息并跳转到登录页面
                    Message.error('无权限访问');
            }
        }
        return Promise.reject(error)   // 返回接口返回的错误信息
    });

export const baseUrl = axios.defaults.baseURL;
export const uploadUrl = baseUrl + "/admin/storage/upload";

export const login = params => { return axios.post(`/admin/account/login`, params )};

export const getHome = params => { return axios.get(`/admin/home`, { params: params }); };

export const getAdminInfo = params => { return axios.get('/admin/admin-info', { params : params})}

export const getTestIndex = params => { return axios.get('/admin/test/index', { params : params})}
export const postTestSave = params => { return axios.post(`/admin/test/save`, params )};
export const getTestDelete = params => { return axios.get(`/admin/test/delete`, {params : params })};

export const getQuestionIndex = params => { return axios.get('/admin/question/index', { params : params})}
export const getQuestionDetail = params => { return axios.get('/admin/question/detail', { params : params})}
export const postQuestionSave = params => { return axios.post(`/admin/question/save`, params )};
export const getQuestionDelete = params => { return axios.get(`/admin/question/delete`, {params : params })};

export const getDesireIndex = params => { return axios.get('/admin/desire/index', { params : params})}
export const postDesireSave = params => { return axios.post(`/admin/desire/save`, params )};
export const getDesireDelete = params => { return axios.get(`/admin/desire/delete`, {params : params })};

export const getUserIndex = params => { return axios.get('/admin/user/index', { params : params})}
