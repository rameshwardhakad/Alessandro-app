import { axios } from 'spack'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import debounce from 'lodash/debounce'
import { useConfirmStore } from './confirm'

export const useIndexStore = function (name: string) {
  return defineStore(`index-${name}`, () => {
    const fetching = ref<boolean>(false),
      uri = ref<string>(''),
      filterUri = ref<string>(''),
      shallowUri = ref<string>(''),
      data = ref<any>({}),
      filters = ref<any[]>([]),
      appliedFilters = ref<any[]>([]),
      params = ref<any>({
        page: 1,
        search: null,
        searchColumn: 'name',
        searchNumericColumn: 'id',
        orderBy: 'id',
        orderByDirection: 'desc',
      })

    function setConfig(props: {
      uri: string
      filterUri?: string
      shallowUri?: string
      searchColumn?: string
      orderByDirection?: string
    }) {
      uri.value = props.uri
      filterUri.value = props.filterUri || ''
      shallowUri.value = props.shallowUri || ''
      params.value.searchColumn = props.searchColumn
      params.value.orderByDirection = props.orderByDirection
    }

    function fetch(payload: any | null = null) {
      fetching.value = payload ? payload.loading : true

      axios
        .get(uri.value, {
          params: params.value,
        })
        .then((response) => {
          fetching.value = false
          data.value = response.data
        })
    }

    function deleteIt(ids: number | number[]) {
      const confirm = useConfirmStore()

      confirm.confirm({
        title: 'Delete Resource',
        description: 'Are you sure you want to delete this resource?',
        button: 'Delete',
        danger: true,
        onProceed() {
          const items: number[] = Array.isArray(ids) ? ids : [ids]

          const proceedUri = shallowUri.value ? shallowUri.value : uri.value

          axios
            .delete(`${proceedUri}/null`, {
              data: { items },
            })
            .then(() => {
              confirm.hide()
              fetch()
              // useFlashStore().flash(data.message)
            })
            .catch(() => {
              // useFlashStore().danger(error.response.data.message)

              confirm.hide()
            })
        },
      })
    }

    function next() {
      params.value.page++
      fetch()
    }

    function prev() {
      params.value.page--
      fetch()
    }

    function updateOrCreate(model: { id: number }) {
      console.log('updateOrCreate')
      console.log(data.value.data)
      const index = data.value.data.findIndex((x: any) => x.id == model.id)

      if (index > -1) {
        data.value.data[index] = model
      } else {
        data.value.data.unshift(model)
      }
      console.log(index)
    }

    const onSearch = debounce(function () {
      fetch()
    }, 250)

    function getFilters() {
      axios.get((filterUri.value || uri.value) + '/filters').then(({ data }) => {
        filters.value = data
        for (let i = 0; i < data.length; i++) {
          params.value[data[i].attribute] = ''
        }
      })
    }

    // function setAppliedFilter({ attribute, component, value }) {
    //   const param = this.params[attribute].toString()

    //   if (param != value.toString() || component == 'date-filter') {
    //     if (this.appliedFilters.indexOf(attribute) === -1)
    //       this.appliedFilters.push(attribute)
    //   } else {
    //     const index = this.appliedFilters.indexOf(attribute)
    //     this.appliedFilters.splice(index, 1)
    //   }
    // }

    function resetFilters() {
      for (let i = 0; i < filters.value.length; i++) {
        const filter = filters.value[i]

        params.value[filter.attribute] = filter.value
      }

      appliedFilters.value = []

      fetch()
    }

    function sort(attribute: string | undefined) {
      if (!attribute) return

      const orderBy = params.value.orderBy
      const direction = params.value.orderByDirection

      if (orderBy == attribute && direction == 'asc') {
        params.value.orderByDirection = 'desc'
      } else if (orderBy == attribute && direction == 'desc') {
        // rest to default
        params.value.orderBy = 'id'
        params.value.orderByDirection = 'desc'
      } else {
        params.value.orderBy = attribute
        params.value.orderByDirection = 'asc'
      }

      fetch()
    }

    return {
      appliedFilters,
      data,
      deleteIt,
      fetch,
      fetching,
      filters,
      getFilters,
      onSearch,
      params,
      resetFilters,
      setConfig,
      sort,
      next,
      prev,
      updateOrCreate,
    }
  })
}
