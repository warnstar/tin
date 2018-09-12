import axios from 'axios';
import { Message } from 'element-ui';

axios.defaults.baseURL =  "http://oo:1400";
// axios.defaults.baseURL =  "https://" + window.location.hostname + ":1400";

console.log(axios.defaults.baseURL);

axios.interceptors.request.use(
    config => {
        config.headers.Authorization = "Bearer " + sessionStorage.getItem('Authorization');

        return config;
    },
    err => {
        return Promise.reject(err);
    });

axios.interceptors.response.use(
    response => {
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

export const login = params => { return axios.post(`/admin/login`, params )};

export const getSetting = params => { return axios.get(`/admin/setting`, { params: params }); };
export const saveSetting = params => { return axios.post(`/admin/setting`, params )};

export const getUserListPage = params => { return axios.get(`/admin/app-release`, { params: params }); };

export const removeUser = params => { return axios.get(`/user/remove`, { params: params }); };

export const batchRemoveUser = params => { return axios.get(`/user/batchremove`, { params: params }); };

export const editUser = params => { return axios.get(`/user/edit`, { params: params }); };

export const addUser = params => { return axios.get(`/user/add`, { params: params }); };