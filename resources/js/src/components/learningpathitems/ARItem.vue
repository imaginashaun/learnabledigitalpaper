<template>
<div>
<div class="vx-row">


    <div class="vx-col modelmenu_area">

    </div>


        <div v-if="hidemodel" class="vx-col model_area bg-img">

        </div>

       <model-viewer v-if="!hidemodel" class="model_area vx-col bg-img p-0" camera-controls autoplay ar ar-modes="webxr scene-viewer quick-look fallback" shadow-intensity="1" src="/3d/scene.gltf">


            <button slot="ar-button" style="background-color: white; border-radius: 4px; border: none; position: absolute; top: 16px; right: 16px; ">
                👋 Activate AR
            </button>
                             <button v-for="(hotspot, index) in object_hotspots" :key="index" :class="selected_hotspot === index || selected_hotspot === null? 'hotspot':'dimmed_hotspot hotspot'" :slot="'hotspot-'+index" :data-position="hotspot.position" :data-normal="hotspot.normal" :style="'background-color:'+hotspot.colour">
                                 <div class="hotspot-annotation">{{hotspot.text}}</div>
                             </button>
        </model-viewer>

    <div class="burger-menu">
        <ul>
            <li>
                <center>  <vs-avatar class="shadow-lg" color="rgb(255, 255, 255)" text-color="rgb(0, 0, 0)" icon-pack="feather" icon="icon-menu" />
                </center>  </li>


            <li v-for="(hotspot, index) in object_hotspots" :key="index" :class="selected_hotspot === index || selected_hotspot === null? '':'dimmed_hotspot'" @click.prevent="selected_hotspot = index" :style="'background: '+hotspot.colour">
                <i class="fa fa-address-book"></i><span>Title</span></li>
        </ul>
    </div>


</div>
</div>
</template>

<script>
    import '@google/model-viewer'
    import { SwipeableBottomSheet } from "vue-swipeable-bottom-sheet";

    export default {
        name: "ARItem",
        props:['learning_path_item_title', 'learning_path_item', 'id', 'learning_path_item_object', 'learning_path_id'],
        components: {
            SwipeableBottomSheet
        },

        data(){

            return {
                hidemodel:false,
                ar_object:null,
                object_hotspots:null,
                selected_hotspot:null
            }
        }
        ,
        created() {

            console.log(this.learning_path_item_object);
            this.ar_object = JSON.parse(this.learning_path_item_object);


            this.object_hotspots = JSON.parse(this.ar_object.object_hotspots);

            console.log(this.object_hotspots[0]);
        }


    }
    </script>


<style scoped>



    .model_area {
        position: fixed;
        top:0px;
        right:0px;
        height: 100%;
        width: 85%;
    }
    .modelmenu_area, div.burger-menu{
        width: 15%;
    }
    div.burger-menu {
        position: fixed;
        top:0px;
        left:0px;

        height: 100%;
        display: inline-block;
        background: linear-gradient(-90deg, #eeeeee, #ffffff);
    }
    div.burger-menu.open li > span {
        padding-right: 10px;
        width: 150px;
    }
    div.burger-menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    div.burger-menu ul li {
        padding: 10px 0px;
        border-top: 1px solid black;
        transition: ease 0.3s;
    }
    div.burger-menu ul li:hover {
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.3);
    }
    div.burger-menu ul li:last-child {
        border-bottom: 1px solid black;
    }
    div.burger-menu ul li i.fa {
        padding: 5px 20px;
        font-size: 35px;
    }
    div.burger-menu ul li span {
        font-size: 20px;
        font-weight: bolder;
        font-family: sans-serif;
        display: inline-block;
        width: 0;
        overflow-x: hidden;
        transition: 0.3s ease-in;
    }


    .hotspot{
        -webkit-backface-visibility: hidden;
        -webkit-transform-style: preserve-3d;
    }

    button.dimmed_hotspot.hotspot, button.dimmed_hotspot .hotspot-annotation {
        visibility: hidden;
    }

    .dimmed_hotspot {
        opacity: .4;
    }



    /*
    Model hotspot
     */
    button.hotspot{
        display: block;
        width: 20px;
        height: 20px;
        border-radius: 10px;
        border: none;
        background-color: blue;
        box-sizing: border-box;
    }


    button.hotspot[slot="hotspot-hand"]{
        --min-hotspot-opacity: 0;
        background-color: red;
    }

    button.hotspot[slot="hotspot-foot"]:not([data-visible]) {
        background-color: transparent;
        border: 3px solid blue;
    }

    .hotspot-annotation{
        background-color: #888888;
        position: absolute;
        transform: translate(10px, 10px);
        border-radius: 10px;
        padding: 10px;
        min-width: 200px;
        text-align: justify;
    }
    /* This keeps child nodes hidden while the element loads */
    :not(:defined) > * {
        display: none;
    }
    </style>
