import axios from 'axios'
import { Message } from 'element-ui'
// import store from '@/store'
// import { getToken } from '@/utils/auth'

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
    // if (store.getters.token) {
    //     config.headers['X-Token'] = getToken() // 让每个请求携带token-- ['X-Token']为自定义key 请根据实际情况自行修改
    // }
    return config
}, error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
})

// // respone interceptor
// service.interceptors.response.use(
//     response => {
//         // const res = response.data;
//         // if (res.code !== 200) {
//         //     Message({
//         //         message: res.message,
//         //         type: 'error',
//         //         duration: 5 * 1000
//         //     });
//         //     // 508:非法的token; 512:其他客户端登录了;  514:Token 过期了;
//         //     // if (res.code === 508 || res.code === 512 || res.code === 514) {
//         //     //     MessageBox.confirm('你已被登出，可以取消继续留在该页面，或者重新登录', '确定登出', {
//         //     //         confirmButtonText: '重新登录',
//         //     //         cancelButtonText: '取消',
//         //     //         type: 'warning'
//         //     //     }).then(() => {
//         //     //         store.dispatch('FedLogOut').then(() => {
//         //     //             location.reload();// 为了重新实例化vue-router对象 避免bug
//         //     //         });
//         //     //     })
//         //     // }
//         //     return Promise.reject('error');
//         // } else {
//         //     return response.data;
//         // }
//     },
//     error => {
//         console.log('err' + error)// for debug
//         Message({
//             message: error.message,
//             type: 'error',
//             duration: 5 * 1000
//         })
//         return Promise.reject(error)
//     })

export default service