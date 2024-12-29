<template>
  <div class="bg-fbg capitalize text-txt h-[100vh] w-[100vw] flex flex-col gap-3 items-center justify-center">
    <div class="my-3 flex gap-8 items-center">
        <p :class="`${mode == 'login' ? 'text-acc' : ''}`" @click="mode = 'login'">Login</p>
        <p :class="`${mode == 'register' ? 'text-acc' : ''}`" @click="mode = 'register' ">Register</p>
    </div>

    <div v-if="mode == 'register'">
        <p :class="`${type == 'contributer' ? 'text-acc' : ''}`" @click="type = 'contributer'">contributer</p>
        <p :class="`${type == 'customer' ? 'text-acc' : ''}`" @click="type = 'customer' ">customer</p>
    </div>
    <div class="flex items-center gap-3">
        <p>username: </p>
        <ui-ipt v-model="username" />
    </div>
    <div v-if="mode == 'register'" class="flex items-center gap-3">
        <p>email: </p>
        <ui-ipt v-model="email" />
    </div>
    <div v-if="mode == 'register'" class="flex items-center gap-3">
        <p>full name: </p>
        <ui-ipt v-model="name" />
    </div>
    <div class="flex items-center gap-3">
        <p>password: </p>
        <ui-ipt v-model="password" />
    </div>
    <div v-if="mode == 'register'" class="flex items-center gap-3">
        <p>confirm password: </p>
        <ui-ipt v-model="password2" />
    </div>

    <ui-btn :text="mode" @click="doAuth" />

    <div v-if="mode == 'login'" class="flex items-center gap-6 my-4">
        <p @click="loginCustomer">customer</p>
        <p @click="loginContributer">contributer</p>
    </div>
  </div>
</template>

<script>

export default {
    emits: ['login'],
    data() {
        return{
            mode: 'login',
            username: 'customer',
            name: 'a',
            password: 'password',
            password2: 'password',
            email: 'a@a.com',
            type: 'contributer'
        }
    },
    methods: {
        async doAuth() {
            if(this.mode == 'login') {
                await this.$axios.post('/login', {
                    username: this.username,
                    password: this.password, 
                }).then(async r => {
                    console.log(r);
                    if(r.status == 200) {
                        let dt = r.data
                        console.log(dt);
                        if(dt.token && dt.user) {
                            let user = dt.user
                            user.token = dt.token
                            this.$emit('login', user)
                        }
                    }

                })
            }
            if(this.mode == 'register') {
                await this.$axios.post('/register', {
                    name: this.name,
                    username: this.username,
                    password: this.password, 
                    password_confirmation: this.password2,
                    email: this.email,
                    role: this.type
                }).then(r => {
                    console.log(r);
                })
            }
        },
        loginCustomer() {
            this.username = 'customer'
            this.password = 'password'
            this.doAuth()
        },
        loginContributer() {
            this.username = 'contributer'
            this.password = 'password'
            this.doAuth()
        }
    }
}
</script>

