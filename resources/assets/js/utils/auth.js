import Cookies from 'js-cookie'

const TokenKey = 'api_token'

export function getToken() {
  let token = Cookies.get(TokenKey)
  console.log('-----')
  console.log(token)
  console.log('-----')
  return token
}

export function setToken(token) {
  console.log(token)
  return Cookies.set(TokenKey, token)
}

export function removeToken() {
  return Cookies.remove(TokenKey)
}
