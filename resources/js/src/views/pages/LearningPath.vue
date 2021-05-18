<template>
<div class="p-0">



    <Literature
        v-show="learning_path_item.lesson_type_id === 1"
        v-if="learning_path_item"
        v-bind="learning_path_item"
        :learning_path_id="$route.params.id"
        :user_id="$route.params.user_id"
    />

    <QAAssessment
        v-show="learning_path_item.lesson_type_id === 2"
        v-if="learning_path_item && JSON.parse(learning_path_item.learning_path_item_object).type === 2"
        v-bind="learning_path_item"
        :learning_path_id="$route.params.id"
        :user_id="$route.params.user_id"
    />
    <MultipleChoiceQuiz
        v-show="learning_path_item.lesson_type_id === 2"
        v-else-if="learning_path_item && JSON.parse(learning_path_item.learning_path_item_object).type === 1"
        v-bind="learning_path_item"
        :learning_path_id="$route.params.id"
        :user_id="$route.params.user_id"
    />

    <YoutubeVideo
        v-if="learning_path_item && learning_path_item.lesson_type_id === 4"
        v-show="learning_path_item.lesson_type_id === 4"
        v-bind="learning_path_item"
        :learning_path_id="$route.params.id"
        :user_id="$route.params.user_id"
    />


    <ARItem
        v-else-if="learning_path_item && learning_path_item.lesson_type_id === 6"
        v-show="learning_path_item.lesson_type_id === 6"
        v-bind="learning_path_item"
        :learning_path_id="$route.params.id"
        :user_id="$route.params.user_id"
    />




</div>

</template>

<script>

    import Literature from "../../components/learningpathitems/Literature";
    import MultipleChoiceQuiz from "../../components/learningpathitems/MultipleChoiceQuiz";
    import QAAssessment from "../../components/learningpathitems/QAAssessment";
    import YoutubeVideo from "../../components/learningpathitems/YoutubeVideo";
    import ARItem from "../../components/learningpathitems/ARItem";

    export default {
        name: "LearningPath",
        data(){

            return {
                learning_path_item:null
            }
        },
        components: {
            Literature,
            MultipleChoiceQuiz,
            QAAssessment,
            YoutubeVideo,
            ARItem
        },
        created() {
//            this.$http.get('/api/learningpathitems/'+this.$route.params.id)
            this.$http.get('/api/learningpathitems_get/'+this.$route.params.id+"/"+this.$route.params.user_id)
                .then((response) => { this.learning_path_item = response.data
                    console.log("OK: "+this.learning_path_item.id);
                })
                .catch((error) => { console.log(error) })

        }
    }
    </script>

