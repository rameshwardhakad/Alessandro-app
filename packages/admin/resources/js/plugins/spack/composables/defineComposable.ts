const composableInstances: Record<string, any> = {}

export function defineComposable<T extends () => any>(
  key: string,
  cb: T,
): ReturnType<T> {
  if (!composableInstances[key]) {
    composableInstances[key] = cb()
  }

  return composableInstances[key] as ReturnType<T>
}
