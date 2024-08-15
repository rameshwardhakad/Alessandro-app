import { useLocalStorage } from '@vueuse/core'
import { watch } from 'vue'
// import { axios } from './axios'

const queue = useLocalStorage<any>('queue', {})

export function useQueue() {
  watch(queue.value, () => {
    processQueue()
  })

  function processQueue() {
    console.log('hit processQueue')

    const sortedKeys = Object.keys(queue.value).sort((a: any, b: any) => a - b)

    sortedKeys.forEach((key) => {
      console.log(key, queue.value[key])
      // sendXHR(queue.value[key])
    })

    // sendXHR(queueItems[123])
  }

  // function sendXHR({ cb, config, data, method, url }) {
  //   axios
  //     .request({
  //       method,
  //       url,
  //       data,
  //       ...config,
  //     })
  //     .then((response) => {
  //       console.log(response)
  //       delete queue.value[data.temp_id]
  //       cb()
  //     })
  //     .catch((error) => {
  //       console.log(error)
  //     })
  // }

  function addToQueue(id: number, payload: any) {
    // Only update the queue if the item doesn't exist already
    if (!queue.value[id]) {
      queue.value[id] = payload
    }
  }

  return {
    processQueue,
    addToQueue,
  }
}
