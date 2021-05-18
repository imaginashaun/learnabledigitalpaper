<!-- =========================================================================================
    File Name: KnowledgeBase.vue
    Description: Knowledge Base Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div id="knowledge-base-page">



        <div class="vx-row">

            <div class="vx-col lg:w-8/12 w-full pt-2">

                <div class=" flex items-center">

                    <img :src="knowledgeBaseCategory.knowledge_base_category_image" height="50">

                    <h2>{{knowledgeBaseCategory.knowledge_base_category_title}}</h2>

                </div>

                <iframe v-if="selected !== null && knowledgebaseItems.length > 0" class="mt-2" style="border: 2px solid #000; background:#000" :src="'https://www.youtube-nocookie.com/embed/'+parseYoutubeVideo(JSON.parse(selected.knowledge_base_item_object).url)+'?autoplay=1&modestbranding=1&showinfo=0&rel=0&iv_load_policy=3&theme=light'" width="100%" height="430" frameborder="0"></iframe>

                <p v-if="knowledgebaseItems.length === 0"><br>
                    No items found for this section. Please check your internet connection and try again.
                </p>
                <p v-else>
                    <br>
                    {{knowledgeBaseCategory.knowledge_base_category_description}}
                </p>
            </div>

            <div class="vx-col lg:w-4/12 w-full">


                <vs-table v-if="selected !== null" single v-model="selected"  ref="table" search :data="knowledgebaseItems">

                    <template slot-scope="{data}">
                        <tbody class="shadow-lg p-5">
                        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

                            <vs-td>
                                <vs-avatar color="primary" icon-pack="feather" icon="icon-play" />
                            </vs-td>

                            <vs-td>
                                <p class="product-category">{{ tr.knowledge_base_item_title }}</p>
                            </vs-td>
                        </vs-tr>
                        </tbody>
                    </template>


                </vs-table>


            </div>

            </div>


        </div>
</template>

<script>

    import VideoPlayer from "../../views/elements/VideoPlayer"
    import 'videojs-youtube'


export default{
  data () {
    return {
        knowledgeBaseCategory:null,
        knowledgebaseItems:[],
        selected: null,
        currentVideo:null

    }
  },
    created() {

        console.log("begin read kbi");


        this.knowledgeBaseCategory = this.$route.params.categoryItem;
        this.$http.get('/api/knowledgebaseitems/'+this.knowledgeBaseCategory.id)
            .then((response) => { this.knowledgebaseItems = response.data

                this.playVideo(this.knowledgebaseItems[0])
            })
            .catch((error) => { console.log(error) })
    },
  computed: {

  },
    mounted() {

    },
    methods: {
      playVideo(videoToPlay){
        //  this.currentVideo = videoToPlay
          this.selected = videoToPlay

      },
         parseYoutubeVideo(url){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : false;
    }
    },
  components: {
      VideoPlayer
  }
}
</script>

