import { axios, createEventHook, useFlashStore } from 'spack'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useErrors } from 'Use/errors'
// import type { AxiosResponse } from 'axios'

interface FormSuccessResponse {
  model: any
  message: string
}

export const useFormStore = function <T>(name: string) {
  type FormDataResponse<K extends keyof T = keyof T> = {
    [P in K]: { name: P; value: T[P]; options: any }
  }[K]

  return defineStore(`form-${name}`, () => {
    const fetching = ref<boolean>(false),
      submitting = ref<boolean>(false),
      id = ref<number | null>(null),
      fetchUri = ref<string>(''),
      submitUri = ref<string>(''),
      data = ref<Partial<T>>({}),
      errors = ref<any>({}),
      options = ref<any>({}),
      successHook = createEventHook<FormSuccessResponse>()

    function init(uri: string, formId: number | null = null) {
      id.value = formId
      fetchUri.value = formId ? `${uri}/${formId}/edit` : `${uri}/create`
      submitUri.value = formId ? `${uri}/${formId}` : uri

      // Reset
      fetching.value = false
      submitting.value = false
      // @ts-ignore
      data.value = {}
      errors.value = {}

      fetch()
    }

    async function fetch() {
      fetching.value = true

      const { data } = await axios.get<FormDataResponse[]>(fetchUri.value)

      setFieldsData(data)
      fetching.value = false
    }

    function setFieldsData(responseData: FormDataResponse[]) {
      responseData.forEach(
        <K extends keyof T>(response: FormDataResponse<K>) => {
          const { name, options: responseOptions, value } = response

          // @ts-ignore
          data.value[name] = value
          options.value[name] = responseOptions
        },
      )
    }

    function submit() {
      const method = id.value ? 'patch' : 'post'

      submitting.value = true
      useErrors().clear()

      axios[method](submitUri.value, data.value)
        .then((response) => {
          successHook.trigger(response.data)
          // callHook('onSuccess', responseData)
          // callHook('onSuccess', response.data)
        })
        .catch((error) => {
          submitting.value = false

          if (error.response.status == 422) {
            errors.value = error.response.data.errors
          } else {
            console.log('errors!!')
            console.log(error.response.data.message)
            useErrors().error(error.response.data.message)
          }

          useFlashStore().danger(error.response.data.message)

          // callHook('onError')
        })

      // } catch (error) {
      // if (axios.isAxiosError(error)) {

      // }
      // console.log('catch error')
      // console.log(error)
      // console.log(error.response)

      // submitting.value = false

      // if (error.response.status == 422) {
      //   errors.value = error.response.data.errors
      // }

      // callHook('onError')
      // }
    }

    return {
      id,
      data,
      errors,
      fetching,
      init,
      // onError,
      onSuccess: successHook.on,
      options,
      submit,
      submitting,
    }
  })
}
