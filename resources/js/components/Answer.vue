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
export default {
    props: ['answer'],

    data(){
        return {
             editing: false
            ,body: this.answer.body
            ,bodyHtml: this.answer.body_html
            ,id: this.answer.id
            ,questionId: this.answer.question_id
            ,beforeEditCache: null
        }
    },
    methods:{
        Edit(){
            this.beforeEditCache = this.body;
            this.editing = true;
        },

        Cancel(){
            this.body = this.beforeEditCache;
            this.editing = false;
        },

        Update(){
            axios.patch(this.endpoint,{
                body: this.body
            })
            .then(res =>{
                // console.log(res);
                this.editing = false;
                this.bodyHtml = res.data.body_html
                this.$toast.success(res.data.message, "Success", { timeout: 3000});
            })
            .catch( err =>{
                this.$toast.error(res.data.message, "Success", { timeout: 3000});
            });

        },
        Destroy(){
            this.$toast.question('Are you sure about that ?', 'Confirm', {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {
                        axios.delete(this.endpoint)
                        .then( res => {
                            $(this.$el).fadeOut(500, () => {
                                this.$toast.success(res.data.message, "Success", { timeout: 3000});
                            })
                        });
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        },
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
