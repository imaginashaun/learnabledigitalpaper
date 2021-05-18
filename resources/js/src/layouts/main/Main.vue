<!-- =========================================================================================
    File Name: Main.vue
    Description: Main layout
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="layout--main" :class="[layoutTypeClass, navbarClasses, footerClasses, {'no-scroll': isAppPage}]">

    <v-nav-menu
      :navMenuItems = "navMenuItems"
      title         = "Learnable"
      parent        = ".layout--main" />

    <div id="content-area" :class="[contentAreaClass, {'show-overlay': bodyOverlay}]">
      <div id="content-overlay" />

    <!-- Navbar -->
    <template v-if="mainLayoutType === 'horizontal' && windowWidth >= 1200">
      <the-navbar-horizontal
        :navbarType= "navbarType"
        :class="[
          {'text-white' : isNavbarDark  && !isThemeDark},
          {'text-base'  : !isNavbarDark && isThemeDark}
        ]" />

      <div style="height: 62px" v-if="navbarType === 'static'"></div>

      <h-nav-menu
        :class="[
          {'text-white' : isNavbarDark  && !isThemeDark},
          {'text-base'  : !isNavbarDark && isThemeDark}
        ]"
        :navMenuItems="navMenuItems" />
    </template>

    <template v-else>
      <the-navbar-vertical
        :navbarColor="navbarColor"
        :class="[
          {'text-white' : isNavbarDark  && !isThemeDark},
          {'text-base'  : !isNavbarDark && isThemeDark}
        ]" />
    </template>
    <!-- /Navbar -->

      <div class="content-wrapper">

        <div class="router-view">
          <div class="router-content">

            <transition :name="routerTransition">

              <div v-if="$route.meta.breadcrumb || $route.meta.pageTitle" class="router-header flex flex-wrap items-center mb-6">

                  <vs-alert color="warning" class="mb-4" title="DEMO LICENSE: LIMITED FUNCTIONALITY" closable icon-pack="feather"  :active.sync="showalert" close-icon="icon-x">
                      Deleting and editing content is limited. Please purchase the full version.
                  </vs-alert>


                <div
                  class="content-area__heading"
                  :class="{'pr-4 border-0 md:border-r border-solid border-grey-light' : $route.meta.breadcrumb}">
                  <h2 class="mb-1">{{ routeTitle }}</h2>
                </div>



                <!-- BREADCRUMB -->
                <vx-breadcrumb class="ml-4 md:block hidden" v-if="$route.meta.breadcrumb" :route="$route" :isRTL="$vs.rtl" />


                  <vs-button  color="primary" v-if="'Class' == $route.meta.creationType && activeUserInfo.level == 5"  type="filled" class="ml-auto md:block hidden cursor-pointer" @click="createClassPopup=true">Create
                      {{creationType}}</vs-button>

                  <vs-button  color="primary" v-if="'Lesson' == $route.meta.creationType && activeUserInfo.level == 5"  type="filled" class="ml-auto md:block hidden cursor-pointer" @click="popupActive=true">Create
                      {{creationType}}</vs-button>




                  <!-- DROPDOWN -->
                  <!--
                <vs-dropdown vs-trigger-click class="ml-auto md:block hidden cursor-pointer">
                  <vs-button radius icon="icon-settings" icon-pack="feather" />

                  <vs-dropdown-menu class="w-32">
                    <vs-dropdown-item>
                      <div @click="$router.push('/pages/profile').catch(() => {})" class="flex items-center">
                        <feather-icon icon="UserIcon" class="inline-block mr-2" svgClasses="w-4 h-4" />
                        <span>Profile</span>
                      </div>
                    </vs-dropdown-item>
                    <vs-dropdown-item>
                      <div @click="$router.push('/apps/todo').catch(() => {})" class="flex items-center">
                        <feather-icon icon="CheckSquareIcon" class="inline-block mr-2" svgClasses="w-4 h-4" />
                        <span>Tasks</span>
                      </div>
                    </vs-dropdown-item>
                    <vs-dropdown-item>
                      <div @click="$router.push('/apps/email').catch(() => {})" class="flex items-center">
                        <feather-icon icon="MailIcon" class="inline-block mr-2" svgClasses="w-4 h-4" />
                        <span>Inbox</span>
                      </div>
                    </vs-dropdown-item>
                  </vs-dropdown-menu>

                </vs-dropdown>
                  -->


              </div>
            </transition>

            <div class="content-area__content">

              <back-to-top bottom="5%" :right="$vs.rtl ? 'calc(100% - 2.2rem - 38px)' : '30px'" visibleoffset="500" v-if="!hideScrollToTop">
                <vs-button icon-pack="feather" icon="icon-arrow-up" class="shadow-lg btn-back-to-top" />
              </back-to-top>

              <transition :name="routerTransition" mode="out-in">
                <router-view
                  :key="$route.fullPath"
                  @changeRouteTitle="changeRouteTitle"
                  @setAppClasses="(classesStr) => $emit('setAppClasses', classesStr)" />
              </transition>
            </div>
          </div>
        </div>
      </div>
      <the-footer />
    </div>

      <vs-popup class=""  title="Give your class a name" :active.sync="createClassPopup">

          <div class="mt-1">

              <form>
                  <span class="text-danger text-sm" v-show="errors.has('classname')">{{ errors.first('classname') }}</span>
              <vs-row  vs-type="flex" vs-justify="space-between">
                  <vs-col vs-type="flex" vs-w="7">
                      <vs-input class="vx-col w-full" name="classname" v-model="classname" v-validate="'required'" icon-pack="feather" icon="icon-edit-2" icon-after label-placeholder="Enter Class Name" />

                  </vs-col>
                  <vs-col vs-type="flex" vs-w="5">
                      <vs-button  color="primary"  type="filled" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="createClass(classname)">Create
                          Class</vs-button>
                  </vs-col>
              </vs-row>
              </form>



          </div>

      </vs-popup>

      <vs-popup class=""  title="Select a Subject" :active.sync="popupActive">



          <div class="subject">

              <h5>
                  Create a lesson for your class by choosing on one of the subjects below.
              </h5>
              <div class="vx-row  mt-4">

          <subject-component
              v-for="subject in subjects"
              v-bind="subject"
              :popupActive="hideLessonPopup"
              :key="subject.id"
          ></subject-component>


                  </div>


              <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2">
                  <vs-col vs-type="flex" vs-w="7">


                  </vs-col>
                  <vs-col vs-type="flex" vs-w="5">
                      <vs-button  color="primary"  type="border" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="popupActive=false">
                          No Thanks
                      </vs-button>
                  </vs-col>
              </vs-row>


          </div>

      </vs-popup>







  </div>
</template>



<script>

import BackToTop           from 'vue-backtotop'
import HNavMenu            from '@/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue'
import navMenuItems        from '@/layouts/components/vertical-nav-menu/navMenuItems.js'
import TheNavbarHorizontal from '@/layouts/components/navbar/TheNavbarHorizontal.vue'
import TheNavbarVertical   from '@/layouts/components/navbar/TheNavbarVertical.vue'
import TheFooter           from '@/layouts/components/TheFooter.vue'
import themeConfig         from '@/../themeConfig.js'
import VNavMenu            from '@/layouts/components/vertical-nav-menu/VerticalNavMenu.vue'
import SubjectComponent from "../../components/SubjectComponent"
function Subject({ id, subject_color, subject_title}) {
    this.id = id;
    this.subject_color = subject_color;
    this.subject_title = subject_title;
}

export default {
  components: {
    BackToTop,
    HNavMenu,
    TheFooter,
    TheNavbarHorizontal,
    TheNavbarVertical,
    VNavMenu,
      SubjectComponent,
  },
  data () {
    return {
      footerType        : themeConfig.footerType  || 'static',
      hideScrollToTop   : themeConfig.hideScrollToTop,
      isNavbarDark      : false,
      navbarColor       : themeConfig.navbarColor || '#fff',
      navbarType        : themeConfig.navbarType  || 'floating',
      navMenuItems,
      routerTransition  : themeConfig.routerTransition || 'none',
      routeTitle        : this.$route.meta.pageTitle,
      creationType        : this.$route.meta.creationType,
      creationRoute        : this.$route.meta.creationRoute,
        showalert:true,
            colorx:"#def1d1",
            popupActive: false,
        createClassPopup: false,

          subjects: [],
        classname:""

    }
  },
  watch: {
    '$route' () {
      this.routeTitle = this.$route.meta.pageTitle,
          this.creationType       = this.$route.meta.creationType,
        this.creationRoute        = this.$route.meta.creationRoute

    },
    isThemeDark (val) {
      const color = this.navbarColor === '#fff' && val ? '#10163a' : '#fff'
      this.updateNavbarColor(color)
    },
    '$store.state.mainLayoutType' (val) {
      this.setNavMenuVisibility(val)
    }
  },
  computed: {
    bodyOverlay () { return this.$store.state.bodyOverlay },
    contentAreaClass () {
      if (this.mainLayoutType === 'vertical') {
        if      (this.verticalNavMenuWidth === 'default') return 'content-area-reduced'
        else if (this.verticalNavMenuWidth === 'reduced') return 'content-area-lg'
        else return 'content-area-full'
      } else return 'content-area-full'
    },
    footerClasses () {
      return {
        'footer-hidden': this.footerType === 'hidden',
        'footer-sticky': this.footerType === 'sticky',
        'footer-static': this.footerType === 'static'
      }
    },
    isAppPage () {
      return this.$route.meta.no_scroll
    },
    isThemeDark ()     { return this.$store.state.theme === 'dark' },
    layoutTypeClass () { return `main-${this.mainLayoutType}` },
    mainLayoutType ()  { return this.$store.state.mainLayoutType  },
    navbarClasses ()   {
      return {
        'navbar-hidden'   : this.navbarType === 'hidden',
        'navbar-sticky'   : this.navbarType === 'sticky',
        'navbar-static'   : this.navbarType === 'static',
        'navbar-floating' : this.navbarType === 'floating'
      }
    },
    verticalNavMenuWidth () { return this.$store.state.verticalNavMenuWidth },
    windowWidth ()          { return this.$store.state.windowWidth },

    activeUserInfo () {
    return this.$store.state.AppActiveUser

},
  },
  methods: {
      hideLessonPopup(){
          this.popupActive = false;
      },
      createClass(classname) {
          this.$validator.validateAll().then(result => {
              if (result) {
                  // if form have no errors

                  this.$http.post('api/auth/class',{ classname })
                      .then((response) => {
                         this.createClassPopup = false;
                          console.log(response.data.title)
                          this.popupActive = true

                          this.$router.push('/lessons/'+response.data.id).catch(() => {})

                      })


                      .catch((error) => { console.log(error) })

                //  alert("form submitted!");
              } else {
                  // form have errors
              }
          })

      },
    changeRouteTitle (title) {
      this.routeTitle = title
    },
    updateNavbar (val) {
      if (val === 'static') this.updateNavbarColor(this.isThemeDark ? '#10163a' : '#fff')
      this.navbarType = val
    },
    updateNavbarColor (val) {
      this.navbarColor = val
      if (val === '#fff') this.isNavbarDark = false
      else this.isNavbarDark = true
    },
    updateFooter (val) {
      this.footerType = val
    },
    setNavMenuVisibility (layoutType) {
      if ((layoutType === 'horizontal' && this.windowWidth >= 1200) || (layoutType === 'vertical' && this.windowWidth < 1200)) {
        this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', false)
        this.$store.dispatch('updateVerticalNavMenuWidth', 'no-nav-menu')
      } else {
        this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true)
      }
    },
    toggleHideScrollToTop (val) {
      this.hideScrollToTop = val
    }
  },
  created () {


    //  alert("wow:"+this.$route.meta.hidemenu);

    const color = this.navbarColor === '#fff' && this.isThemeDark ? '#10163a' : this.navbarColor
    this.updateNavbarColor(color)
    this.setNavMenuVisibility(this.$store.state.mainLayoutType)
      console.log("begin read");

      this.$http.get('/api/auth/subjects')
          .then((response) => { this.subjects = response.data })
          .catch((error) => { console.log(error) })
  },

}

</script>

