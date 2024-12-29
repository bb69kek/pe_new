<template>
  <div>
    <div class="flex gap-4 text-txt my-8">
        <div class="flex-grow">
            <p class="text-sm mb-2 capitalize">password</p>
            <ui-ipt :type="'password'" v-model="currentPassword" placeholder="password..." />
            <div v-if="errors && errors['current_password']" class="pt-1">
                <p class="text-sm text-acc" 
                    :key="i" v-for="(error, i) in errors['current_password']">{{error}}</p>
            </div>
        </div>
        <div class="flex-grow">
            <p class="text-sm mb-2 capitalize">new password</p>
            <ui-ipt :type="'password'" v-model="new_password" placeholder="new password..." />
            <div v-if="errors && errors['new_password']" class="pt-1">
                <p class="text-sm text-acc" 
                    :key="i" v-for="(error, i) in errors['new_password']">{{error}}</p>
            </div>
        </div>
        <div class="flex-grow">
            <p class="text-sm mb-2 capitalize">confirm new passwod</p>
            <ui-ipt :type="'password'" v-model="new_password_confirmation" placeholder="confirm passwod..." />
        </div>
    </div>
    <div class="flex justify-end">
        <ui-btn @click="save" text="save" :mode="'main'" class="" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';


export default {
    data() {
        return{
            currentPassword: '',
            new_password: '',
            new_password_confirmation: '',
            errors: null
        }
    },
    computed: {
      ...mapGetters(['getUser']),
      user() {
        return this.getUser; 
      },
    },
    methods: {
        async save() {
            await this.$axios.post('/users/changePassword', 
                {current_password: this.currentPassword,
                 new_password: this.new_password,
                 new_password_confirmation: this.new_password_confirmation})
                .then(r => {
                    this.errors = []
                    console.log(r);
                })
                .catch(r => {
                    if(r.response.data) {
                        if(r.response.data.errors) {
                            console.log(r.response.data.errors);
                            this.errors = r.response.data.errors
                        }
                    }
                })
        }
    }
}
</script>

<style>

</style>