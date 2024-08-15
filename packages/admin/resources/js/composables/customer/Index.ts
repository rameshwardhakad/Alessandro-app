import { useIndexStore } from 'spack'

export function useCustomerIndex() {
  function update(id: number, model: any): void {
    const indexCustomer = useIndexStore('customer')()

    console.log('hit update!!')
    console.log('id', id)
    console.log('model', model)
    console.log(indexCustomer.data.data)

    const index = indexCustomer.data.data.findIndex((item: any) => item.id === id)

    indexCustomer.data.data[index] = model
  }

  function prepend(model: any): void {
    const indexCustomer = useIndexStore('customer')()

    indexCustomer.data.data.unshift(model)
  }

  return {
    update,
    prepend,
  }
}
