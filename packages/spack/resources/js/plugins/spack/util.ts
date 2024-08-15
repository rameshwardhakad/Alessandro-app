import { appData } from '@/app-data'

/**
 * Check if object is empty.
 */
export function isObjectEmpty(obj: Record<string, any>): boolean {
  return Object.keys(obj).length === 0
}

/**
 * Generates a temporary ID by combining the user ID and the current timestamp.
 */
export function generateTempId(): number {
  return parseInt(`${appData.user.id}${new Date().getTime()}`)
}

/**
 * Checks if the user has the specified permission.
 */
export function can(permission: string): boolean {
  if (appData.is_super_admin) return true

  return appData.permissions.includes(permission)
}

/**
 * Checks if the user does not have the specified permission.
 */
export function cannot(permission: string): boolean {
  return !can(permission)
}
