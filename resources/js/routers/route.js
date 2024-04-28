import Dashboard from '../components/Dashboard/Dashboard.vue';
import Profile from '../components/Profile.vue';
import Badges from '../components/Admin/Badge/Badge.vue';
import Point from '../components/Admin/Point/Point.vue';
import User from '../components/Admin/User/User.vue';
import BadgeRoles from "../components/BadgeRoles";

import BadgeForm from "../components/Admin/Badge/BadgeForm";
import PointBadgeForm from "../components/Admin/Point/PointBadgeForm";
import UserForm from '../components/Admin/User/UserForm.vue';

import exportApi from "../api/export";

export default [
    {path: '/', component: Dashboard, name: 'home'},
    {path: '/badge-roles', component: BadgeRoles, name:'roles'},
    {path: '/dashboard', component: Dashboard, name: 'dashboard'},
    {path: '/profile', component: Profile, name: 'profile'},
    {
        path: '/logout', component: {
            beforeRouteEnter(to, from, next) {
                window.location.href = '/auth/logout';
            }
        }, name: 'logout'
    },
    {
        path: '/strava-connect', component: {
            beforeRouteEnter(to, from, next) {
                // this.$store.commit('user/setAuthenticated', false);
                // this.$store.commit('user/setUser', {});
                window.location.href = '/strava-redirect';
            }
        }, name: 'strava-app-connect'
    },
    {
        path: '/strava-profile', component: {
            beforeRouteEnter(to, from, next) {
                const athlete_id = to.params.athlete_id !== undefined ? to.params.athlete_id : null;
                window.open('https://www.strava.com/athletes/' + athlete_id);
            }
        }, name: 'stravaProfile',
        props: true
    },

    {path: '/admin/points', component: PointBadgeForm, name: 'pointBadgeFormNew'},
    {path: '/admin/points/list', component: Point, name: 'points'},
    {path: '/admin/points/:id(\\d+)', component: PointBadgeForm, name: 'pointBadgeForm', props: true},

    {path: '/admin/badges', component: BadgeForm, name: 'badgesFormNew'},
    {path: '/admin/badges/list', component: Badges, name: 'badges'},
    {path: '/admin/badges/:id(\\d+)', component: BadgeForm, name: 'badgesForm', props: true},

    {path: '/admin/users', component: UserForm, name: 'userFormNew'},
    {path: '/admin/users/list', component: User, name: 'users'},
    {path: '/admin/users/:id(\\d+)', component: UserForm, name: 'userForm', props: true},

    {path: '/admin/export-badges',
        component: {
            beforeRouteEnter(to, from, next) {
                exportApi.badges('badges.csv');
            }
        }, name: "export-badges", props: false}
]