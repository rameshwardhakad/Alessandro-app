import { useIndexStore } from 'spack'

export function usePlanIndex() {
  function update(id: number, model: any): void {
    const indexPlan = useIndexStore('plan')()

    console.log('hit update!!')
    console.log('id', id)
    console.log('model', model)
    console.log(indexPlan.data.data)

    const index = indexPlan.data.data.findIndex((item: any) => item.id === id)

    indexPlan.data.data[index] = model
  }

  function prepend(model: any): void {
    const indexPlan = useIndexStore('plan')()

    indexPlan.data.data.unshift(model)
  }

  return {
    update,
    prepend,
  }
}
