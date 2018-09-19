import axios from 'axios';
import { route } from '../../main';


axios.defaults.baseURL =  "http://oo:1400";
// axios.defaults.baseURL =  "https://" + window.location.hostname + ":1400";

axios.interceptors.request.use (
    config => {
        config.headers['X-Request-Token'] = localStorage.getItem("access_token");
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

export const login = params => { return axios.post(`/admin/account/login`, params )};

export const getHome = params => { return axios.get(`/admin/home`, { params: params }); };

export const getAdminInfo = params => { return axios.get('/admin/admin-info', { params : params})}

export const getTestIndex = params => { return axios.get('/admin/test/index', { params : params})}
export const postTestSave = params => { return axios.post(`/admin/test/save`, params )};
export const getTestDelete = params => { return axios.get(`/admin/test/delete`, {params : params })};
