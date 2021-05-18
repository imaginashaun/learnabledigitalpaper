<template>
    <div class="vx-row">

        <!-- HORIZONTAL LAYOUT -->
        <div class="vx-col w-full mb-base">
            <vx-card>
                <div class="vx-row mb-6">

                    <div class="vx-col lg:w-9/12 w-full">
                        <div v-if="learning_path !== null">

                        <div class="mt-3 mb-1">Title.</div>

                        <vs-input class="w-full mb-6" v-model="learning_path.learning_path_title" />

                        <div class="mt-3 mb-1">Description.</div>


                            <vs-textarea height="140px" counter="300" :counter-danger.sync="counterDanger" v-model="learning_path.learning_path_desc" />


                            <div class="vx-row">
                        <div class="vx-col  w-1/3  mb-6" v-for="lesson_type in lesson_types"
                             :key="lesson_type.id" v-if="lesson_type.id == 2 || activeUserInfo.level != 3">
                        <vs-button
                                   type="border"
                                   @click="lesson_type.id===5?knowledgebasePopup=true:lesson_type.id===3?audioPopup=true:lesson_type.id===4?videoPopup=true:lesson_type.id===2?assessmentPopup=true:lesson_type.id === 1?literatureEditorPopup=true:arEditorShow=true"

                                   size="large" class="w-full h-full">

                            <img class="mx-auto mb-6 block bg-transparent" height="80px" :src="lesson_type.type_icon" />

                            <h5 class="mb-2  text-center">{{lesson_type.type_title}}</h5>

                        </vs-button>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="vx-col lg:w-3/12 w-full mt-10">





                            <vs-button class="vx-col w-8/12" @click="saveLearningPath" >{{ learning_path !== null?'Save': 'Publish'}}</vs-button>



                            <vs-dropdown class="vx-col w-3/12">
                                <vs-button class="" type="border">
                                    <feather-icon icon="MoreVerticalIcon" svgClasses="h-4 w-4" />
                                </vs-button>

                                <vs-dropdown-menu>
                                    <vs-dropdown-item >

                                        <vs-button class="vx-col w-full"  type="border" icon-pack="feather" icon="icon-archive">Draft</vs-button>
                                    </vs-dropdown-item>


                                    <vs-dropdown-item
                                    >
                                        <vs-button class="vx-col w-full" color="danger"  icon-pack="feather" icon="icon-trash-2">Delete</vs-button>
                                    </vs-dropdown-item>
                                </vs-dropdown-menu>
                            </vs-dropdown>


                        <!--    <vs-button class="vx-col w-1/3" type="border" icon-pack="feather" icon="icon-archive">Draft</vs-button>
                            <vs-button class="vx-col w-1/3" color="danger"  icon-pack="feather" icon="icon-trash-2">Delete</vs-button>-->


                        <div class="vx-row">
                        <div class="mt-3 vx-col  w-1/3">
                            <div class="mt-3 mb-1">Theme.</div>

                            <vs-dropdown>

                                <a class="flex items-center" href.prevent>

                                    <div
                                        v-for="theme in themes"
                                        :key="theme.id"
                                        v-if="theme.id === learning_path.learning_path_theme"
                                        :style="{backgroundColor: theme.theme_color}" class="text-white px-2 rounded">

                                        <vs-dropdown-item>
                                            <div :style="{backgroundColor: theme.theme_color}" ><img :src="theme.theme_illustration" height="50" width="50"></div>
                                        </vs-dropdown-item>



                                    </div>
                                </a>

                                <vs-dropdown-menu>

                                    <vs-dropdown-item v-for="theme in themes"
                                                      @click="changeTheme(theme.id)"


                                                      :key="theme.id"
                                    > <div :style="{backgroundColor: theme.theme_color}" class="rounded p-5" >


                                        <img :src="theme.theme_illustration" height="40">
                                    </div>

                                    </vs-dropdown-item>


                                </vs-dropdown-menu>
                            </vs-dropdown>
                        </div>

                        <div class="mt-3 vx-col   w-2/3 ">
                            <div class="mt-3 mb-1">Subject.</div>

                            <v-select v-if="learning_path !== null" class="w-full style-chooser" @input="changeSubject" :reduce="subject_single => subject_single.id" :options="subjects" :value="learning_path.learning_path_subject" solo label="subject_title" :dir="$vs.rtl ? 'rtl' : 'ltr'" />

                        </div>
                        </div>


                        <div class="vx-row">

                            <div v-if="learning_path" class="mt-8 pt-2 vx-col w-full">

                                <h2>Code: {{learning_path.learning_path_code.toUpperCase()}}</h2>
                               <p class="mt-5"> Students can scan the code below to join the lesson.
                               </p>
                                <vx-card
                                    class="mt-5"
                                >   <img :src="'https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl='+learning_path.learning_path_code+'&choe=UTF-8'" width="100%">
                                </vx-card>
                            </div>


                        </div>
                        </div>
                </div>

            </vx-card>

            <div class="mt-10">
                <div class="vx-row">
                    <div class="vx-col w-9/12"><h2>Learning Path</h2></div>

                </div>


                <vs-table  ref="table" class="mt-5"  multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="learningpathitems">

                    <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">

                        <div class="flex flex-wrap-reverse items-center data-list-btn-container">

                            <!-- ADD NEW -->
                            <div class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary" >
                                <feather-icon icon="EyeIcon" svgClasses="h-4 w-4" />
                                <span class="ml-2 text-base text-primary">Preview</span>
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

                                    <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="LockIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Lock/ Unlock</span>
                </span>
                                    </vs-dropdown-item>



                                </vs-dropdown-menu>
                            </vs-dropdown>



                        </div>


                    </div>


                    <template slot="thead">
                        <vs-th sort-key="position">ID</vs-th>
                        <vs-th sort-key="category">Title</vs-th>
                        <vs-th sort-key="popularity">Type</vs-th>
                        <vs-th sort-key="order_status">Status</vs-th>
                        <vs-th>Lock</vs-th>
                        <vs-th>Updated</vs-th>
                        <vs-th>Actions</vs-th>
                    </template>

                    <template slot-scope="{data}">
                        <tbody>
                        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

                            <vs-td>
                                {{ tr.id}}

                            </vs-td>

                            <vs-td>
{{!tr.learning_path_item_title ? 'No Title': tr.learning_path_item_title}}
                            </vs-td>

                            <vs-td>
                                <vs-avatar class="bg-gray" size="40px" :src="tr.type_icon" />
                            </vs-td>
                            <vs-td>
                                <vs-chip :color="tr.learning_path_item_state === 1 ? 'success':'danger'" class="product-order-status">{{ tr.learning_path_item_state === 1 ? 'Active': 'Disabled' }}</vs-chip>
                            </vs-td>

                            <vs-td>

                                <vs-button color="success" type="border" size="small"  @click.stop="">
                                    <feather-icon icon="LockIcon" svgClasses="h-4 w-4" /><br>
                                    Unlocked</vs-button>

                            </vs-td>

                            <vs-td>
                                {{ getTimeAgo(tr.updated_at)  }}
                            </vs-td>


                            <vs-td class="whitespace-no-wrap">
                                <feather-icon icon="EditIcon" svgClasses="w-5 h-5 hover:text-primary stroke-current" @click.stop="editData(tr)" />
                                <feather-icon icon="TrashIcon" svgClasses="w-5 h-5 hover:text-danger stroke-current" class="ml-2" @click.stop="deleteData(tr.id)" />
                            </vs-td>

                        </vs-tr>
                        </tbody>
                    </template>

                </vs-table>

            </div>



        </div>

<!--        <vs-popup fullscreen class="nopaddingpopup"  title="Learnable AR Studio" :active.sync="arEditorShow">-->
        <vs-popup  text-color="rgba(255,255,255,.9)" title="Learnable AR Studio"  background-color-popup="rgba(59,59,59,1.0)" fullscreen class="nopaddingpopup darktheme" :active.sync="arEditorShow">


                <div class="vx-row h-full p-0 m-0 text-white">

                    <div class="vx-col w-1/2 text-white position-relative" style="position:relative;">

                        <div class="vx-row p-2 mt-5 mb-5 text-white">



                            <div class="vx-col w-1/5 text-white">

                                <vs-button color="success" type="relief">
                                    <feather-icon icon="MicIcon" svgClasses="h-4 w-4" /><br>
                                     On</vs-button></div>


                            <div class="vx-col w-1/5">

                                <vs-button color="success" type="relief" :disabled="{disabled: button_play}">
                                    <feather-icon icon="PlayIcon" svgClasses="h-4 w-4" /><br>
                                    Play</vs-button></div>




                            <div class="vx-col w-1/5">

                                <vs-button color="danger" type="relief"  @click.prevent="startRecording(button_record)">
                                    <feather-icon :icon="button_record? 'PauseIcon' : 'CircleIcon'" svgClasses="h-4 w-4" /><br>
                                    {{button_record? 'Pause': 'Record'}}</vs-button>

                            </div>

                            <div class="vx-col w-1/5">

                                <h2 class="w-full mx-5 my-4 text-white" v-html="studioDuration">{{studioDuration}}</h2>
                            </div>

                            <div class="vx-col w-1/5">
                                <vs-button color="rgba(255,255,255,.9)" type="border" :disabled="{disabled: button_edit}">
                                 <feather-icon icon="RefreshCcwIcon" svgClasses="h-4 w-4" /> <br>Reset
                                </vs-button>
                                </div>

                            <br>



                            <vs-slider class="w-full mx-8 my-8" color="success" disabled="true" />

                        </div>


                        <div
                            v-if="selected_vr_object_active"
                            class="vs-popup shadow-lg" style="height: 80%; background: rgb(44, 44, 44);">

                            <header class="vs-popup--header">                                <img height="62" class="m-2" :src="JSON.parse(selected_vr_object.material_item_object).thumb" />
                                <div class="vs-popup--title">


                                <h3>
                                {{selected_vr_object.material_item_title}}




                            </h3></div><i v-on:click="closeSelectedObject" class="vs-icon notranslate icon-scale vs-popup--close vs-popup--close--icon material-icons null" style="background: rgb(44, 44, 44);">close</i></header>


                            <div v-model="hotspotChildren" v-for="(hotspotChild, index) in hotspotChildren" v-if="hotspotChild.classList.contains('hotspot')"
                                  :key="index" class="" :style="'border-bottom: 1px solid rgb(80, 80, 80); min-height: 100px; background: linear-gradient(rgb(47, 47, 47), rgb(29, 29, 29), rgb(47, 47, 47));'">

<div class="vx-row">
                                <div class="vx-col  w-1/12"
                                     :style="'background: '+hotspotChild.dataset.selectedColour+'; min-height: 100px; '">


                                 <!--   <input v-model="labelpincolor" type="color" name="" value="">
-->

                            </div>

                                <div class="vx-col  w-10/12">
                                    {{hotspotChild.dataset.alltext.length > 0?hotspotChild.dataset.alltext:'#'+index}}
                                </div>

    <div class="vx-col  w-1/12 p-1 shadow-lg"
         style="background:  rgb(60, 60, 60); min-height: 100px; ">

        <vs-avatar icon-pack="feather"   color="dark" icon="icon-eye" />
        <vs-avatar icon-pack="feather"   color="dark" icon="icon-edit-2" />
        <vs-avatar icon-pack="feather"   color="dark" icon="icon-x" />




    </div>



                            </div>

                            </div>
                        </div>


<div v-if="!selected_vr_object_active">
                        <div class="vx-row">

                        <vx-card class="vx-col w-full mx-5 bg-dark-gradient"
                                 title-color="#fff"

                                 content-color="#fff"
                        >

                            <vs-input  icon-pack="feather" icon="icon-search" placeholder="Search AR Library" class="w-full" />

                        </vx-card>



                            <h6 class="mx-8 mt-4 text-light" style="color:rgba(165,165,165,0.7)">Select your preferred object</h6>

                        </div>


                        <div class="vx-row my-5 mx-2">
                            <div class="vx-col  w-1/3  mb-6" v-for="ar_object in ar_objects"
                                 :key="ar_object.id">
                                <vs-button
                                    type="border"
                                    color="warning"
                                    :color="selected_vr_object !== null ? ar_object.id === selected_vr_object.id ? 'warning': 'dark' : ar_object.id === ar_objects[0].id ? 'warning': 'dark'"
                                    size="large" class="w-full p-0"
                                    @click.prevent="changeSelectedObject(ar_object)"
                                >

                                    <img class="mx-auto block bg-transparent w-full" :src="JSON.parse(ar_object.material_item_object).thumb" />

                                    <h5 class="p-2 w-full text-center text-white rounded-b-full" style="position: absolute; bottom:0px; background: rgba(0,0,0,.4)">{{ar_object.material_item_title}}</h5>

                                </vs-button>
                            </div>
                        </div>


</div>

                        <vs-button color="warning" type="relief"  style="position: absolute; bottom:30px; right:30px;"  @click.prevent="saveAR()">
                            Save</vs-button>
                    </div>

<div class="vx-col w-1/2 p-0 m-0 h-full" style="background: linear-gradient(#2f2f2f, #1d1d1d,#2f2f2f); position: relative">

                       <model-viewer v-on:click="clickModel"  v-if="selected_vr_object !== null" class="ccd_c w-full h-full" camera-controls autoplay ar ar-modes="webxr scene-viewer quick-look fallback" shadow-intensity="1" :src="JSON.parse(selected_vr_object.material_item_object).object" :alt="selected_vr_object.material_item_title">
                      <!-- <model-viewer v-on:click=" clickModel" v-if="selected_vr_object !== null" class="ccd_c w-full h-full" camera-controls autoplay ar ar-modes="webxr scene-viewer quick-look fallback" shadow-intensity="1" :src="JSON.parse(selected_vr_object.material_item_object).object" :alt="selected_vr_object.material_item_title">
-->

                            <button slot="ar-button" style="background-color: white; border-radius: 4px; border: none; position: absolute; top: 16px; right: 16px; ">
                                👋 Activate AR
                            </button>


                           <div style="position: absolute; bottom:30px; right:30px">
                               <vs-button  color="transparent" class="mr-5 cursor-pointer" @click.prevent="arLabelShow=true">

                               <vs-chip color="danger">
                                   <vs-avatar icon-pack="feather"   color="danger" icon="icon-film" />
                                   <span>Add Label/Pin</span>
                               </vs-chip>


                               </vs-button>
                               <!-- <vs-chip :color="labelpincolor" class="mr-5 cursor-pointer" :style="'color:'+randominverseColor" @click="alert('ok')">
                               <vs-avatar icon-pack="feather"   :style="'color:'+randominverseColor" icon="icon-film" />
                               <span>Label Pins</span>
                           </vs-chip>-->
                               <vs-button  color="transparent" class="cursor-pointer">

                           <vs-chip color="warning" class="cursor-pointer">
                               <vs-avatar icon-pack="feather"  color="warning" icon="icon-git-pull-request" />
                               <span>Annimations</span>

                           </vs-chip>
                               </vs-button>
                           </div>


<!--
                           <button class="hotspot" slot="hotspot-hand" data-position="-0.54 0.93 0.1" data-normal="-0.73 0.05 0.69">
                               <div class="hotspot-annotation">This hotspot disappears completely</div>
                           </button>-->


                        </model-viewer>

    <vs-popup title="Add Label/Pin" :active.sync="arLabelShow">


        <div>

            <div class="mt-3 mb-1">Add some information to your label..</div>

            <vs-textarea label="Enter the label text below" v-model="pinText" />

            <div class="mt-3 mb-1">Color</div>

         <!--   <input v-model="labelpincolor" type="color" name="" value="">
-->

            <v-swatches v-model="labelpincolor" inline></v-swatches>



        </div>

        <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-10 p-2 rounded-lg border-primary">
            <vs-col vs-type="flex" vs-w="7">


            </vs-col>
            <vs-col vs-type="flex" vs-w="5">
                <vs-button  color="primary" class="ml-auto md:block hidden cursor-pointer vx-col w-12/12" @click.prevent="[initPin(), arLabelShow=false]">
                    Add to 3D Object
                </vs-button>
            </vs-col>
        </vs-row>

    </vs-popup>









</div>



                </div>

        </vs-popup>



        <vs-popup class=""  title="Assessment" :active.sync="assessmentPopup">



            <div class="subject">

                <h5>
                    Select an assessment type.
                </h5>
                <div class="vx-row  mt-4">


                    <div class="vx-col  w-1/2  mb-6">
                        <vs-button
                            type="border"
                            @click="[assessmentPopup=false,multipleChoicePopup=true]"

                            size="large" class="w-full h-full">

                            <img class="mx-auto mb-6 block bg-transparent" height="80px" src="/images/lesson_types/assessment.png" />

                            <h5 class="mb-2  text-center">Multiple Choice Quiz Assessment</h5>

                        </vs-button>


                    </div>
                    <div class="vx-col  w-1/2  mb-6">

                    <vs-button
                        type="border"
                        @click="[assessmentPopup=false,questionAnswerPopup=true]"

                        size="large" class="w-full h-full">

                        <img class="mx-auto mb-6 block bg-transparent" height="80px" src="/images/lesson_types/assessment.png" />

                        <h5 class="mb-2  text-center">Question & Answer Assessment</h5>

                    </vs-button>
                    </div>

                </div>





            </div>

        </vs-popup>


        <vs-popup class=""  title="Literature" :active.sync="literaturePopup">



            <div class="subject">

                <h5>
                    Select the your literature creation tool.
                </h5>
                <div class="vx-row  mt-4">


                    <div class="vx-col  w-1/2  mb-6">
                        <vs-button
                            type="border"
                            @click="[literaturePopup=false,literatureEditorPopup=true]"

                            size="large" class="w-full h-full">

                            <img class="mx-auto mb-6 block bg-transparent" height="80px" src="/images/lesson_types/literature.png" />

                            <h5 class="mb-2  text-center">Online Document Editor</h5>

                        </vs-button>


                    </div>
                    <div class="vx-col  w-1/2  mb-6">

                        <vs-button
                            type="border"
                            @click="[assessmentPopup=false,questionAnswerPopup=true]"

                            size="large" class="w-full h-full">

                            <img class="mx-auto mb-6 block bg-transparent" height="80px" src="/images/lesson_types/literature.png" />

                            <h5 class="mb-2  text-center">Upload a PDF Document</h5>

                        </vs-button>
                    </div>

                </div>





            </div>

        </vs-popup>


        <vs-popup class=""  title="Multiple Choice Quiz Assessment" :active.sync="multipleChoicePopup">



            <div class="subject">

                <div class="mt-3 mb-1">Title.</div>
                <vs-input class="w-full mb-6" :value="quizTitle" />

                <h5>
                   Add the questions and answers below.
                </h5>

<div>
                <vs-card v-for="(question, q_index) in multipleChoiceQuestions" :key="q_index" class="mt-5 mb-10">
                    <div class="vx-row mb-1">

                        <div class="vx-col w-full">
                            <div class="mt-2 mb-3" style="position:relative;">

                                <h5>Question:</h5>

                                    <vs-button v-if="q_index !== 0" color="danger" class="md:block hidden cursor-pointer topright" icon-pack="feather" icon="icon-x" @click.prevent="$delete(multipleChoiceQuestions, q_index)">

                                    </vs-button>




                            </div>
                            <vs-input class="w-full" name="question[]" v-model="question.title" placeholder="Enter the question here" />
                        </div>
                    </div>

                    <vs-divider/>

                    <div class="vx-row mt-1 mb-2">


                        <div class="vx-col  w-8/12">
                            <span class="ml-3">Fill in the options below.</span>

                        </div>
                        <div class="vx-col w-4/12">
                            <span class="ml-3">Select the correct option.</span>
                        </div>

                        <div class="vx-row w-full ml-3" v-for="index in multipleChoiceOptions" :key="index">


                            <div class="vx-col  w-8/12">

                                           <vs-input :placeholder="'Option '+index" :name="'option_'+index+'[]'" v-model="question.options[index]"  class="w-full mt-2" />

                                       </div>

                                       <div class="vx-col w-4/12">
                                           <vs-radio v-model="question.selected" :vs-name="'answer_'+q_index+'[]'" :vs-value="index" class="mt-2">
                                               <vs-button  color="primary" :disabled="question.selected !== index"  :type="question.selected === index?'filled':'border'" class="ml-auto md:block hidden cursor-pointer" @click="question.selected = index">
                                                   Correct
                                               </vs-button>
                                               </vs-radio>
                                       </div>



                        </div>
                    </div>






                </vs-card>
</div>

                <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-5">
                    <vs-col vs-type="flex" vs-w="12">

                        <vs-button  color="primary" class="md:block hidden cursor-pointer" size="large" icon-pack="feather" icon="icon-plus" @click.prevent="multipleChoiceQuestions.push({ 'title':'',
                    selected:null,
                    options:[]
                })">
                        </vs-button>
                        <span class="mt-2 ml-3">
                        Add Another Question
                        </span>
                    </vs-col>
                </vs-row>




            </div>

            <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-5 p-2 rounded-lg border-primary">
                <vs-col vs-type="flex" vs-w="7">


                </vs-col>
                <vs-col vs-type="flex" vs-w="5">
                    <vs-button  color="primary" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="[saveMultipleChoice(1), multipleChoicePopup=false]">
                        Save
                    </vs-button>
                </vs-col>
            </vs-row>

        </vs-popup>

        <vs-popup class=""  title="Question & Answer Assessment" :active.sync="questionAnswerPopup">



            <div class="subject">

                <div class="mt-3 mb-1">Title.</div>
                <vs-input class="w-full mb-6" :value="questionAnswerTitle" />

                <h5>
                    Add the questions and word limit below.
                </h5>

                <div>
                    <vs-card v-for="(question, q_index) in questionAnswerQuestions" :key="q_index" class="mt-5 mb-10">
                        <div class="vx-row mb-1"  style="height: 330px">

                            <div class="vx-col w-full">
                                <div class="mt-2 mb-3">

                                    <h5>Question:</h5>

                                    <vs-button v-if="q_index !== 0" color="danger" class="md:block hidden cursor-pointer topright" icon-pack="feather" icon="icon-x" @click.prevent="$delete(multipleChoiceQuestions, q_index)">

                                    </vs-button>




                                </div>

                                <quill-editor v-model="question.body" style="height: 200px"></quill-editor>

                            </div>
                        </div>





                        <div class="vx-col  w-1/3">
                            <span class="ml-3">0 = Unlimited</span>
                            <vs-input-number v-model="question.wordLimit" label="Word Limit:"/>

                        </div>
                        <div  class="ml-3">
                            <p>Optionally limit the number of words the learner can submit to answer this question.</p>
                        </div>






                    </vs-card>
                </div>

                <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-5">
                    <vs-col vs-type="flex" vs-w="12">

                        <vs-button  color="primary" class="md:block hidden cursor-pointer" size="large" icon-pack="feather" icon="icon-plus" @click.prevent="questionAnswerQuestions.push({ 'body':'',
                    wordLimit:0,
                })">

                        </vs-button>
                        <span class="mt-2 ml-3">
                        Add Another Question
                        </span>
                    </vs-col>
                </vs-row>




            </div>

            <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-5 p-2 rounded-lg border-primary">
                <vs-col vs-type="flex" vs-w="7">


                </vs-col>
                <vs-col vs-type="flex" vs-w="5">
                    <vs-button  color="primary" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="[saveMultipleChoice(2), questionAnswerPopup=false]">
                        Save
                    </vs-button>
                </vs-col>
            </vs-row>

        </vs-popup>


        <vs-popup title="Document Editor" :active.sync="literatureEditorPopup" fullscreen class="nopaddingpopup">

            <div class="p-5">

                <div class="h-auto">

                    <div class="mt-3 mb-1">Title.</div>
                    <vs-input class="w-full mb-6" :value="literatureTitle" v-model="literatureTitle" />



                    <div>



                        <quill-editor v-model="literatureBody"></quill-editor>









                    </div>
                </div>

                <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-10 p-2 rounded-lg border-primary">
                    <vs-col vs-type="flex" vs-w="7">


                    </vs-col>
                    <vs-col vs-type="flex" vs-w="5">
                        <vs-button  color="primary" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="[saveMultipleChoice(3), literatureEditorPopup=false]">
                            Save
                        </vs-button>
                    </vs-col>
                </vs-row>

            </div>
        </vs-popup>


        <vs-popup title="Add From Knowledgebase" :active.sync="knowledgebasePopup" fullscreen class="nopaddingpopup">

            <div class="p-5">


              <knowledge-base/>
                <!--KB-->


            </div>
        </vs-popup>





        <vs-popup title="Video" :active.sync="videoPopup">


            <div>

                <div class="mt-3 mb-1">Title.</div>
                <vs-input class="w-full mb-6" :value="youtubeTitle" v-model="youtubeTitle" />

                <div class="mt-3 mb-1">YouTube URL.</div>
                <vs-input class="w-full mb-6" :value="youtubeURL" v-model="youtubeURL" />

                <iframe width="560" v-if="getYouTubeVideo(youtubeURL)" height="315" :src="'https://www.youtube.com/embed/'+getYouTubeVideo(youtubeURL)" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            </div>

            <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-10 p-2 rounded-lg border-primary">
                <vs-col vs-type="flex" vs-w="7">


                </vs-col>
                <vs-col vs-type="flex" vs-w="5">
                    <vs-button  color="primary" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="[saveMultipleChoice(4), videoPopup=false]">
                        Save
                    </vs-button>
                </vs-col>
            </vs-row>

        </vs-popup>


        <vs-popup title="Audio Recording" :active.sync="audioPopup">


            <div>

                <div class="mt-3 mb-1">Title.</div>
                <vs-input class="w-full mb-6" :value="audioTitle" v-model="audioTitle" />

                <div class="vx-row p-2 mt-5 mb-5 text-dark">



                    <div class="vx-col w-1/5 text-dark">

                        <vs-button color="success" type="relief">
                            <feather-icon icon="MicIcon" svgClasses="h-4 w-4" /><br>
                            On</vs-button></div>


                    <div class="vx-col w-1/5">

                        <vs-button color="success" type="relief" :disabled="{disabled: button_play}">
                            <feather-icon icon="PlayIcon" svgClasses="h-4 w-4" /><br>
                            Play</vs-button></div>




                    <div class="vx-col w-1/5">

                        <vs-button color="danger" type="relief"  @click.prevent="startRecording(button_record)">
                            <feather-icon :icon="button_record? 'PauseIcon' : 'CircleIcon'" svgClasses="h-4 w-4" /><br>
                            {{button_record? 'Pause': 'Record'}}</vs-button>

                    </div>

                    <div class="vx-col w-1/5">

                        <h2 class="w-full mx-5 my-4 text-dark" v-html="studioDuration">{{studioDuration}}</h2>
                    </div>

                    <div class="vx-col w-1/5">
                        <vs-button color="rgba(0,0,0,.9)" type="border" :disabled="{disabled: button_edit}">
                            <feather-icon icon="EditIcon" svgClasses="h-4 w-4" /> <br>Edit
                        </vs-button>
                    </div>

                    <br>



                    <vs-slider class="w-full mx-8 my-8" color="success"/>

                </div>


            </div>

            <vs-row  vs-type="flex" vs-justify="space-between" class="mx-2 mt-10 p-2 rounded-lg border-primary">
                <vs-col vs-type="flex" vs-w="7">


                </vs-col>
                <vs-col vs-type="flex" vs-w="5">
                    <vs-button  color="primary" class="ml-auto md:block hidden cursor-pointer vx-col w-8/12" @click.prevent="[saveMultipleChoice(4), videoPopup=false]">
                        Save
                    </vs-button>
                </vs-col>
            </vs-row>

        </vs-popup>

    </div>
</template>


<script>
    import TextAreaCounter from "../elements/TextAreaCounter";
    import vSelect from 'vue-select'
    import '@google/model-viewer'

    import 'recordrtc'

    let RecordRTC = require("recordrtc");
    let moment = require("moment");

    let recorder

    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'


    import VSwatches from 'vue-swatches'

    // Import the styles too, typically in App.vue or main.js
    import 'vue-swatches/dist/vue-swatches.css'

    import { quillEditor } from 'vue-quill-editor'

    import KnowledgeBase from './KnowledgeBase'

    export default {
        name: "EditLesson",
        components: {
            TextAreaCounter,
            'v-select': vSelect,
            'KnowledgeBase':KnowledgeBase,
            quillEditor,
            VSwatches
            //  'model-viewer': ModelViewerElement,
        },

        computed: {
            activeUserInfo () {
                return this.$store.state.AppActiveUser

            }
        },

        data(){

            return {
                counterDanger: false,
                subjects: [],
                pinText:"",
                themes: [],
                lesson_types: [],
                labelpincolor:"#3398db",
                randominverseColor:null,
                viewer:null,
                hotspotCounter:0,
                hotspotChildren:[],
                selectedHotspot:null,
                ar_objects: [],
                learning_path:null,
                cursorImage: '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="16" height="16"><circle cx="8" cy="8" r="8" style="fill: red;"/></svg>',
                selected_theme_id:1,
                selected_vr_object:null,
                selected_vr_object_active:false,
                arEditorShow:false,
                arLabelShow:false,
                addingPin:false,
                multipleChoicePopup:false,
                questionAnswerTitle:'Q&A Assessment',
                literatureTitle:'Literature',
                quizTitle:'Multiple Choice Quiz',
                youtubeTitle:'Video',
                arTitle:'Augmented Reality',
                audioTitle:'Audio',
                youtubeURL:'',
                literatureBody:'',
                questionAnswerPopup:false,
                literatureEditorPopup:false,
                knowledgebasePopup:false,
                videoPopup:false,
                audioPopup:false,
                wordLimit:0,
                multipleChoiceOptions:4,
                multipleChoiceQuestions: [{ 'title':'',
                    selected:null,
                    options:[]
                }],
                questionAnswerQuestions: [{ 'body':'',
                    wordLimit:0,
                }],
                assessmentPopup:false,
                literaturePopup:false,
                file_blob:null,
                studioDuration:'00:00',
                current_seconds:0,
                button_on:true,
                started_recording:false,
                button_play:false,
                button_stop:false,
                button_record:false,
                button_edit:false,
                itemsPerPage:10,
                selected: [],
                learningpathitems:[],
            }
        },


        created () {

          //  this.labelpincolor = this.getRandomColor();

            console.log("begin read");



            if(this.$route.params.lesson_id !== "new"){

                this.$http.get('/api/lessons/getdetails/'+this.$route.params.lesson_id)
                    .then((response) => { this.learning_path = response.data
                        console.log("OK: "+this.learning_path.id);
                        this.getLearningPathItems()
                    })
                    .catch((error) => { console.log(error) })

            }else{
                this.$http.get('/api/lessons/create')
                    .then((response) => { this.learning_path = response.data
                    })
                    .catch((error) => { console.log(error) })
            }

            this.$http.get('/api/auth/subjects')
                .then((response) => { this.subjects = response.data
                })
                .catch((error) => { console.log(error) })

            this.$http.get('/api/ar_objects')
                .then((response) => { this.ar_objects = response.data
                  //  this.changeSelectedObject(this.ar_objects[0])
                })
                .catch((error) => { console.log(error) })

            this.$http.get('/api/subjects/themes')
                .then((response) => { this.themes = response.data
                })
                .catch((error) => { console.log(error) })

            this.$http.get('/api/lessons/types')
                .then((response) => { this.lesson_types = response.data
                })
                .catch((error) => { console.log(error) })
        },
        methods: {

            invertColor(hex) {
        if (hex.indexOf('#') === 0) {
            hex = hex.slice(1);
        }
        // convert 3-digit hex to 6-digits.
        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        if (hex.length !== 6) {
            throw new Error('Invalid HEX color.');
        }
        // invert color components
        var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
            g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
            b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
        // pad each with zeros and return
        return '#' + this.padZero(r) +this.padZero(g) + this.padZero(b);
    },

     padZero(str, len) {
        len = len || 2;
        var zeros = new Array(len).join('0');
        return (zeros + str).slice(-len);
    },


             getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }


        this.randominverseColor = this.invertColor(color);
        return color;
    },


            initPin(){

                this.addingPin = true;

                var jspath = document.querySelector("body > div.vs-component.con-vs-popup.nopaddingpopup.darktheme.vs-popup-primary.fullscreen > div.vs-popup > div > div > div.vx-col.w-1\\/2.p-0.m-0.h-full > model-viewer").shadowRoot.querySelector("div > div.userInput");


                console.log("url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"16\" height=\"16\"><circle cx=\"8\" cy=\"8\" r=\"8\" style=\"fill: "+this.labelpincolor+";\"/></svg>'), auto");
                jspath.style.cursor = "url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"16\" height=\"16\"><circle cx=\"8\" cy=\"8\" r=\"8\" style=\"fill: "+this.labelpincolor.replace("#","%23")+";\"/></svg>'), auto";
                //url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="16" height="16"><circle cx="8" cy="8" r="8" style="fill: red;"/></svg>'), auto !important;


                //pinText


                        },


/*
            onClick(event) {
                const rect = viewer.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                const positionAndNormal = viewer.positionAndNormalFromPoint(x, y);
                if (positionAndNormal == null) {
                    console.log('no hit result: mouse = ', x, ', ', y);
                    return;
                }
                const { position, normal } = positionAndNormal;
                const hotspot = document.createElement('button');
                hotspot.slot = `hotspot-${hotspotCounter++}`;
                hotspot.classList.add('hotspot');
                hotspot.dataset.position = position.toString();
                if (normal != null) {
                    hotspot.dataset.normal = normal.toString();
                }
                viewer.appendChild(hotspot);
                select(hotspot);
                hotspot.addEventListener('click', () => { select(hotspot); });
                const label = document.createElement('div');
                label.classList.add('annotation');
                label.textContent =
                    'data-position:\r\n' + position + '\r\ndata-normal:\r\n' + normal;
                hotspot.appendChild(label);
                viewer.removeEventListener('click'  , onClick);
            }*/

        refreshHotspotList(viewer=null){
            if(viewer !== null){
    this.hotspotChildren = viewer.children;
/*
            for (let i = 0; i < viewer.children.length; i++) {
                viewer.children[i].classList.remove('selected');

                if(this.filterHotspots(viewer.children[i])){

                    childremArray.push(viewer.children[i]);

                }
            }*/
            }else{
                this.hotspotChildren = [];
            }
            this.$forceUpdate();

            // console.log( this.hotspotChildren[0]);
},
             select(hotspot, viewer) {
        for (let i = 0; i < viewer.children.length; i++) {
            viewer.children[i].classList.remove('selected');
        }

        hotspot.classList.add('selected');
                 this.refreshHotspotList(viewer);
//        this.hotspotChildren = viewer.children;
        this.selectedHotspot = hotspot;
    },


            filterHotspots(hotspot){

              return  hotspot.classList.contains('hotspot');

            },

             clickModel(event) {

                 if(this.addingPin){

                 var viewer = event.target;


                     this.addingPin = false;

                     var jspath = document.querySelector("body > div.vs-component.con-vs-popup.nopaddingpopup.darktheme.vs-popup-primary.fullscreen > div.vs-popup > div > div > div.vx-col.w-1\\/2.p-0.m-0.h-full > model-viewer").shadowRoot.querySelector("div > div.userInput");


                     jspath.style.cursor = "grab";

                     if(this.pinText.length === 0){
                         this.pinText = "#"+(viewer.children.length-1);
                     }

                 const rect = viewer.getBoundingClientRect();
                 const x = event.clientX - rect.left;
                 const y = event.clientY - rect.top;
                 const positionAndNormal = viewer.positionAndNormalFromPoint(x, y);
                 if (positionAndNormal == null) {
                     console.log('no hit result: mouse = ', x, ', ', y);
                     return;
                 }
                 const {position, normal} = positionAndNormal;
                 const hotspot = document.createElement('button');
                 hotspot.slot = `hotspot-${this.hotspotCounter++}`;
                 hotspot.dataset.selectedColour = this.labelpincolor;
                 hotspot.dataset.alltext = this.pinText;

                     hotspot.classList.add('hotspot');
                 hotspot.classList.add('hotspot');

                 hotspot.style.backgroundColor = this.labelpincolor;

                 hotspot.dataset.position = position.toString();
                 if (normal != null) {
                     hotspot.dataset.normal = normal.toString();
                 }
                 viewer.appendChild(hotspot);
                     this.refreshHotspotList(viewer);

                 this.select(hotspot, viewer);
                 hotspot.addEventListener('click', () => {
                     this.select(hotspot, viewer);
                 });
                 const label = document.createElement('div');
                 label.classList.add('hotspot-annotation');
                 label.textContent = this.pinText;
                     this.pinText = "";
                 /*label.textContent =
                     'data-position:\r\n' + position + '\r\ndata-normal:\r\n' + normal;
                 */
                 hotspot.appendChild(label);
                // viewer.removeEventListener('click', onClick);




             }
    },

            getYouTubeVideo(video_url){

                var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
                var match = video_url.match(regExp);
                return (match&&match[7].length==11)? match[7] : false;

            },
            changeSubject(changeTo){

            //    alert(changeTo);
                this.learning_path.learning_path_subject = changeTo

            },
            changeTheme(changeTo){

                this.learning_path.learning_path_theme = changeTo

            },

            getCurrentSubject(){

                var pos =0;
                for(var subject in this.subjects){
                    if(subject.id == this.learning_path.learning_path_subject){
                        return subject
                    }
                    pos++
                }

                return this.subjects[0];

            },

            saveLearningPath(){

                this.$http.post('/api/lessons/update', this.learning_path)
                    .then((response) => { this.learning_path = response.data
                        this.$router.push('/lessons/'+this.learning_path.class).catch(() => {})

                        this.$vs.notify({
                            title:'Saved',
                            text:'The lesson has been successfully saved.',
                            color:'success',
                            iconPack: 'feather',
                            icon:'icon-check'})

                    })



                    .catch((error) => { console.log(error) })

            },

            getTimeAgo(timefrom){
              return moment(timefrom).fromNow();
            },

            getLearningPathItems(){
                this.$http.get('/api/learningpathitems/fetchall/'+this.learning_path.id)
                    .then((response) => { this.learningpathitems = response.data
                    })
                    .catch((error) => { console.log(error) })

            },

            async saveMultipleChoice(assessment_type){

                        var self = this;

                        var data = new FormData()

                if(assessment_type === 4) {
                    data.append('url',
                        JSON.stringify({
                            'url': this.youtubeURL,
                        }))
                }else if(assessment_type === 3) {
                    data.append('body',
                        JSON.stringify({
                            'type': assessment_type,
                            'body': this.literatureBody
                        }))
                }else{
                    data.append('questions', JSON.stringify({
                        'type': assessment_type,
                        'questions': assessment_type === 1 ? this.multipleChoiceQuestions : this.questionAnswerQuestions
                    }))
                }

                    data.append('title', assessment_type === 4 ? this.youtubeTitle: assessment_type === 1 ? this.quizTitle :assessment_type === 2 ? this.questionAnswerTitle: assessment_type === 6? this.arTitle : this.literatureTitle)

                    data.append('learning_path_id', this.learning_path.id)


                        let config = {
                            header : {
                                'Content-Type' : 'multipart/form-data'
                            }
                        }

                        this.$http.post(assessment_type===4?'/api/video_object': assessment_type===3?'/api/literature_object':'/api/assessment_object',data,config)
                            .then((response) => {
                                self.getLearningPathItems()
                                console.log(response.data) })
                            .catch((error) => { console.log(error) })
            },

            async saveAR(){
                var self = this;



                if(recorder !== undefined) {
                    recorder.stopRecording(()=>{
                       let blob = recorder.getBlob()
//                       RecordRTC.invokeSaveAsDialog(blob, 'recording.mp3')
                     //   this.file_blob = blob

                        var data = new FormData()
                        data.append('audio_file', blob, 'recording.webm')
                        data.append('object_file', JSON.parse(self.selected_vr_object.material_item_object).object)
                        data.append('object_image', JSON.parse(self.selected_vr_object.material_item_object).thumb)
                        data.append('object_id', self.selected_vr_object.id)
                        data.append('learning_path_id', this.learning_path.id)


                       // recorder.reset()
                        this.button_record = false
                        this.current_seconds = 0


                        let config = {
                            header : {
                                'Content-Type' : 'multipart/form-data'
                            }
                        }
                        this.$http.post('/api/ar_objects',data,config)
                            .then((response) => {
                                this.arEditorShow = false
                                self.getLearningPathItems()
                                console.log(response.data) })
                            .catch((error) => { console.log(error) })
                    })
                }

                var hotspotholder = [];
                console.log(JSON.stringify(this.hotspotChildren));

                for(let thehotspotChild of this.hotspotChildren){


                   if( thehotspotChild.classList.length > 0 && thehotspotChild.classList.contains('hotspot')) {
                       var hotspot_to_save = {
                           'text': thehotspotChild.dataset.alltext,
                           'colour': thehotspotChild.dataset.selectedColour,
                           'position': thehotspotChild.dataset.position,
                           'normal': thehotspotChild.dataset.normal
                       };
                       hotspotholder.push(hotspot_to_save);
                   }

                }

                var data = new FormData();
                data.append('object_hotspots', JSON.stringify(hotspotholder));
             //   data.append('object_hotspots', JSON.parse(self.selected_vr_object.hotspotholder).object);
                data.append('object_id', self.selected_vr_object.id)
                data.append('learning_path_id', this.learning_path.id)

                this.$http.post('/api/ar_objects',data)
                    .then((response) => {
                        this.arEditorShow = false
                        self.getLearningPathItems()
                        console.log(response.data) })
                    .catch((error) => { console.log(error) })
            },

            changeSelectedObject(newpbject){

                this.selected_vr_object = newpbject;
                this.selected_vr_object_active = true;
                this.refreshHotspotList();
            },


            closeSelectedObject(){

                this.selected_vr_object = null;
                this.selected_vr_object_active = false;
            },




            async startRecording(shouldpause) {

                var self = this;

                function beginprocess(timestamp) {

                    if(current_timestamp !== 0){
                        var duration = (timestamp-current_timestamp) / 1000;

                        var newduration =      moment().startOf('day')
                            .seconds(duration)
                            .format('mm:ss')

                        self.studioDuration = newduration


                       // this.rerender(newduration)

                        //rerender(newduration);

                        // this.render();
                        console.log("BLOW: "+newduration)
                        console.log("TIME IS: "+timestamp+" VS "+current_timestamp)
                    }
                }


                if(shouldpause){
                    recorder.pauseRecording()
                    this.button_record = false
                }else if(recorder !== undefined && self.current_seconds > 0) {
                    recorder.resumeRecording();
                    this.button_record = true;
                }else{


                    //  let recorders = new RecordRTC.RecordRTCPromisesHandler(this.stream, options);
                    var current_timestamp = 0;
                    let stream = await navigator.mediaDevices.getUserMedia({audio: true});
                    recorder =  RecordRTC(stream, {
                        type: 'audio',
                     //   mimeType: 'audio/ogg',
                        mimeType: 'audio/webm',
                        timeSlice: 1000,
                     //   recorderType: RecordRTC.StereoAudioRecorder,
                    //    numberOfAudioChannels:1

                        //  recorderType: RecordRTC.StereoAudioRecorder,
                     //   onTimeStamp: beginprocess,
                    })



                    current_timestamp = Date.now();

                    recorder.startRecording();


                    this.button_record = true;


                    //   const sleep = m => new Promise(r => setTimeout(r, m));
                    //     await sleep(3000);

                    //     await recorder.stopRecording();
                   // let blob = await recorder.getBlob();
                   // RecordRTC.invokeSaveAsDialog(blob, 'recording.webm');

                }

                (function looper() {
                    if(!recorder || !self.button_record) {
                        return;
                    }

                    console.log('Recording Duration: ' + self.current_seconds);

                    var newduration =      moment().startOf('day')
                        .seconds(self.current_seconds)
                        .format('mm:ss')

                    self.studioDuration = newduration

                    self.current_seconds++;

                    setTimeout(looper, 1000);


                })();


            }

        }
    }
</script>


<style lang="scss">



  /*  #shadow-root div.container div.userInput {
        cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="16" height="16"><circle cx="8" cy="8" r="8" style="fill: red;"/></svg>'), auto !important;
    }
*/
    .topright {
        position: absolute;
        top:-30px;
        right:-10px
    }

    .lightgray {
        background: #e0e0e0;
    }

    /*
    .con-input-upload .text-input {
        min-width: 50px;
    }
    .con-img-upload {
        padding: 0;
    }
    .con-input-upload {
        width: 78px;
        height: 78px;
        margin: 0px;
    }

    */
.darktheme    .vs-popup--header {
        background: #1d1d1d;

    }

   .darktheme .vs-popup--title h3 ,.darktheme .vs-popup--close , .darktheme  .vs-con-input .vs-input--icon {
         color: #fff;
     }
  .darktheme   .vs-con-input span.input-span-placeholder {
         color: #868686;
     }
   .darktheme  .vs-con-input input {
         border: 1px solid rgba(0, 0, 0, 0.2);
         background: #2b2b2b;
         color: #fff;
     }

   .nopaddingpopup .vs-popup--content {
        padding: 0;
        margin:0;
        height: 100%;
       max-height: calc(100vh - 70px);
    }


    .style-chooser .vs__search::placeholder,
    .style-chooser .vs__dropdown-toggle,
    .style-chooser .vs__dropdown-menu {
        height: 60px;
        border: 1px solid #5B5B5B;
        color: #394066;
        text-transform: lowercase;
        font-variant: small-caps;
    }

    .style-chooser .vs__clear,
    .style-chooser .vs__open-indicator {
        fill: #394066;
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
