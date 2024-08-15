import { useIndexStore } from 'spack'
import { useProjectIndexStore } from 'Store/project-index'
import { useSidebarProjectStore } from 'Store/sidebar-project'

export function useProjectIndex() {
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

  function append(model: any): void {
    const store = useProjectIndexStore(),
      storeSidebar = useSidebarProjectStore()

    console.log('append!!')
    console.log('model', model)
    console.log(store)
    store.items.push(model)
    storeSidebar.items.push(model)
  }

  return {
    update,
    append,
  }
}
