<template>
<div>

    <h2>{{learning_path_item_title}}</h2>
    <vs-divider/>

    <form-wizard v-if="!submitted" color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Submit" @on-complete="submitQuiz">
        <tab-content v-if="lp_object !== null" v-for="(quiz, index) in lp_object.questions" :key="index" :title="''" class="mb-5">

            <div class="vx-row">
                <div class="vx-col w-full mt-5">
<vs-card class="p-5">
                    <h4>{{quiz.title}}</h4>
                    <ul class="centerx mt-5">
                        <li v-for="(option, o_index) in quiz.options" class="mb-5">
                            <vs-radio v-model="quiz.answer" v-show="option !== null" :vs-value="o_index"><h4>{{option}}</h4></vs-radio>
                        </li>
                    </ul>
</vs-card>
                </div>
            </div>
        </tab-content>
    </form-wizard>


    <div v-if="submitted">
        <center>
            <h3 class="text-success">Submitted</h3>

            <feather-icon icon="CheckIcon" class="mt-10" svgClasses="w-16 h-16 text-success" />

        </center>
    </div>

</div>

</template>

<script>

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'


    export default {
        name: "MultipleChoiceQuiz",
        props:['learning_path_item_title', 'learning_path_item', 'id', 'user_id', 'learning_path_item_object', 'learning_path_id'],
        data(){

            return {
                lp_object:null,
                submitted:false
            }
    },
        components: {
            FormWizard,
            TabContent
        },
        created() {

            this.lp_object = JSON.parse(this.learning_path_item_object);
        },
        methods:{
            submitQuiz(){
                var self = this

                var data = new FormData()
                data.append('student_answers_student_id', this.user_id)
                data.append('student_answers_learning_path_id', this.learning_path_id)
                data.append('student_answers_learning_path_item_id', this.id)
                data.append('student_answers_object', JSON.stringify(this.lp_object))

                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                this.$http.post('/api/learningpathitems/submit',data,config)
                    .then((response) => {
                        self.submitted = true

                        console.log(response.data) })
                    .catch((error) => { console.log(error) })





            }
        }
    }
    </script>
