// @ts-nocheck
import { computed, ref } from 'vue'
import debounce from 'lodash/debounce'
import { defineStore } from 'pinia'
import { axios, createEventHook, useConfirmStore } from 'spack'

interface InitPayload {
  uri: string
  filterUri?: string
  searchColumn?: string
  orderByDirection?: string
  filters?: boolean
}

export const useIndexStore = function (name: string) {
  return defineStore(`index-${name}`, () => {
    const items = ref([])
    const fetching = ref<string | boolean>(false)
    const initialFetching = ref<boolean>(false)
    const uri = ref<string>('')
    const shallowUri = ref<string>('')
    const filterUri = ref<string>('')
    const appliedFilters = ref([])
    const selected = ref<number[]>([])
    const filters = ref([])
    const params = ref<any>({
      page: 1,
      search: null,
      searchColumn: 'name',
      searchNumericColumn: 'id',
      orderBy: 'id',
      orderByDirection: 'desc',
    })
    const pagination = ref<any>({})
    const successHook = createEventHook<any>()

    const allItemsSelected = computed(() => selected.value.length === items.value.length)

    async function init(payload: InitPayload) {
      console.log('hit init')

      initialFetching.value = true
      config(payload)

      try {
        const [fetchResponse, fetchFiltersResponse] = await Promise.all([
          axios.get(uri.value, { params: params.value }),
          axios.get((filterUri.value || uri.value) + '/filters'),
        ])
        console.log('Both requests completed successfully.')
        console.log('fetchResponse', fetchResponse)
        console.log('fetchFiltersResponse', fetchFiltersResponse)
        filters.value = fetchFiltersResponse.data

        for (let i = 0; i < fetchFiltersResponse.data.length; i++) {
          params.value[fetchFiltersResponse.data[i].attribute] = ''
        }

        items.value = fetchResponse.data.data
        Object.assign(pagination.value, {
          current_page: fetchResponse.data.current_page,
          from: fetchResponse.data.from,
          next_page_url: fetchResponse.data.next_page_url,
          per_page: fetchResponse.data.per_page,
          prev_page_url: fetchResponse.data.prev_page_url,
          to: fetchResponse.data.to,
        })
      } catch (error) {
        console.error('Error in one or both requests:', error)
      } finally {
        initialFetching.value = false
      }
    }

    function config(payload: InitPayload) {
      uri.value = payload.uri
      params.value['searchColumn'] = payload.searchColumn
      console.log('payload', payload)
    }

    function fetch(type: string = 'initial') {
      fetching.value = type

      axios
        .get(uri.value, {
          params: params.value,
        })
        .then(({ data }) => {
          console.log('data')
          console.log(data)
          items.value = data.data
          Object.assign(pagination.value, {
            current_page: data.current_page,
            from: data.from,
            next_page_url: data.next_page_url,
            per_page: data.per_page,
            prev_page_url: data.prev_page_url,
            to: data.to,
          })
          fetching.value = false
        })
    }

    function fetchFilters() {
      axios.get((filterUri.value || uri.value) + '/filters').then(({ data }) => {
        filters.value = data

        for (let i = 0; i < data.length; i++) {
          params.value[data[i].attribute] = ''
        }
      })
    }

    function next() {
      if (pagination.value.next_page_url) {
        params.value.page++
        fetch('next')
      }
    }

    function prev() {
      if (pagination.value.prev_page_url) {
        params.value.page--
        fetch('prev')
      }
    }

    function setAppliedFilter({ attribute, component, value }) {
      const param = params.value[attribute].toString()

      if (param != value.toString() || component == 'date-filter') {
        if (appliedFilters.value.indexOf(attribute) === -1) appliedFilters.value.push(attribute)
      } else {
        const index = appliedFilters.value.indexOf(attribute)
        appliedFilters.value.splice(index, 1)
      }
    }

    function resetFilters() {
      for (let i = 0; i < filters.value.length; i++) {
        const filter = filters.value[i]

        params.value[filter.attribute] = filter.value
      }

      appliedFilters.value = []

      fetch('filter')
    }

    function deleteIt(id: number, index: number) {
      const confirm = useConfirmStore()

      confirm.confirm({
        title: 'Delete Resource',
        description: 'Are you sure you want to delete this resource?',
        button: 'Delete',
        danger: true,
        onProceed() {
          const proceedUri = shallowUri.value ? shallowUri.value : uri.value

          axios
            .delete(`${proceedUri}/null`, {
              data: { items: [id] },
            })
            .then(() => {
              confirm.hide()
              items.value.splice(index, 1)
              selected.value = []
              // fetch()
              // useFlashStore().flash(data.message)
            })
            .catch(() => {
              // useFlashStore().danger(error.response.data.message)

              confirm.hide()
            })
        },
      })
    }

    function deleteBulk() {
      const confirm = useConfirmStore()

      confirm.confirm({
        title: 'Delete Resources',
        description: 'Are you sure you want to delete these resources?',
        button: 'Delete',
        danger: true,
        onProceed() {
          const proceedUri = shallowUri.value ? shallowUri.value : uri.value
          const ids = selected.value.map((index) => items.value[index].id)

          axios
            .delete(`${proceedUri}/null`, {
              data: { items: ids },
            })
            .then(() => {
              confirm.hide()

              for (const index of selected.value) {
                items.value.splice(index, 1)
              }

              selected.value = []

              // fetch()
              // useFlashStore().flash(data.message)
            })
            .catch(() => {
              // useFlashStore().danger(error.response.data.message)

              confirm.hide()
            })
        },
      })
    }

    function select(index: number) {
      console.log('hit select')
      console.log('index', index)
      console.log('selected', selected.value)
      // if (selected.value.indexOf(index) === -1) {
      //   selected.value.push(index)
      // } else {
      //   const index = selected.value.indexOf(index)
      //   selected.value.splice(index, 1)
      // }
    }

    function selectAll() {
      console.log('hit selectAll')
      if (allItemsSelected.value) return (selected.value = [])

      console.log('select All')
      selected.value = []

      for (let i = 0; i < items.value.length; i++) {
        selected.value.push(i)
      }
    }

    function search() {
      console.log('hit search')
      fetch('search')
    }

    function sort(attribute: string) {
      if (!attribute) return

      const orderBy = params.value.orderBy
      const direction = params.value.orderByDirection

      if (orderBy == attribute && direction == 'asc') {
        params.value.orderByDirection = 'desc'
      } else if (orderBy == attribute && direction == 'desc') {
        params.value.orderBy = 'id'
        params.value.orderByDirection = 'desc'
      } else {
        params.value.orderBy = attribute
        params.value.orderByDirection = 'asc'
      }

      fetch('sort')
    }

    return {
      items,
      fetch,
      onSuccess: successHook.on,
      fetching,
      config,
      pagination,
      next,
      prev,
      appliedFilters,
      filters,
      params,
      init,
      initialFetching,
      resetFilters,
      setAppliedFilter,
      deleteIt,
      selected,
      select,
      selectAll,
      allItemsSelected,
      deleteBulk,
      search: debounce(search, 300),
      sort,
    }
  })
}
