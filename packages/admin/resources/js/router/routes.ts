import type { RouteRecordRaw } from 'vue-router'
import NotFound from 'View/errors/NotFound.vue'
import Forbidden from 'View/errors/Forbidden.vue'
import Home from 'View/Home.vue'
import Profile from 'View/Profile.vue'
import CustomerIndex from 'View/customers/Index.vue'
import SubscriptionIndex from 'View/subscriptions/Index.vue'
import PlanIndex from 'View/plans/Index.vue'
import SettingsGeneral from 'View/settings/General.vue'
import SettingsEmail from 'View/settings/Email.vue'
import SettingsUpdates from 'View/settings/Updates.vue'
import SettingsStripe from 'View/settings/Stripe.vue'
import SettingsGeneralFront from 'View/settings/front/General.vue'
import SettingsSocialFront from 'View/settings/front/Social.vue'
import SettingsFeaturesIndexFront from 'View/settings/front/features/Index.vue'
import SettingsFaqIndexFront from 'View/settings/front/faq/Index.vue'
// import TicketIndex from 'View/tickets/Index.vue'
// import TicketDetail from 'View/tickets/detail/Index.vue'
// import CategoryIndex from 'View/categories/Index.vue'
// import FaqIndex from 'View/faq/Index.vue'
// import KnowledgeBaseIndex from 'View/knowledge-base/Index.vue'
// import UserIndex from 'View/users/Index.vue'

export const routes: RouteRecordRaw[] = [
  { path: '/', component: Home },
  { path: '/profile', component: Profile },
  // { path: '/categories', name: 'CategoryIndex', component: CategoryIndex },
  // { path: '/tickets/:id', name: 'TicketDetail', component: TicketDetail, props: true },
  { path: '/customers', name: 'CustomerIndex', component: CustomerIndex },
  { path: '/subscriptions', name: 'SubscriptionIndex', component: SubscriptionIndex },
  { path: '/plans', name: 'PlanIndex', component: PlanIndex },
  { path: '/settings/front/general', component: SettingsGeneralFront },
  { path: '/settings/front/features', name: 'SettingsFeaturesIndexFront', component: SettingsFeaturesIndexFront },
  { path: '/settings/front/faq', name: 'SettingsFaqIndexFront', component: SettingsFaqIndexFront },
  { path: '/settings/front/social', component: SettingsSocialFront },
  { path: '/settings/general', component: SettingsGeneral },
  { path: '/settings/email', component: SettingsEmail },
  { path: '/settings/updates', component: SettingsUpdates },
  { path: '/settings/stripe', component: SettingsStripe },

  { path: '/403', name: 'Forbidden', component: Forbidden },
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
]
