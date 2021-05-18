<template>

    <div>
        <!--    <h4>You have not created any classes.</h4>-->



        <div class="vx-row">

            <div class="vx-col w-full sm:w-1/2 lg:w-1/6 mb-base">
                <vx-card >
                    <h4 class="mb-8">Profile</h4>



                    <div class="flex content-center flex-wrap">
                        <div class=" w-full text-center">

                        <vs-avatar style="font-size:18pt;" class="p-5" color="primary" :text="UserDetails.student.name" size="large"/>




                        </div>

                    </div>

                    <div class="flex content-center flex-wrap">

                        <div class=" w-full">


                                                <h2 class="mb-2 text-center">{{UserDetails.student.name}}</h2>

                        </div>
                        </div>

                    <div class="mt-0 mb-4">
                        <div class="flex justify-between">
                            <small v-if="UserDetails.progress === 100" class="font-semibold">Complete</small>
                            <small v-else class="font-semibold">Progress</small>

                            <small :class="(UserDetails.progress===100)?'text-success':'text-warning'">{{UserDetails.progress}}%</small>
                        </div>
                    </div>
                    <vs-progress :percent="UserDetails.progress" :color="(UserDetails.progress===100)?'success':'warning'" class="block mt-1 shadow-md mb-4"></vs-progress>

                    <div class="flex justify-between flex-wrap">
                        <span>

                            <div>



                                <vs-chip color="warning">
               <vs-avatar size="large" class="shadow-lg" color="rgb(255, 255, 255)" text-color="rgb(0, 0, 0)" icon-pack="feather" icon="icon-clock" />
       <span class="text-sm">  {{forHumans(UserDetails.total_time_spent)}}  </span>
      </vs-chip>

                           </div>


                            <!--                                   <vs-avatar style="font-size:18pt;" class="p-2" color="primary" :text="single_result.name"/>
                         -->

                        </span>
                        <span>

                    <vs-chip color="danger">
               <vs-avatar class="shadow-lg" color="rgb(255, 255, 255)" text-color="rgb(0, 0, 0)" icon-pack="feather" icon="icon-user-check" />
       <span class="text-sm">   {{UserDetails.total_score}} | {{UserDetails.total_percent}}%   </span>
      </vs-chip>
                        </span>
                    </div>
                </vx-card>
                <vx-card class="mt-8">
                    <h4 class="mb-8">Comment</h4>


                    <vs-textarea label="Comment" />
                </vx-card>

                <vs-button class="vx-col w-8/12 mt-4" @click="saveAllRubrics" >Save</vs-button>



                <vs-dropdown class="vx-col w-3/12">
                    <vs-button class="" type="border">
                        <feather-icon icon="MoreVerticalIcon" svgClasses="h-4 w-4" />
                    </vs-button>

                    <vs-dropdown-menu>
                        <vs-dropdown-item >

                            <vs-button class="vx-col w-full"  @click="$vs.notify({
        title:'ACTION PROHIBITED: <br> DEMO LICENSE',
        time:8000,
        text:'Deleting and editing lessons is prohibited. Please purchase the full version.',
        color:'warning',
        iconPack: 'feather',
        icon:'icon-alert-circle'})"  type="border" icon-pack="feather" icon="icon-archive">Draft</vs-button>
                        </vs-dropdown-item>


                        <vs-dropdown-item
                        >
                            <vs-button class="vx-col w-full" color="danger"  @click="$vs.notify({
        title:'ACTION PROHIBITED: <br>LEARNABLE DEMO LICENSE',
        time:8000,
        text:'Deleting and editing lessons is prohibited. Please purchase the full version of Learnable by contacting hello@itslearnable.co.za',
        color:'warning',
        iconPack: 'feather',
        icon:'icon-alert-circle'})"  icon-pack="feather" icon="icon-trash-2">Delete</vs-button>
                        </vs-dropdown-item>
                    </vs-dropdown-menu>
                </vs-dropdown>
            </div>

            <div class="vx-col w-full sm:w-2/2 lg:w-5/6 mb-base">


   <!--             <h4>Learner Progress Over Time</h4>

                <vue-apex-charts type="bar" height="350" :options="columnChart.chartOptions" :series="columnChart.series"></vue-apex-charts>
-->

                <vx-card>
                    <h4 class="mb-8">Learning Path</h4>


                    <vs-collapse
                        accordion
            type="border"
            icon-pack="feather"
            icon-arrow="icon-arrow-down"
            color="#000000"
            >
                <vs-collapse-item
                v-for="learning_path in UserDetails.learning_path_items" :key="learning_path.id">
                    <div slot="header">




                       <table width="100%"><tr><td> {{learning_path.learning_path_item_title}}

                       </td><td width="30%">




                        <vs-chip color="warning">

                            <vs-avatar size="large" class="shadow-lg" color="rgb(255, 255, 255)" text-color="rgb(0, 0, 0)" icon-pack="feather" icon="icon-clock" />
                            <span class="text-l">  {{forHumans(learning_path.timespent)}}  </span>
                        </vs-chip>
                       </td>
                       </tr>
                        </table>
                    </div>



                    <hr/>

                    <div v-if="learning_path.lesson_type_id === 2">


                        <div v-for="(question, index) in JSON.parse(learning_path.learning_path_item_object).type === 2? JSON.parse(learning_path.student_answers_object).questions:JSON.parse(learning_path.learning_path_item_object).questions" :set="answer =0">
                         <ul>





                             <h4 v-if="question.title"> {{question.title}} </h4>

                            <table  v-if="!question.title"><tr>
                                <td><h4>#{{answer +=index+1}}: </h4></td>
                                <td>
                                    <table>
                                 <tr>
                                     <td><b>Q: </b></td>
                                     <td><p v-html="question.body"> </p></td>
                                 </tr>
                             </table>
                            </td>
                            </tr>
                                <tr>
                                <td>
                                </td>
                                <td>

                             <p><b>A:</b> {{question.answer}}</p>

                            </td> </tr>
                            </table>

                           <li v-else>


                               <div v-for="option in question.options" v-if="option !== null">

                                   <div class="border-dark bg-success-gradient  text-white full-width p-1" v-if="question.selected === (answer+1) && question.answer === question.selected">
                                       <span class="bg-dark p-2 text-med m-1">{{answer +=1}}
                                       </span>
                                       <span class="text-xl">  {{option}}  </span>
                                   </div>

                                   <div class="border-dark bg-danger-gradient  text-white full-width p-1" v-else-if="question.selected === (answer+1) && question.answer !== question.selected">
                                       <span class="bg-dark p-2 text-med m-1">{{answer +=1}}
                                       </span>
                                       <span class="text-xl">  {{option}}  </span>
                                   </div>

                                   <div class="border-dark full-width p-1" v-else>
                                       <span class="bg-dark p-2 text-white text-med m-1">{{answer +=1}}
                                       </span>
                                       <span class="text-xl">  {{option}}  </span>
                                   </div>

                                   <hr>

                            </div>
                           </li>

                         </ul>

                            <hr>
                            <br>
                            <br>
                        </div>



                    </div>


                    <br/>
                    Total Time Spent: {{forHumans(learning_path.timespent)}}


                    <div v-if="(learning_path.lesson_type_id === 2 && (activeUserInfo.level == 3 || activeUserInfo.level == 4)) || showall">
                    <hr/>
                    <br/>
                    <br>
                    <h4>Assessment Rubric: </h4>



                    <vs-table stripe  ref="table" class="mt-5" :data="['ok']">

                        <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">

                            <div class="flex flex-wrap-reverse items-center data-list-btn-container">

                                <!-- ADD NEW -->
                                <div class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary" >
                                    <feather-icon icon="EyeIcon" svgClasses="h-4 w-4" />
                                    <span class="ml-2 text-base text-primary">Export</span>
                                </div>

                                <!-- ACTION - DROPDOWN -->
                                <vs-dropdown vs-trigger-click class="dd-actions cursor-pointer mr-4 mb-4">

                                    <div class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-32 w-full">
                                        <span class="mr-2">Actions</span>
                                        <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
                                    </div>

                                    <vs-dropdown-menu>

                                        <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="TrashIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Delete</span>
                </span>
                                        </vs-dropdown-item>





                                    </vs-dropdown-menu>
                                </vs-dropdown>



                            </div>


                        </div>


                        <template slot="thead">
                            <vs-th sort-key="position">Criteria</vs-th>
                            <vs-th sort-key="category">1</vs-th>
                            <vs-th sort-key="popularity">2</vs-th>
                            <vs-th sort-key="order_status">3</vs-th>
                            <vs-th>4</vs-th>
                            <vs-th>5</vs-th>
                            <vs-th>Actions</vs-th>
                        </template>

                        <template>
                            <tbody>
                            <vs-tr  v-for="(question, q_index) in multipleChoiceQuestions" :key="q_index">

                                <vs-td  align="center" valign="top" style="vertical-align: top">
                                    <vs-textarea class="w-full mt-2" name="question[]" v-model="question.title" placeholder="Criteria" />
                                </vs-td>


                                <vs-td align="center" valign="top" v-for="index in multipleChoiceOptions" :key="index">
<vs-textarea :placeholder="'Comment '+index" :name="'option_'+index+'[]'" v-model="question.options[index]"  class="w-full mt-2" />
                                        <vs-radio v-model="question.selected" :vs-name="'answer_'+q_index+'[]'" :vs-value="index" class="mt-2">
                                            <vs-button  color="primary" :disabled="question.selected !== index"  :type="question.selected === index?'filled':'border'" class="ml-auto md:block hidden cursor-pointer" @click="question.selected = index">
                                                {{index}}
                                            </vs-button>
                                        </vs-radio>


                                </vs-td>





                                <vs-td class="whitespace-no-wrap">
                                    <vs-button v-if="q_index !== 0" color="danger" class="md:block hidden cursor-pointer topright" icon-pack="feather" icon="icon-x" @click.prevent="$delete(multipleChoiceQuestions, q_index)">

                                    </vs-button>
                                </vs-td>

                            </vs-tr>
                            </tbody>
                        </template>

                    </vs-table>
                        <div v-for="a in UserDetails.answers" v-show="learning_path.id === a.student_answers_learning_path_item_id">


                    <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-5">
                        <vs-col vs-type="flex" vs-w="12">

                            <vs-button  color="primary" class="md:block hidden cursor-pointer" size="large" icon-pack="feather" icon="icon-plus" @click.prevent="multipleChoiceQuestions.push({ 'title':'',
                    selected:null,
                    options:[],
                    question_id: a.id
                })">
                            </vs-button>
                            <span class="mt-2 ml-3">
                        Add Another Criteria
                        </span>
                        </vs-col>
                    </vs-row>
                        </div>


                    </div>


                </vs-collapse-item>




            </vs-collapse>
                </vx-card>

            </div>

        </div>

    </div>

</template>



<script>

    import VueApexCharts from 'vue-apexcharts'

    export default {
        components: {
            VueApexCharts
        },
        computed: {
            activeUserInfo () {
                return this.$store.state.AppActiveUser

            }
        },

        data(){

            return {
                UserDetails:[],
                selected: [],
                itemsPerPage:10,
                showall:true,
                multipleChoiceOptions:5,
                multipleChoiceQuestions: [],
                learningpathitems:[],
                themeColors: ['#7367F0', '#28C76F', '#EA5455', '#FF9F43', '#1E1E1E'],
                columnChart: {
                    series: [{
                        name: 'Net Profit',
                        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                    }, {
                        name: 'Revenue',
                        data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                    }, {
                        name: 'Free Cash Flow',
                        data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                    }],
                    chartOptions: {
                        colors: this.themeColors,
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                endingShape: 'rounded',
                                columnWidth: '55%',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },

                        xaxis: {
                            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                        },
                        yaxis: {
                            title: {
                                text: '$ (thousands)'
                            }
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "$ " + val + " thousands"
                                }
                            }
                        }
                    }
                }
            }
        },
        methods:{


            async saveAllRubrics(){

                var self = this;

                var data = new FormData()


                console.log(this.multipleChoiceQuestions);

                    data.append('rubric', JSON.stringify({
                        'answers_are': this.multipleChoiceQuestions
                    }))



             //   data.append('learning_path_id', this.learning_path.id)


                this.$http.post('/api/auth/assessors',data)
                    .then((response) => {

                        console.log(response.data) })
                    .catch((error) => { console.log(error) })




            },



             forHumans ( seconds ) {
        var levels = [
            [Math.floor(seconds / 31536000), 'years'],
            [Math.floor((seconds % 31536000) / 86400), 'days'],
            [Math.floor(((seconds % 31536000) % 86400) / 3600), 'hr'],
            [Math.floor((((seconds % 31536000) % 86400) % 3600) / 60), 'min'],
            [(((seconds % 31536000) % 86400) % 3600) % 60, 'sec'],
        ];
        var returntext = '';

        for (var i = 0, max = levels.length; i < max; i++) {
            if ( levels[i][0] === 0 ) continue;
            returntext += ' ' + levels[i][0] + ' ' + (levels[i][0] === 1 ? levels[i][1].substr(0, levels[i][1].length-1): levels[i][1]);
        };
        return returntext.trim();
    }
        },
        created() {
            this.$http.get('/api/detailed_results/'+this.$route.params.learning_path_id+'/'+this.$route.params.user_id)
                .then((response) => { this.UserDetails = response.data
                })
                .catch((error) => { console.log(error) })
        }

    }

</script>
