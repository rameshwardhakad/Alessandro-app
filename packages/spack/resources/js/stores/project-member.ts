import { computed, ref, toRaw } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { axios } from 'spack'
import { useProjectDetailStore } from './project-detail'
import { useModalsStore } from 'spack'

export const useProjectMemberStore = defineStore('project-member', () => {
  const fetching = ref<boolean>(false)
  const submitting = ref<boolean>(false)
  const users = ref<User[]>([])
  const selected = ref<User[]>([])
  const search = ref('')

  const filteredSelected = computed(() => {
    return selected.value.filter(item => {
      console.log('item')
      console.log(item)
      console.log(search.value)
      return item.name.toLowerCase().includes(search.value.toLowerCase()) || item.email.toLowerCase().includes(search.value.toLowerCase())
    })
  })

  const filteredUsers = computed(() => {
    return users.value.filter(item => {
      console.log('item')
      console.log(item)
      console.log(search.value)
      return item.name.toLowerCase().includes(search.value.toLowerCase()) || item.email.toLowerCase().includes(search.value.toLowerCase())
    })
  })

  function reset() {
    users.value = []
    selected.value = []
    search.value = ''
  }

  async function fetch() {
    reset()

    fetching.value = true

    const { data } = await axios.get(`users/all`)

    users.value = data
    fetching.value = false

//     console.log('useProjectDetailStore().project.users')
//     console.log(useProjectDetailStore().project.users)
//     console.log(toRaw(useProjectDetailStore().project.users))
//     selected.value = toRaw(useProjectDetailStore().project.users)
//     console.log('selected.value')
//     console.log(selected.value)
//     selected.value.push({id: 5, name: 'test', email: 'ae@dd', avatar: 'https://i.pravatar.cc/150?u=a042581f4e29026704d'})
// console.log('now')
// console.log(useProjectDetailStore().project.users)
    setOptions(data)
  }

  function setOptions(allUsers: User[]) {
    console.log('setOptions')
    console.log(allUsers)
    selected.value.push(...toRaw(useProjectDetailStore().project.users))

    const selectedIds = new Set(selected.value.map((item) => item.id))
    console.log('selectedIds', selectedIds)
    const usersNotSelected = allUsers.filter((user) => !selectedIds.has(user.id))
    console.log('usersNotSelected')
    console.log(usersNotSelected)
    users.value = usersNotSelected
    return
  }

  function select(option: User, index: number) {
    selected.value.push(option)
    users.value.splice(index, 1)
  }

  function deselect(option: User, index: number) {
    users.value.push(option)
    selected.value.splice(index, 1)
  }

  async function submit() {
    submitting.value = true

    const { data } = await axios.patch(`projects/${useProjectDetailStore().project.id}/users`, {
      users: selected.value.map((item) => item.id),
    })

    console.log('data')
    console.log(data)
    useProjectDetailStore().project.users = data
    submitting.value = false
    useModalsStore().pop()
  }

  function selectAll() {
    selected.value.push(...users.value)
    users.value = []
  }

  function deselectAll() {
    users.value.push(...selected.value)
    selected.value = []
  }

  return {
    selectAll,
    deselectAll,
    select,
    deselect,
    fetching,
    fetch,
    users,
    selected,
    submit,
    submitting,
    search,
    filteredSelected,
    filteredUsers,
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useProjectMemberStore, import.meta.hot))
}
