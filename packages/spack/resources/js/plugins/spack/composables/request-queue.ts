import { useQueue } from 'spack'

const { addToQueue } = useQueue()

export function postQueue(url: string, data: any, cb?: () => void | any, config?: any) {
  addToQueue(data.temp_id, {
    method: 'post',
    url,
    data,
    config: typeof cb === 'function' ? config : cb,
    cb: typeof cb === 'function' ? cb : null,
  })
}
