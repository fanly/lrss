import request from '../utils/request'

export function fetchList(query) {
    return request({
        url: '/api/rss',
        method: 'get',
        params: query
    })
}