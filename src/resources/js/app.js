/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { createApp } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy';

import SaunaQuiz from './components/SaunaQuiz.vue';
import QuizIndex from './components/quiz/QuizIndex.vue';
import QuizComment from './components/quiz/QuizComment.vue';
import MypageTop from './components/MypageTop.vue';
import MypageEdit from './components/MypageEdit.vue';
import AdminTop from './components/Admin/AdminTop.vue';
import AdminList from './components/Admin/AdminList.vue';

const app = createApp({
    components: {
        SaunaQuiz,
        QuizIndex,
        QuizComment,
        MypageTop,
        MypageEdit,
        AdminTop,
        AdminList
    }
});

app.use(ZiggyVue, Ziggy);

app.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    },
});

app.mount('#app');
