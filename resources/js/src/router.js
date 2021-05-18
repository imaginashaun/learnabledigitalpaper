/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [

    {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/',
          name: 'home',
          component: () => import('./views/Home.vue'),
            meta: {
                rule: 'editor',
                requiresAuth: true,
                pageTitle: 'My Classes',
                creationType: 'Class',
                creationRoute: 'createclass',
            }
        },
          {
              path: '/devices',
              name: 'devices',
              component: () => import('./views/Devices.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Connected Devices',
                  //   creationType: 'Subject',
                  //     creationRoute: 'Subject',
              }
          },
          {
              path: '/subjects',
              name: 'subjects',
              component: () => import('./views/pages/Subjects.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Select a Subject',
               //   creationType: 'Subject',
             //     creationRoute: 'Subject',

              }

          },
          {
              path: '/lessons/:class_id/:new?',
              name: 'lessons',
              component: () => import('./views/pages/Lessons.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Select a Lesson',
                 // creationTypeLesson:'Lesson',
                     creationType: 'Lesson',
                       creationRoute: 'Lessons',

              }

          },
          {
              path: 'knowledgebasehome',
              name: 'knowledgebasehome',
              component: () => import('./views/pages/KnowledgeBase.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Knowledge Base',
                  // creationTypeLesson:'Lesson',
                  //     creationType: 'Lesson',
                  //   creationRoute: 'Lessons',
              }
          },
          {
              path: '/knowledgebaseitem/:categoryItem',
              name: 'knowledgebaseitem',
              component: () => import('./views/pages/KnowledgeBaseItems.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                //  pageTitle: 'Knowledge Base',
              }
          },
          {
              path: '/showresults/:learning_path_id',
              name: 'showresults',
              component: () => import('./views/pages/LessonResults.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Lesson Results',
              }

          },
          {
              path: '/detailed_lesson_results/:learning_path_id/:user_id',
              name: 'detailed_lesson_results',
              component: () => import('./views/pages/DetailedResults.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Detailed Results',
              }

          },
          {
              path: '/lesson/edit/:lesson_id',
              name: 'createlesson',
              component: () => import('./views/pages/EditLesson.vue'),
              meta: {
                  rule: 'editor',
                  requiresAuth: true,
                  pageTitle: 'Edit your lesson',
                  // creationTypeLesson:'Lesson',
             //     creationType: 'Lesson',
               //   creationRoute: 'Lessons',

              }

          },
        {
          path: '/messages',
          name: 'page-2',
          component: () => import('./views/Page2.vue'),
            meta: {
                rule: 'editor',
                requiresAuth: true,
                pageTitle: 'Messages',

            }
        }
      ]
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
          path: '/pages/login',
          name: 'page-login',
          component: () => import('@/views/pages/login/Login.vue'),
            meta: {
                rule: 'editor',
            }
        },
          {
              path: '/arview',
              name: 'arview',
              component: () => import('./views/pages/ARView.vue'),
              meta: {
                  rule: 'editor',
              }
          },
          {
              path: '/learning_path/:id/:user_id',
              name: 'learning_path',
              component: () => import('./views/pages/LearningPath.vue'),
              meta: {
                  rule: 'editor',
              }
          },
          {
              path: '/pages/register',
              name: 'page-register',
              component: () => import('@/views/pages/register/Register.vue'),
              meta: {
                  rule: 'editor'
              }
          },
        {
          path: '/pages/error-404',
          name: 'page-error-404',
          component: () => import('@/views/pages/Error404.vue')
        }
      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    }
  ]
})

router.beforeEach((to, from, next) => {
    console.log("TOKS")



    if(to.matched.some(record => record.meta.requiresAuth)) {
        console.log("TOKENA:"+localStorage.getItem('accessToken'))

        if ("accessToken" in localStorage) {
            console.log("TOKENBA:"+localStorage.getItem('accessToken'))

            next()

        } else {

            console.log("TOKENB:"+localStorage.getItem('accessToken'))

            next({
                path: '/pages/login',
                params: { nextUrl: to.fullPath }
            })
    }
    }else{
        next()
    }
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
