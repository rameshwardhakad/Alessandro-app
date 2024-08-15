import { useProjectDetailStore } from 'Store/project-detail'
import { axios, useConfirmStore } from 'spack'

export const useListDelete = () => {
  const projectStore = useProjectDetailStore()

  function remove(id: number, index: number) {
    console.log('remove')

    useConfirmStore().confirm({
      title: 'Delete Resource',
      description: 'Are you sure you want to delete this resource?',
      button: 'Delete',
      danger: true,
      onProceed() {
        axios
          .delete(`/project-lists/${id}`)
          .then(() => {
            useConfirmStore().hide()
            console.log('then')
            projectStore.project.lists.splice(index, 1)
            // useToastStore().flash(data.message)
            // detail.data.lists.splice(props.listIndex, 1)
          })
          .catch(() => {
            // useToastStore().danger(error.response.data.message)

            useConfirmStore().hide()
          })
      },
    })
  }

  return {
    remove,
  }
}
