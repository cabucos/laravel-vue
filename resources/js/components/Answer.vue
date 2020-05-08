<template>
    <div class="media  post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="Update">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button class="btn btn-outline-primary btn-sm" :disabled="isInvalid">Update</button>
                <button type="button" @click="Cancel" class="btn btn-outline-secondary btn-sm">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div clas="row">
                    <div class="col-sm-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="Edit" class="btn btn-sm btn-outline-info">Edit</a>
                            <button v-if="authorize('modify', answer)" @click.prevent="Destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>

                </div>
                <div class="float-right">
                    <user-info :model="answer" label="Answered"></user-info>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vote from '../components/Vote.vue';
import UserInfo from '../components/UserInfo.vue';
import modification from '../mixins/modification'

export default {
    props: ['answer'],

    mixins:[modification],

    components:{ Vote, UserInfo },

    data(){
        return {
             body: this.answer.body
            ,bodyHtml: this.answer.body_html
            ,id: this.answer.id
            ,questionId: this.answer.question_id
            ,beforeEditCache: null
        }
    },
    methods:{
        setEditCache(){
            this.beforeEditCache = this.body;
        },

        restoreFromCache(){
            this.body = this.beforeEditCache;
        },

        payload(){
            return {
                body: this.body
            };
        },

        delete(){
            axios.delete(this.endpoint)
            .then( (res) => {
                this.$toast.success(res.data.message, "Success", {timeout: 2000});
                this.$emit('deleted')
            });
        }
    },
    computed:{
        isInvalid(){
            return this.body.length < 10;
        },
        endpoint(){
            return `/question/${this.questionId}/answer/${this.id}`;
        }
    },
}
</script>
