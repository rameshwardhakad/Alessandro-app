interface SettingsNav {
  label: string
  uri: string
  permission?: string
}

export const useSettingsNav: SettingsNav[] = [
  { label: 'General', uri: '/settings/general', permission: 'setting:general' },
  { label: 'Email', uri: '/settings/email', permission: 'setting:email' },
  { label: 'Stripe', uri: '/settings/stripe', permission: 'setting:stripe' },
  { label: 'Updates', uri: '/settings/updates', permission: 'setting:updates' },
]

export const useSettingsNavFront: SettingsNav[] = [
  { label: 'General', uri: '/settings/front/general', permission: 'setting:front' },
  { label: 'Features', uri: '/settings/front/features', permission: 'setting:front' },
  { label: 'FAQ', uri: '/settings/front/faq', permission: 'setting:front' },
  { label: 'Social', uri: '/settings/front/social', permission: 'setting:front' },
]
