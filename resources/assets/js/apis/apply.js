import request from '../utils/request'

export function fetchApplyList(query) {
    return request({
        url: '/api/apply',
        method: 'get',
        params: query
    })
}

export function postApply(data) {
    return request({
        url: '/api/apply',
        method: 'post',
        data: data
    })
}