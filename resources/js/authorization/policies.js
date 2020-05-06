
export default{
    modify(user, model){
        return user.id === model.user_id;
    },

    accept(user, answer){
        return user.id === answer.question.usr_id;
    }
}
