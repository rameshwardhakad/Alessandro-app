// type PermissionCheck = (permission: string) => boolean

// type can = PermissionCheck
// type cannot = PermissionCheck

interface AppData {
  header_logo: string
  app_name: string
  app_updates: {
    checked_at: string | null
    new_version: string | null
    update_available: boolean
    version: string
  }
  csrf_token: string
  is_standalone_demo: boolean
  is_super_admin: boolean
  locale: string
  permissions: string[]
  prefix: string
  purchase_code: string | null
  pusher_app_cluster: string | null
  pusher_app_key: string | null
  translations: any
  sidebar_projects: SidebarProject[]
  user: {
    id: number
    name: string
    email: string
    avatar: string
  }
}

interface ChartYearly {
  Jan: number
  Feb: number
  Mar: number
  Apr: number
  May: number
  Jun: number
  Jul: number
  Aug: number
  Sep: number
  Oct: number
  Nov: number
  Dec: number
}

interface ChartWeekly {
  Fri: number
  Sat: number
  Sun: number
  Mon: number
  Tue: number
  Wed: number
  Thu: number
}

interface SelectOption {
  label: string
  value: string | number
}

interface SidebarNav {
  label: string
  uri: string
  icon: FunctionalComponent<HTMLAttributes & VNodeProps>
  permission?: string
  create?: string
  createPermission?: string
  activeCollapsible?: string[]
  items?: {
    label: string
    uri: string
    permission?: string
  }[]
}

interface SidebarProject {
  id: number
  name: string
  meta: {
    color: string
  }
}

// Temp
interface ProjectI {
  id: number
  name: string
  lists: any
  is_favorite: boolean
  users: any
  meta: any
}

interface ProfileForm {
  password: string
  avatar: string
}

interface ProjectForm {
  name: string
  color: string
  users: number[]
}

interface UserForm {
  name: string
  email: string
  password: string
  role: number
}

interface Task {
  id: number
  title: string
  description: string | null
}

// Task Modal
interface Checklist {
  id: number
  name: string
  order: number
  items: ChecklistItem[]
}

interface ChecklistItem {
  id: number
  temp_id?: number | null
  checklist_id: number
  name: string
  order: number
  completed_at: string | null
}

interface User {
  id: number
  name: string
  email: string
  avatar: string | null
}
