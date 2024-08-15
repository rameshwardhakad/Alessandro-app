import { useIndexStore } from 'spack'

export function useUserIndex() {
  function update(id: number, model: any): void {
    const indexUser = useIndexStore('user')()

    console.log('hit update!!')
    console.log('id', id)
    console.log('model', model)
    console.log(indexUser.data.data)

    const index = indexUser.data.data.findIndex((user: any) => user.id === id)

    indexUser.data.data[index] = model
    // indexUser.data.data[index].name = model.name
  }

  function prepend(model: any): void {
    const indexUser = useIndexStore('user')()

    indexUser.data.data.unshift(model)
  }

  return {
    update,
    prepend,
  }
}
