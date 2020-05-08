
<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="VoteUp" :title="Title('up')"
        :class="classes"
        >
        <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes-count">{{ count }}</span>
        <a @click.prevent="VoteDown" :title="Title('down')"
            :class="classes"
            >
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
        <favorite v-if="name === 'question'" :question="model"></favorite>
        <accept v-else :answer="model"></accept>
    </div>
</template>

<script>
import Favorite from './Favorite.vue';
import Accept from './Accept.vue';
export default {
    props:['name', 'model'],
    computed:{
        classes(){
            return this.signedIn ? '' : 'off';
        },

        endPoint(){
            return `/${this.name}/${this.id}/vote`;
        }
    },

    data(){
        return{
             count: this.model.votes_count || 0
            ,id: this.model.id
        }
    },

    components:{
        Favorite
        ,Accept
    },

    methods:{
        Title(voteType){
            let titles = {
                     up: `This ${this.name} is useful`
                    ,down: `This ${this.name} is not useful`
            };

            return titles[voteType];
        },

        VoteUp(){
            this._Vote(1);
        },

        VoteDown(){
            this._Vote(-1);
        },

        _Vote(vote){
            if(! this.signedIn){
                this.$toast.warning(`Please login tovote ${this.name}`, "Warning",{
                     timeout:3000
                    ,position: 'topRight'
                })
            }
            axios.post(this.endPoint, {vote})
            .then(res => {
                this.$toast.success(res.data.message, "Success", {
                     timeout: 3000
                    ,position: 'topRight'
                });
                this.count = res.data.votesCount;
            })
        }


    }

}
</script>
