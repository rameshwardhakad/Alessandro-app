import { readonly, ref } from 'vue'

interface List {
  id: number
  name: string
}

interface Data {
  list: List
  options: SelectOption[]
}

const list = ref<List>({} as List)
const options = ref<SelectOption[]>([])

export const useTaskList = () => {
  function initData(data: Data) {
    list.value = data.list
    options.value = data.options
  }

  function updateList(data: SelectOption) {
    list.value = {
      id: data.value as number,
      name: data.label,
    }
  }

  return {
    list: readonly(list),
    options: readonly(options),
    initData,
    updateList,
  }
}
