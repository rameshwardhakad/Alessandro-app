import { HomeIcon, FolderIcon, InboxIcon, UserIcon } from '@heroicons/vue/24/outline'

export const useSidebarNav: SidebarNav[] = [
  { label: 'Dashboard', uri: '/', icon: HomeIcon },
  { label: 'My Tasks', uri: '/tasks', icon: InboxIcon },
  { label: 'Projects', uri: '/projects', icon: FolderIcon },
  { label: 'Members', uri: '/users', icon: UserIcon, permission: 'user:view' },
]
