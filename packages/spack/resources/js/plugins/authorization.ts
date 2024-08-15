import { app } from '@/app'
import { appData } from '@/app-data'

app.provide('can', can)
app.provide('cannot', cannot)

app.config.globalProperties.can = can
app.config.globalProperties.cannot = cannot

function can(permission: string): boolean {
  if (appData.is_super_admin) return true

  return appData.permissions.includes(permission)
}

function cannot(permission: string): boolean {
  if (appData.is_super_admin) return false

  return !appData.permissions.includes(permission)
}
