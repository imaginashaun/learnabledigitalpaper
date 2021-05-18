<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.displayName">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.displayName }}</p>
      <small>Available</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">

          <vs-avatar style="font-size:18pt;" size="large" color="primary" :text="activeUserInfo.displayName"/>

      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">

         <!-- <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Profile</span>
          </li>

          <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
            <feather-icon icon="MailIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Inbox</span>
          </li>

          <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
            <feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Tasks</span>
          </li>

          <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
            <feather-icon icon="MailIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Messages</span>
          </li>-->

          <vs-divider class="m-1" />

          <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Logout</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>


      <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

          <div class="con-img mx-2">


              <vs-button color="primary" type="filled" icon-pack="feather" size="large" icon="icon-plus" class="ml-1"></vs-button>
          </div>

          <vs-dropdown-menu class="vx-navbar-dropdown">
              <ul style="min-width: 12rem">


                  <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push('/lesson/edit/new').catch(() => {})">
                      <feather-icon icon="PlusIcon" svgClasses="w-4 h-4" />
                      <span class="ml-2">Create Lesson</span>
                  </li>
                  <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                      <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
                      <span class="ml-2">Create AR</span>
                  </li>
                  <vs-divider class="m-1" />
              </ul>
          </vs-dropdown-menu>
      </vs-dropdown>
  </div>
</template>

<script>
export default {
  data () {
    return {

    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    logout () {
        localStorage.clear();
      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$router.push('/pages/login').catch(() => {})
    }
  }
}
</script>
