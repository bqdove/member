import Dashboard from '../pages/Dashboard';
import Group from '../pages/Group';
import GroupCreate from '../pages/GroupCreate';
import GroupEdit from '../pages/GroupEdit';
import Layout from '../layouts/Layout';
import Security from '../pages/Security';
import User from '../pages/User';
import UserCreate from '../pages/UserCreate';
import UserEdit from '../pages/UserEdit';

export default function (injection) {
    injection.useModuleRoute([
        {
            children: [
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Dashboard,
                    path: '/',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Group,
                    path: 'group',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: GroupCreate,
                    path: 'group/create',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: GroupEdit,
                    path: 'group/:id/edit',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Security,
                    path: 'security',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: User,
                    path: 'user',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: UserCreate,
                    path: 'user/create',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: UserEdit,
                    path: 'user/:id/edit',
                },
            ],
            component: Layout,
            path: '/member',
        },
    ]);
}