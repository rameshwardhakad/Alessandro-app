import { app } from '@/app'
import { appData } from '@/app-data'

app.provide('__', translate)

app.config.globalProperties.__ = translate

function translate(word: string): string {
  const translation: string = appData.translations[word]

  if (translation) return translation

  // eslint-disable-next-line no-console
  console.warn(
    `[Translation] Not found '${word}' key in '${appData.locale}' locale translations.`,
  )

  return word
}
