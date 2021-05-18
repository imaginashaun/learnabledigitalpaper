<template>
    <div>
        <video ref="videoPlayer" class="video-js"></video>


    </div>
</template>

<script>
    import videojs from 'video.js';

    export default {
        name: "VideoPlayer",
        props: {
            code:""
        },
        data() {
            return {
                player: null
            }
        },
        mounted() {


        },
        beforeDestroy() {

        }
    }

    </script>
