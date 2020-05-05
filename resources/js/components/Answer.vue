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
            })
            .catch( err =>{
                console.log(err.response.data.message);
            });

        },
        Destroy(){
            if(confirm('Are you sure ?')){
                axios.delete(this.endpoint)
                .then( res => {
                    $(this.$el).fadeOut(500, () => {
                        alert(res.data.message);
                    })
                });
            }
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
