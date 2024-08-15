import { defineStore } from 'pinia'
import { markRaw, ref } from 'vue'
// import type { ConcreteComponent } from 'vue'
// import type { DefineComponent } from 'vue'
import type { Component } from 'vue'
// import { createEventHook } from '@vueuse/core'

export const useModalsStore = defineStore('modals', () => {
  const components = ref<{ component: Component; payload: any }[]>([]),
    hideHook = ref(() => {})
  // hideHook = createEventHook<any>(),

  function add(component: Component, payload: any = null) {
    payload = cleanupPayload(payload)
    // console.log('hit add')
    // console.log(payload)
    // console.log(payload.id)
    // console.log(payload.id instanceof Event)

    // if (payload instanceof Event) {
    //   console.log('payload instanceof Event:')
    // }

    components.value.push({
      component: markRaw(component),
      payload,
    })
  }

  function remove(name: string) {
    // @ts-ignore
    const index = components.value.findIndex((x) => x.component.__name == name)
    components.value.splice(index)
    hideHook.value()
  }

  function pop() {
    components.value.pop()
    hideHook.value()
  }

  function onHide(cb: () => void) {
    hideHook.value = cb
  }

  function cleanupPayload(payload: any) {
    if (payload === null) return null

    const newPayload: any = {}

    for (const [key, value] of Object.entries(payload)) {
      newPayload[key] = value instanceof Event ? null : value
    }

    return newPayload
  }

  return {
    add,
    components,
    pop,
    remove,
    onHide,
    // onHide: hideHook.on,
  }
})
