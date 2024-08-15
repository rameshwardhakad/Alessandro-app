import {
  AcademicCapIcon,
  BanknotesIcon,
  Cog6ToothIcon,
  HomeIcon,
  UsersIcon,
} from '@heroicons/vue/24/outline'

export const useSidebarNav: SidebarNav[] = [
  { label: 'Dashboard', uri: '/', icon: HomeIcon },
  { label: 'Customers', uri: '/customers', icon: UsersIcon },
  { label: 'Subscriptions', uri: '/subscriptions', icon: BanknotesIcon },
  { label: 'Plans', uri: '/plans', icon: AcademicCapIcon },
  { label: 'Settings', uri: '/settings/general', icon: Cog6ToothIcon },
]
