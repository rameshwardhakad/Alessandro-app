import { ref } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { appData } from '@/app-data'

export const useSidebarProjectStore = defineStore('sidebar-project', () => {
  const items = ref<SidebarProject[]>(appData.sidebar_projects)

  function updateColor(projectId: number, color: string) {
    const project = items.value.find((project) => project.id === projectId)

    if (project) {
      project.meta.color = color
    }
  }

  function updateName(projectId: number, name: string) {
    const project = items.value.find((project) => project.id === projectId)

    if (project) {
      project.name = name
    }
  }

  function addItem(item: any) {
    console.log('item')
    console.log(item)
    items.value.push(item)
  }

  return {
    items,
    updateColor,
    updateName,
    addItem,
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useSidebarProjectStore, import.meta.hot))
}
