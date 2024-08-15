import { readonly, ref } from 'vue'

interface Project {
  id: number
  name: string
  meta: {
    color: string
  }
}

interface Data {
  project: Project
}

const project = ref<Project>({} as Project)

export const useTaskProject = () => {
  function initData(data: Data) {
    project.value = data.project
  }

  return {
    project: readonly(project),
    initData,
  }
}
