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
        <!-- JUMBOTRON -->
        <div class="knowledge-base-jumbotron">
            <div class="knowledge-base-jumbotron-content lg:p-32 md:p-24 sm:p-16 p-8 rounded-lg mb-base">
                <h1 class="mb-1 text-white">Get resources and material</h1>
                <p class="text-white">Customize your learning path using these curated resources.</p>
                <vs-input icon-no-border placeholder="Search Topic or Keyword" v-model="knowledgeBaseSearchQuery" icon-pack="feather" icon="icon-search" size="large" class="w-full mt-6" />
            </div>
        </div>

        <!-- KNOWLEDGE BASE CARDS  -->
        <div class="vx-row">
                <div class="vx-col w-full md:w-1/3 sm:w-1/2 mb-base" v-for="item in filteredKB" :key="item.id" @click="$router.push({name:'knowledgebaseitem', params:{categoryItem:item}}).catch(() => {})">
                    <vx-card class="text-left cursor-pointer">
                        <img :src="item.knowledge_base_category_image" alt="image" height="120" class="mx-auto mb-4 maxwidth">
                     <!--   <h4 class="mb-2">{{ item.knowledge_base_category_title.toUpperCase() }}</h4>-->
                        <small>{{ item.knowledge_base_category_description }}</small>
                    </vx-card>
                </div>
            </div>
    </div>
</template>

<script>

export default{
  data () {
    return {
      knowledgeBaseSearchQuery: '',
        knowledgebaseCategories:[],
    }
  },
  computed: {
    filteredKB () {
      return this.knowledgebaseCategories.filter((item) => item.knowledge_base_category_title.toLowerCase().includes(this.knowledgeBaseSearchQuery.toLowerCase()) || item.knowledge_base_category_description.toLowerCase().includes(this.knowledgeBaseSearchQuery.toLowerCase()))
    }
  },
    created() {

            console.log("begin read");


            this.$http.get('/api/knowledgebase')
                .then((response) => { this.knowledgebaseCategories = response.data
                })
                .catch((error) => { console.log(error) })
    },
    methods: {},
  components: {}
}
</script>

<style lang="scss">
    .maxwidth {
        max-width: 100%;
    }
.knowledge-base-jumbotron-content {

    background-image: linear-gradient(0deg, rgba(4, 46, 95, 0.5), rgba(18, 47, 120, 0.64)), url('/images/knowledgebase.jpg');
    background-size: cover;
    background-position: bottom;
}
</style>
