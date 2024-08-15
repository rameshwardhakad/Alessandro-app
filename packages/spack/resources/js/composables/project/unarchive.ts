import { ref } from 'vue'
import { axios } from 'spack'
import { useProjectArchivedStore } from 'Store/project-archived'
import { useSidebarProjectStore } from 'Store/sidebar-project'

export const useProjectUnarchive = () => {
  const processing = ref<boolean>(false)

  async function unarchive(id: number, index: number) {
    processing.value = true

    await axios.patch(`/projects/${id}/unarchive`)

    const item = useProjectArchivedStore().items[index]
    useProjectArchivedStore().removeItem(index)
    useSidebarProjectStore().addItem(item)
  }

  return {
    unarchive,
    processing,
  }
}
