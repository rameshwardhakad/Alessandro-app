import { appData } from '@/app-data'
import axiosCore from 'axios'
import type { AxiosInstance, AxiosResponse } from 'axios'
import { globalRouter } from '@/router/globalRouter'
import { useFlashStore } from 'spack'

const axios: AxiosInstance = axiosCore.create({
  baseURL: appData.prefix ? `/${appData.prefix}/api/` : '/api/',
  // baseURL: appData.prefix ? `/${appData.prefix}/api/` : '/dummy-api/',
})

axios.interceptors.response.use(
  (data: AxiosResponse) => data,
  (error) => {
    if (error.code == 'ERR_NETWORK') {
      useFlashStore().danger('User is offline.')

      return Promise.reject(error)
    }

    const { status } = error.response

    switch (status) {
      case 401:
        window.location.href = '/login'
        break

      case 403:
        globalRouter.router!.push('/403')
        break

      case 404:
        // globalRouter.router.push('/404')
        break

      case 419:
        location.reload()
        break

      case 500:
        useFlashStore().danger(error.response.data.message)
        break

      default:
    }

    return Promise.reject(error)
  },
)

export { axios }
