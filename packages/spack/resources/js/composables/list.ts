import { ref } from 'vue'
import { useProjectDetailStore } from 'Store/project-detail'
import Sortable from 'sortablejs'
import { axios, cannot } from 'spack'

const isAddTaskForm = ref<number | boolean | null>(null)
const foo = ref(false)

export const useList = () => {
  const listWrapper = ref<HTMLInputElement | null>(null)

  const store = useProjectDetailStore()

  function getLists() {
    // console.log('hit getLists')
    // console.log(store.project)

    // return counterStore.items

    // console.log(project)
    // console.log(project.lists)
    // return project.lists
    return store.project.lists
  }

  function listsSortable(): void {
    if (cannot('project-list:update')) return

    Sortable.create(listWrapper.value!, {
      draggable: '.draggable-item',

      onUpdate: function (evt) {
        const id = evt.item.getAttribute('data-id')
        // same properties as onEnd
        console.log('onUpdate')
        console.log('newIndex', evt.newIndex)
        console.log('oldIndex', evt.oldIndex)
        console.log('id', evt.item.getAttribute('data-id'))

        axios.patch(`/project-lists/${id}/sort`, {
          order: (evt.newIndex as number) + 1,
          project_id: store.project.id,
        })
      },
    })
  }

  function updateListName(id: number, index: number, name: string) {
    console.log('hit updateListName')
    console.log(store.project.lists[index])
    // store.project.lists[index].name = name
    axios
      .patch(`/project-lists/${id}`, {
        name,
      })
      .then((response) => {
        console.log(response)
        store.project.lists[index].name = name
      })
  }

  function showTaskForm() {
    console.log('hit showTaskForm')
    isAddTaskForm.value = true
  }

  function updateFoo() {
    // foo.value = true
    isAddTaskForm.value = true
  }

  return {
    getLists,
    isAddTaskForm,
    listsSortable,
    listWrapper,
    showTaskForm,
    updateListName,
    foo,
    updateFoo,
  }
}
