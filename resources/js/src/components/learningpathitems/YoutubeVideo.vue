<template>
<div>

    <h2>{{learning_path_item_title}}</h2>
    <vs-divider/>
    <div class="video-container">
    <iframe v-if="learning_path_item_object !== null" :src="'https://www.youtube.com/embed/'+getYouTubeVideo(JSON.parse(learning_path_item_object).url)" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

</template>

<script>


    export default {
        name: "YoutubeVideo",
        props:['learning_path_item_title', 'learning_path_item', 'id', 'learning_path_item_object', 'learning_path_id'],
        data(){


            return {

            }


    },
        components: {

        },
        methods:{
            getYouTubeVideo(video_url){

                var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
                var match = video_url.match(regExp);
                return (match&&match[7].length==11)? match[7] : false;

            },
        },
        created() {



        }
    }
    </script>

<style>

    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

</style>
