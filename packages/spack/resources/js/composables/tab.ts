import { type Component, type Ref, markRaw, ref } from 'vue'
import { type EventHookOn, createEventHook } from '@vueuse/core'

interface TabItem {
  component: Component
  default?: boolean
}

interface useTab {
  active: Ref<number>
  tab: Component | null
  select: (index: number) => void
  onInit: EventHookOn<number>
  onSelect: EventHookOn<number>
}

export const useTab = (items: TabItem[]): useTab => {
  const active = ref<number>(0),
    tab = ref<Component | null>(null),
    initHook = createEventHook<number>(),
    selectHook = createEventHook<number>()

  const select = (index: number): void => {
    if (index < 0 || index >= items.length || (index === active.value && tab.value !== null)) return

    active.value = index
    tab.value = markRaw(items[index].component)

    selectHook.trigger(index)
  }

  const init = (): void => {
    const index = items.findIndex((tab) => tab.default)

    select(index >= 0 ? index : 0)

    initHook.trigger(index)
  }

  init()

  return {
    active,
    select,
    tab,
    onInit: initHook.on,
    onSelect: selectHook.on,
  }
}
