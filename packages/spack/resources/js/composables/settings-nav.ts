interface SettingsNav {
  label: string
  uri: string
  permission?: string
}

export const useSettingsNav: SettingsNav[] = [
  { label: 'General', uri: '/settings/general', permission: 'setting:general' },
  { label: 'Email', uri: '/settings/email', permission: 'setting:email' },
  { label: 'Roles & Permissions', uri: '/settings/roles', permission: 'setting:role' },
  { label: 'Updates', uri: '/settings/updates', permission: 'setting:updates' },
]
