import type { RouteRecordRaw } from 'vue-router'
import NotFound from 'View/errors/NotFound.vue'
import Forbidden from 'View/errors/Forbidden.vue'
import Home from 'View/Home.vue'
import Profile from 'View/Profile.vue'
import SettingsGeneral from 'View/settings/General.vue'
import SettingsEmail from 'View/settings/Email.vue'
import SettingsUpdates from 'View/settings/Updates.vue'
import SettingsRolesIndex from 'View/settings/roles/Index.vue'
import ProjectDetail from 'View/project/Index.vue'
import ProjectIndex from 'View/projects/Index.vue'
import TaskIndex from 'View/tasks/Index.vue'
import UserIndex from 'View/users/Index.vue'

export const routes: RouteRecordRaw[] = [
  { path: '/', component: Home },
  { path: '/profile', component: Profile },
  { path: '/projects', name: 'ProjectIndex', component: ProjectIndex },
  { path: '/projects/:id', name: 'ProjectDetail', component: ProjectDetail, props: true },
  { path: '/tasks', name: 'TaskIndex', component: TaskIndex },
  { path: '/users', name: 'UserIndex', component: UserIndex },
  { path: '/settings/general', component: SettingsGeneral },
  { path: '/settings/email', component: SettingsEmail },
  { path: '/settings/updates', component: SettingsUpdates },
  { path: '/settings/roles', component: SettingsRolesIndex },

  { path: '/403', name: 'Forbidden', component: Forbidden },
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
]
