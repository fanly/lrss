import request from '../utils/request'

export function loginByEmail(email, password) {
  const data = {
    email,
    password
  }
  return request({
    url: '/api/login',
    method: 'post',
    data
  })
}

export function logout() {
  return request({
    url: '/login/logout',
    method: 'post'
  })
}

export function getUserInfo() {
  return request({
    url: '/api/user',
    method: 'get'
  })
}

