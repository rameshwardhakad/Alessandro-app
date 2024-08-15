interface AppData {
  csrf_token: string
  prefix: string
  is_super_admin: boolean
  header_logo: string
  app_name: string
  locale: string
  translations: Record<string, string>
  permissions: string[]
  user: {
    id: number
    name: string
    email: string
    avatar: string | null
    pm_last_four: string | null
  }
  plans: Plan[]
  invoices: Invoice[]
  trial_days: number
  STRIPE_KEY: string
  client_secret: string | null
  cardLastFour: string | null
  isSubscribed: Subscription | null
  onGracePeriod: boolean
  subscribePlan: string | null
}

interface SelectOption {
  label: string
  value: string | number
}

interface Plan {
  id: number
  name: string
  meta: {
    name: string
    short_description: string
    monthly_price: number
    stripe_plan_id: string
    projects: number | null
    users: number | null
    features: string[]
  }
}

interface Invoice {
  id: number
  date: string
  total: number
}

interface Subscription {
  type: string
}
