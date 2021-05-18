<!-- =========================================================================================
  File Name: TheNavbar.vue
  Description: Navbar component
  Component Name: TheNavbar
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="relative">

        <div class="vx-navbar-wrapper" :class="classObj">

            <vs-navbar class="vx-navbar navbar-custom navbar-skelton" :color="navbarColorLocal" :class="textColor">

                <!-- SM - OPEN SIDEBAR BUTTON -->
                <feather-icon class="sm:inline-flex xl:hidden cursor-pointer p-2" icon="MenuIcon" @click.stop="showSidebar" />

                <vs-button color="primary" type="filled" icon-pack="feather" icon="icon-chevron-left" class="ml-1" @click="$router.back()"></vs-button>

                <vs-button color="primary" class="ml-2" type="filled" icon-pack="feather" icon="icon-chevron-right" @click="checker()"></vs-button>


                <search-bar class="ml-8" />


                <vs-spacer />


                <vs-button color="primary" type="filled" icon-pack="feather" size="large" icon="icon-phone" class="mr-8"></vs-button>


                <notification-drop-down />

                <profile-drop-down />

            </vs-navbar>



        </div>





    </div>
</template>


<script>
import Bookmarks            from './components/Bookmarks.vue'
import SearchBar            from './components/SearchBar.vue'
import NotificationDropDown from './components/NotificationDropDown.vue'
import ProfileDropDown      from './components/ProfileDropDown.vue'

export default {
    name: 'the-navbar-vertical',
    props: {
        navbarColor: {
            type: String,
            default: '#fff'
        }
    },
    components: {
        Bookmarks,
        SearchBar,
        NotificationDropDown,
        ProfileDropDown
    },
    computed: {
        navbarColorLocal () {
            //  return this.$store.state.theme === 'dark' && this.navbarColor === '#fff' ? '#10163a' : this.navbarColor
               return '#083085'
            //return '#006356'
        },
        verticalNavMenuWidth () {
            return this.$store.state.verticalNavMenuWidth
        },
        textColor () {
            //   return {'text-white': (this.navbarColor !== '#10163a' && this.$store.state.theme === 'dark') || (this.navbarColor !== '#fff' && this.$store.state.theme !== 'dark')}
            return {'text-white': true}
        },
        windowWidth () {
            return this.$store.state.windowWidth
        },

        // NAVBAR STYLE
        classObj () {
            if      (this.verticalNavMenuWidth === 'default') return 'navbar-default'
            else if (this.verticalNavMenuWidth === 'reduced') return 'navbar-reduced'
            else if (this.verticalNavMenuWidth)               return 'navbar-full'
        }
    },
    methods: {

        checker(){
            console.log( window.history.length)
        },
        showSidebar () {
            this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true)
        }
    }
}
</script>

