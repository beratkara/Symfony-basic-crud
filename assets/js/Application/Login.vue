<template>
	
    <body class="text-center">
	
	<form @submit.prevent="checkForm">
      <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
	  
	  <div v-if="errors.length" class="alert alert-danger" role="alert">Hata : <li v-for="error in errors">{{ error }}</li></div>
	  
      <h1 class="h3 mb-3 font-weight-normal">Login</h1>
      <label for="email" class="sr-only">Email address</label>
      <input type="text" id="email" name="email" v-model="email" class="form-control" placeholder="Email address" autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" v-model="password" class="form-control" placeholder="Password">
	  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	  
    </form>
	
	</body>
</template>

<script>
    export default {
        mounted() {
            console.log('Login..')
        },
		data() {
			return {
				errors: [],
				email: null,
				password: null
			}
		},
        methods: {
			checkForm: function () {
				console.log({ email: this.email, password: this.password });
				
				this.errors = [];
				
				if (!this.password) {
					this.errors.push("Password required.");
				}
				if (!this.email) {
					this.errors.push('Email required.');
				}

				if (!this.errors.length) {
					
					this.axios.post('/api/login_check', {
						username: this.email,
						password: this.password
					})
					.then(response => {

            let data = response.data;

						if(data.code)
							this.errors.push(data.message)
						else if(data.token)
						{
							this.$cookie.set('user', data.token, { expires: '10m' });
							this.$router.push('/profile');
							location.reload();
						}
						else
							this.errors.push('Api Hatası.');
					
					})
					.catch(function (error) {
						console.log(error);
					});
				}
			}
		}
    }
</script>