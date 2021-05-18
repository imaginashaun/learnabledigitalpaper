<template>

    <div>
        <!--    <h4>You have not created any classes.</h4>-->
<!--
<div class="vx-row">
    <div class="vx-col w-full sm:w-1/2 lg:w-2/3 mb-base" >

        <vue-apex-charts type="area" height="350" :options="lineAreaChartSpline.chartOptions" :series="lineAreaChartSpline.series"></vue-apex-charts>

    </div>
<div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base">

    <vue-apex-charts  type="donut" height="350" :options="donutChart.chartOptions" :series="donutChart.series"></vue-apex-charts>

</div>

</div>-->


        <div class="vx-row" v-if="AllResults.length > 0">

            <div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base" v-for="single_result in AllResults" :key="single_result.id">
                <vx-card >


                    <div class="flex justify-between flex-wrap">
                        <span>
                                      <vs-avatar style="font-size:18pt;" class="p-5" color="primary" :text="single_result.name"/>


                        </span>
                        <span>

                                                <h5 class="mb-2">{{single_result.name}}</h5>


                        </span>
                    </div>

                    <!-- <div class="mt-0 mb-4">
                         <div class="flex justify-between">
                             <small class="font-semibold">Progress</small>
                             <small class="text-success">100%</small>
                         </div>
                    </div>
                    <vs-progress :percent="100" color="success" class="block mt-1 shadow-md mb-4"></vs-progress>
-->
                    <div class="flex justify-between flex-wrap">
                        <span>

                          <!--  <div>



                                <vs-chip color="warning">
               <vs-avatar size="large" class="shadow-lg" color="rgb(255, 255, 255)" text-color="rgb(0, 0, 0)" icon-pack="feather" icon="icon-clock" />
       <span class="text-xl">  {{forHumans(1000)}}  </span>
      </vs-chip>

                           </div>-->

                           <div>


                               <vs-chip color="danger">
               <vs-avatar class="shadow-lg" color="rgb(255, 255, 255)" text-color="rgb(0, 0, 0)" icon-pack="feather" icon="icon-user-check" />
       <span class="text-xl">   1/2 | 50%     </span>
      </vs-chip>



                           </div>
                            <!--                                   <vs-avatar style="font-size:18pt;" class="p-2" color="primary" :text="single_result.name"/>
                         -->

                        </span>
                        <span>

                        <vs-button :to="'/detailed_lesson_results/'+$route.params.learning_path_id+'/'+single_result.id">
                           Detailed Results
                        </vs-button><br>
                           <center> Show detailed view
                           </center>
                        </span>
                    </div>
                </vx-card>
            </div>
        </div>

        <h4 v-else>There are no results yet for this lesson.</h4>
    </div>

</template>



<script>

    import VueApexCharts from 'vue-apexcharts'

    export default {
        components: {
            VueApexCharts
        },

        data(){

            return {
                AllResults:[],
                lesson_path_id:null,
                themeColors: ['#7367F0', '#28C76F', '#EA5455', '#FF9F43', '#1E1E1E'],
                donutThemeColors: ['#7367F0', '#28C76F', '#EA5455', '#FF9F43', '#1E1E1E'],

                lineAreaChartSpline: {
                    series: [{
                        name: 'Time Spent',
                        data: [31, 40, 28, 51, 42, 109, 100]
                    }, {
                        name: 'Results',
                        data: [11, 32, 45, 32, 34, 52, 41]
                    }],
                    chartOptions: {
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        colors: this.themeColors,
                        xaxis: {
                            type: 'datetime',
                            categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00",
                                "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00",
                                "2018-09-19T06:30:00"
                            ],
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy HH:mm'
                            },

                        }
                    }
                },

                donutChart: {
                    series: [44, 55, 41, 17],
                    chartOptions: {
                        colors: this.donutThemeColors,
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    }
                }
            }
        },
        methods:{
             forHumans ( seconds ) {
        var levels = [
            [Math.floor(seconds / 31536000), 'years'],
            [Math.floor((seconds % 31536000) / 86400), 'days'],
            [Math.floor(((seconds % 31536000) % 86400) / 3600), 'hours'],
            [Math.floor((((seconds % 31536000) % 86400) % 3600) / 60), 'minutes'],
            [(((seconds % 31536000) % 86400) % 3600) % 60, 'seconds'],
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
            this.$http.get('/api/lesson_results/'+this.$route.params.learning_path_id)
                .then((response) => {

                    this.lesson_path_id = this.$route.params.learning_path_id;
                    this.AllResults = response.data
                })
                .catch((error) => { console.log(error) })
        }

    }

</script>
