import { ref } from 'vue'
import { axios } from 'spack'
import { useProject } from 'Use/project'

export const useProjectArchive = () => {
  const processing = ref<boolean>(false)

  async function archive(id: number, index: number) {
    processing.value = true

    await axios.patch(`/projects/${id}/archive`)

    useProject().removeItem(index)
    useProject().removeSidebarItem(index)
  }

  return {
    archive,
    processing,
  }
}
