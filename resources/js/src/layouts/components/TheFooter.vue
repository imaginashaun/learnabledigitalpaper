<template>
    <footer class="the-footer flex-wrap justify-between" :class="classes">
<!--
        <div class="container">
            <div class="row">
                <div class="col-md-12 my-3">
                    <h2>Room</h2>
                    <input v-model="roomId">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <vue-webrtc ref="webrtc"
                                    width="100%"
                                    :roomId="roomId"
                                    socket-u-r-l="http://socket/"
                                    v-on:joined-room="logEvent"
                                    v-on:left-room="logEvent"
                                    v-on:opened-room="logEvent"
                                    v-on:share-started="logEvent"
                                    v-on:share-stopped="logEvent"
                                    @error="onError" />
                    </div>
                    <div class="row">
                        <div class="col-md-12 my-3">
                            <button type="button" class="btn btn-primary" @click="onJoin">Join</button>
                            <button type="button" class="btn btn-primary" @click="onLeave">Leave</button>
                            <button type="button" class="btn btn-primary" @click="onCapture">Capture Photo</button>
                            <button type="button" class="btn btn-primary" @click="onShareScreen">Share Screen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Captured Image</h2>
                    <figure class="figure">
                        <img :src="img" class="img-responsive" />
                    </figure>
                </div>
            </div>
        </div>
-->

        <div v-if="length_c > 0" style="height: 200px" class="w-full">

        </div>

        <vs-chip color="primary">   <span>COPYRIGHT &copy; {{ new Date().getFullYear() }} <a href="https://itslearnable.co.za" style="color: #fff" target="_blank" rel="nofollow">Learnable</a>, All rights Reserved</span>
        </vs-chip>

<div v-if="length_c > 0" class="w-full  pl-32" style="position: fixed; bottom: 50px; right:50px; height:250px; z-index: 9999">
    <div class="vx-row w-full pl-16">
        <vx-tooltip text="Exit Lesson" position="right" class="ml-3 mr-3">
            <vs-button color="primary" radius class="mb-2" type="filled" icon-pack="feather" icon="icon-x" @click="screenshare=!screenshare"></vs-button>
        </vx-tooltip>

        <vx-tooltip text="Maximize" position="right" class="mr-3">
            <vs-button color="primary" radius class="mb-2" type="filled" icon-pack="feather" icon="icon-maximize-2" @click="screenshare=!screenshare"></vs-button>
        </vx-tooltip>
    </div>


        <div class="vx-row pl-16" style="height: 220px">


            <div class="vx-col h-full w-11/12">


                <div class="vx-row h-full">


            <div v-for="index in length_c" :key="index" class="vx-col h-full w-1/5 p-2">
                <vx-card class="h-full w-full">

                </vx-card>
            </div>

            </div>
            </div>

            <div class="vx-col h-full w-1/12 pt-3 pl-2">

                <vx-tooltip text="Turn Microphone On/Off" position="right">
                <vs-button color="primary" class="mb-2" type="filled" icon-pack="feather" size="large" :icon="mic?'icon-mic':'icon-mic-off'" @click="mic=!mic"></vs-button>
                </vx-tooltip>
                <vx-tooltip text="Turn Camera On/Off" position="right">
                    <vs-button color="primary" class="mb-2" type="filled" icon-pack="feather" size="large" :icon="video?'icon-video':'icon-video-off'" @click="video=!video"></vs-button>
                </vx-tooltip>

                <vx-tooltip text="Share Screen" position="right">
                <vs-button color="primary" class="mb-2" type="filled" icon-pack="feather" size="large" icon="icon-airplay" @click="screenshare=!screenshare"></vs-button>
                </vx-tooltip>

                <vx-tooltip text="Minimize" position="right">
                    <vs-button color="primary" class="mb-2" type="filled" icon-pack="feather" size="large" icon="icon-chevrons-left" @click="screenshare=!screenshare"></vs-button>
                </vx-tooltip>

            </div>

            </div>
            </div>

    </footer>
</template>

<script>

    import Vue from 'vue'
    import {WebRTC} from 'vue-webrtc'
    import { find, head } from 'lodash';
    Vue.component(WebRTC.name, WebRTC);

export default {
  name: 'the-footer',
    component: {
        //WebRTC
    },
    data(){

        return {
            length_c:0,
            mic:false,
            video:false,
            screenshare:false,
            img: null,
            roomId: "public-room"
        }
    },
    methods:{
        onCapture() {
            this.img = this.$refs.webrtc.capture();
        },
        onJoin() {
            this.$refs.webrtc.join();
        },
        onLeave() {
            this.$refs.webrtc.leave();
        },
        onShareScreen() {
            this.img = this.$refs.webrtc.shareScreen();
        },
        onError(error, stream) {
            console.log('On Error Event', error, stream);
        },
        logEvent(event) {
            console.log('Event : ', event);
        },
    },
  props: {

    classes: {
      type: String
    }
  },
    created() {

    }
}
</script>
