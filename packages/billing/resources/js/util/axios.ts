import { appData } from '@/app-data'
import axiosCore from 'axios'
import type { AxiosInstance, AxiosResponse } from 'axios'

const axios: AxiosInstance = axiosCore.create({
  baseURL: appData.prefix ? `/${appData.prefix}/api/` : '/api/',
})

axios.interceptors.response.use(
  (data: AxiosResponse) => data,
  (error) => {
    if (error.code == 'ERR_NETWORK') {
      console.log('User is offline.')

      return Promise.reject(error)
    }

    const { status } = error.response

    switch (status) {
      case 401:
        window.location.href = '/login'
        break

      case 403:
        console.log('/403')
        break

      case 404:
        console.log('/404')
        break

      case 419:
        location.reload()
        break

      case 500:
        console.log('/500')
        break

      default:
    }

    return Promise.reject(error)
  },
)

export { axios }
