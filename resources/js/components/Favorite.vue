<template>
    <a title="Click to mark as favorite question  (Click again to undo)"
        :class="Classes" @click.prevent="Toggle">
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>
</template>
<script>

export default {
    props: ['question'],

    data(){
        return {
            isFavorited: this.question.is_favorited
            ,count: this.question.favorites_count
            ,id: this.question.id
        }

    },
    computed: {
        Classes(){
            return[
                'favorite', 'mt-2',
                ! this.signedIn ? 'off': (this.isFavorited ? 'favorited':'')
            ]
        },

        endpoint(){
            return `/question/${ this.id }/favorites`;
        },

        signedIn(){
            return window.Auth.signedIn;
        }

    },

    methods:{
        Toggle(){
            if( ! this.signedIn){
                this.$toast.warning("Please login to favorite this question", "Warning", {
                     timeout: 3000
                    ,position: 'topRight'
                });
                return;
            }
            this.isFavorited ? this.Destroy() : this.Create();
        },

        Destroy(){
            axios.delete(this.endpoint)
            .then(res =>{
                this.count --;
                this.isFavorited = false;
            });
        },

        Create(){
            axios.post(this.endpoint)
            .then(res =>{
                this.count++;
                this.isFavorited = true;
            })
        }
    }
}
</script>
