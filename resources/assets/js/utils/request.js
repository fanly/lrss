import axios from 'axios'
import { Message, MessageBox } from 'element-ui'
import store from '../store'
import { getToken } from './auth'

// create an axios instance
const service = axios.create({
    baseURL: process.env.BASE_API, // api 的 base_url
    timeout: 5000, // request timeout
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
})

// request interceptor
service.interceptors.request.use(config => {
    // Do something before request is sent
    if (store.getters.token) {
        config.headers['Authorization'] = 'bearer ' + getToken()
    }
    return config
}, error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
})

// // respone interceptor
service.interceptors.response.use(
    response => {
        const res = response.data;
        if (res.meta.code === 401) {
            MessageBox.confirm('你已被登出，可以取消继续留在该页面，或者重新登录', '确定登出', {
                confirmButtonText: '重新登录',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
              store.dispatch('FedLogOut').then(() => {
              });
            })
            return Promise.reject(401)
        } else if (res.meta.code !== 200) {
            Message({
                message: res.meta.message,
                type: 'error',
                duration: 5 * 1000
            });
            return Promise.reject('error');
        } else {
            return res.data;
        }
    },
    error => {
        console.log('err' + error)// for debug
        Message({
            message: error.message,
            type: 'error',
            duration: 5 * 1000
        })
        return Promise.reject(error)
    })

export default service