<template>

    <div>
        <!--    <h4>You have not created any classes.</h4>-->

        <!--
            <div class="sketchfab-embed-wrapper">



                <iframe title="A 3D model" width="640" height="480" src="https://sketchfab.com/models/67dea7cb7cda4c6f8c95898976c6c8b2/embed?autostart=0&amp;ui_controls=0&amp;ui_infos=0&amp;ui_inspector=1&amp;ui_stop=1&amp;ui_watermark=0&amp;ui_watermark_link=0" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>



            </div>-->



        <div class="vx-row" v-if="AllClasses.length > 0">

            <div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base" v-for="single_class in AllClasses" :key="single_class.id">
                <vx-card >
                    <div class="mb-6">
                        <h5 class="mb-2">{{single_class.title}}</h5>
                    </div>
                    <vs-divider></vs-divider>
                    <div class="flex justify-between flex-wrap">

                        <span>
                                     <vs-avatar v-for="(lpt, lpt_index) in splitTitles(single_class.learning_path_titles)" :key="'in-'+lpt_index" style="font-size:18pt;" class="p-2" color="primary" :text="splitTitlesWords(lpt)"/>
                        </span>
                        <span>

                        <vs-button :to="'/lessons/'+single_class.id">
                            Enter Class
                        </vs-button>

                        </span>
                    </div>
                </vx-card>
            </div>
        </div>

        <div v-else>
        <h4 v-if="activeUserInfo.level == 2">You have not joined any classes.</h4>
        <h4 v-else>You have not created any classes.</h4>
        </div>
    </div>

</template>



<script>

function MyClass({ id}) {
    this.id = id;
}
export default {
    computed: {
        activeUserInfo () {
            return this.$store.state.AppActiveUser

        }
    },
    data(){
        return {
            AllClasses:[]
        }
    },
    methods:{
        splitTitles(titles){



            if(titles !== null){
                return titles.split(',');
            }else{
                return [];

            }
        },
        splitTitlesWords(titlesWords){


            var words = titlesWords.split(' ');

            if(words.length > 1){
                return words[0]+" "+words[1];
            }else if(titlesWords.length > 1){
                return titlesWords[0]+" "+titlesWords[titlesWords.length];
            }else{
                return titlesWords;
            }
        }
    },
    created() {
        /*          console.log("CLASS START: "+data)

                      const { data } = this.$http.get('api/auth/class');
                  console.log("CLASS MID: "+data)

                  data.forEach(myclass => this.AllClasses.push(new MyClass(myclass)));

                      console.log("CLASS: "+data)
      */

        this.$http.get('api/auth/class')
            .then((response) => { this.AllClasses = response.data
            })
            .catch((error) => { console.log(error) })


    }

}

</script>
