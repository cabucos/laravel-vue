<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="Update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>

                    <hr>

                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <textarea rows="10" v-model="body" class="form-control" required></textarea>
                            </div>
                            <button class="btn btn-outline-primary btn-sm" :disabled="isInvalid">Update</button>
                            <button type="button" @click="Cancel" class="btn btn-outline-secondary btn-sm">Cancel</button>
                        </div>
                    </div>
                </form>
                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title}}</h1>
                            <div class="ml-auto">
                                <a href="/question" class="btn btn-outline-secondary">Back to all Question</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div clas="row">
                                <div class="col-sm-4">
                                    <div class="ml-auto">
                                        <a v-if="authorize('modify', question)" @click.prevent="Edit" class="btn btn-sm btn-outline-info">Edit</a>
                                        <button v-if="authorize('deleteQuestion', question)" @click.prevent="Destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <user-info :model="question" label="Asked"></user-info>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
import modification from '../mixins/modification'


export default {
    props:['question'],

    mixins:[modification],

    components:{ Vote, UserInfo},

    data(){
        return{
             title: this.question.title
            ,body: this.question.body
            ,bodyHtml: this.question.body_html
            ,editing: false
            ,id: this.question.id
            ,beforeEditCache:{}
        }
    },

    computed:{
        isInvalid(){
            return this.body.length < 10 || this.title.length < 10;
        },

        endpoint(){
            return `/question/${this.id}`;
        }
    },

    methods:{
        setEditCache(){
            this.beforeEditCache = {
                 body: this.body
                ,title: this.title
            };
        },

        restoreFromCache(){
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
        },

        payload(){
            return {
                 body: this.body
                ,title: this.title
            };
        },

        delete(){
            axios.delete(this.endpoint)
            .then( ({data}) => {
                this.$toast.success(data.message, "Success",{ timeout: 2000});
            });

            setTimeout(() => {
                window.location.href ="/question";
            }, 3000);
        },


    }
}
</script>
