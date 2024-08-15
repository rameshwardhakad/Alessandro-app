import { defineStore } from 'pinia'
import { type Component, markRaw, ref } from 'vue'
import { useLocalStorage } from '@vueuse/core'

/**
 * Creates a tab store with methods to manage tabs and their selection.
 *
 * @param name - The name of the tab store.
 * @returns A Pinia store instance for managing tabs.
 */
export const useTabStore = function (name: string = 'default') {
  const items = ref<Component[]>([])
  const tab = ref<Component | null>(null)
  const current = useLocalStorage<number>(`default-tab-${name}`, -1)

  /**
   * Add tabs to the store.
   *
   * @param tabItems - An array of components representing tabs.
   * @param index - The index of the tab to select by default.
   */
  function tabs(tabItems: Component[], index: number = 0) {
    tabItems.forEach((item) => items.value.push(markRaw(item)))

    select(current.value === -1 ? index : current.value, true)
  }

  /**
   * Selects a tab by its index.
   *
   * @param index - The index of the tab to select.
   */
  function select(index: number, force: boolean = false) {
    if (!force && (current.value === index || index < 0 || index >= items.value.length)) return

    tab.value = items.value[index]
    current.value = index
  }

  return defineStore(`tab-${name}`, () => ({
    items,
    tab,
    tabs,
    select,
    current,
  }))
}
