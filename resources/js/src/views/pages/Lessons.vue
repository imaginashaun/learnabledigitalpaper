<template>
<div>
    <div class="vx-row">
        <div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base" v-for="learning_path in learning_paths">
            <vx-card>
                <div slot="no-body">
                    <div class="p-4 text-white rounded-t-lg h-48" :style="{backgroundColor:learning_path.theme_color, backgroundImage: 'url('+learning_path.theme_illustration+')', backgroundSize:'80px', backgroundRepeat:'no-repeat', backgroundPosition:'right 10px bottom 20px'}">
                        <div class="vx-row">
                            <div class="vx-col w-5/6">
                            <h4 class="text-white">{{learning_path.learning_path_title}}</h4>
                                <p class="text-white">{{learning_path.learning_path_desc}}</p>
                            </div>
                            <div class="vx-col w-1/6">

                                <vs-button color="rgba(0,0,0,0)" @click="$vs.notify({
        title:'ACTION PROHIBITED: <br>DEMO LICENSE',
        time:8000,
        text:'Deleting and editing lessons is prohibited. Please purchase the full version.',
        color:'warning',
        iconPack: 'feather',
        icon:'icon-alert-circle'})" type="filled" icon-pack="feather" size="large" icon="icon-more-vertical" class="ml-1"></vs-button>
                            </div>
                        </div>
<br>
                        <b>{{learning_path.students}}</b> Registered Student{{learning_path.students> 1? 's':''}}

                    </div>

                </div>

                <div class="mt-0 mb-4">
                <div class="flex justify-between">
                    <small class="font-semibold">{{learning_path.progress >= 100?'Complete':'Avg. Learner Progress'}}</small>
                    <small :class="learning_path.progress >= 100?'text-success':'text-warning'">{{learning_path.progress>100?"100":learning_path.progress}}%</small>
                </div>
                </div>
                <vs-progress :percent="learning_path.progress" :color="learning_path.progress >= 100?'success':'warning'" class="block mt-1 shadow-md"></vs-progress>
                <div class="flex justify-between flex-wrap">
                    <vs-button class="mt-4" type="border" color="#b9b9b9" :to="'/showresults/'+learning_path.id">Show Results</vs-button>
                    <vs-button class="mt-4 mr-0 shadow-lg" color="primary" :to="'/lesson/edit/'+learning_path.id">View Lesson</vs-button>
                </div>
            </vx-card>
        </div>
    </div>
</div>
</template>
<script>

    export default {
        data() {
            return {
                learning_paths: [],
            }
        },
        created() {

            this.$http.get('/api/lessons/getall/'+this.$route.params.class_id)
                .then((response) => { this.learning_paths = response.data

                })
                .catch((error) => { console.log(error) })

        },
        methods: {
            async update(id, color) {
                // To do
            },
            async del(id) {
                // To do
            },
            async read() {

            },
        },
        computed: {
            activeUserInfo () {
                return this.$store.state.AppActiveUser

            }
        },
    }
</script>
