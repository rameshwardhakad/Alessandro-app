import {
  ComputedRef,
  Ref,
  ToRef,
  isReactive,
  isRef,
  toRaw,
  toRef,
} from 'vue'
import { StoreGetters, StoreState } from 'pinia'
import type { PiniaCustomStateProperties, StoreGeneric } from 'pinia'

// Type to filter out keys that start with "$" or "_".
type FilteredKeys<T> = {
  [K in keyof T]: K extends `$${string}` | `_${string}` ? never : K
}[keyof T]

type ToComputedRefs<T> = {
  [K in keyof T]: ToRef<T[K]> extends Ref<infer U>
    ? ComputedRef<U>
    : ToRef<T[K]>
}

export type StoreWithRefs<SS extends StoreGeneric> = {
  [K in FilteredKeys<SS>]:
    // If the property is a function, keep its type
    SS[K] extends (...args: any[]) => any ? SS[K] :

    // If the key belongs to the combined store state and custom state properties, convert to Ref
    K extends keyof (StoreState<SS> & PiniaCustomStateProperties<StoreState<SS>>) ? Ref<SS[K]> :

    // If the key belongs to getters, derive type from ToComputedRefs
    K extends keyof StoreGetters<SS> ? ToComputedRefs<StoreGetters<SS>>[K] :

    // Otherwise, keep the original type
    SS[K]
}

export function storeWithRefs<SS extends StoreGeneric>(
  store: SS
): StoreWithRefs<SS> {
  store = toRaw(store)

  const refs = {} as StoreWithRefs<SS>
  for (const key in store) {
    // Skip keys starting with "$" or "_".
    if (key.startsWith('$') || key.startsWith('_')) continue

    const value = store[key]
    if (isRef(value) || isReactive(value)) {
      // @ts-expect-error: the key is state or getter
      refs[key] =
        // ---
        toRef(store, key)
    } else {
      // @ts-expect-error: the key is state or getter
      refs[key] =
        // ---
        value
    }
  }

  return refs
}
