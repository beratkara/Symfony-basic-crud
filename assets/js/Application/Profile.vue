<template>
	
    <body class="text-center">
	
	<form @submit.prevent="checkForm" autocomplete="off" >

	  <div v-if="errors.length" class="alert alert-danger" role="alert">Hata : <li v-for="error in errors">{{ error }}</li></div>
	  <div v-if="success.length" class="alert alert-success" role="alert">Başarılı : <li v-for="successdata in success">{{ successdata }}</li></div>
	  
      <h1 class="h3 mb-3 font-weight-normal">Profile</h1>
	  
	  <label for="name" class="sr-only">Name</label>
      <input type="text" id="name" name="name" v-model="name" class="form-control">
	  
	  <label for="surname" class="sr-only">Surname</label>
      <input type="text" id="surname" name="surname" v-model="surname" class="form-control">
	  
	  <label for="email" class="sr-only">Email address</label>
      <input type="text" id="email" name="email" v-model="email" class="form-control" autocomplete="off" readonly="readonly" disable>
	  
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" v-model="password" class="form-control" autocomplete="off">
	  
	  <label for="phone" class="sr-only">Phone</label>
      <input type="phone" id="phone" name="phone" v-model="phone" class="form-control">
	  
	  <button class="btn btn-lg btn-success btn-block" type="submit">Güncelle</button>
	  
    </form>
	
	</body>
</template>

<script>
    export default {
        mounted() {
		
			if(!this.$cookie.get('user'))
			{
				this.$router.push('/login');
				this.$forceUpdate();
				return;
			}

			let token = this.$cookie.get('user');
			
			this.axios.get(
				'/api/getProfile',
				{ headers: { "Authorization": "Bearer " + token } }
			)
			.then(response => {

				let data = response.data;
				if (data[0])
        {
          this.email = data[0].email;
          this.password = null;
          this.phone = data[0].phone;
          this.name = data[0].name;
          this.surname = data[0].surname;
        }
			})
			.catch(error => {
				console.log('Error on Authentication');
				this.$router.push('/login');
				this.$forceUpdate();
			});
			
        },
		data() {
			return {
				errors: [],
				success: [],
				email: null,
				password: null,
				phone: null,
				name: null,
				surname: null
			}
		},
        methods: {
			checkForm: function () {
				console.log({ email: this.email, password: this.password });
				
				this.errors = [];
				this.success = [];

				if (!this.email)
					this.errors.push('Email required.');

				if (!this.errors.length) {
					
					let token = this.$cookie.get('user');

					this.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

					this.axios.post('/api/setProfile', {
						password: this.password,
						phone: this.phone,
						name: this.name,
						surname: this.surname,
					})
					.then(response => {
						console.log(response);
						
						if(response.data.error)
							this.errors.push(response.data.error);
						else
						{
							this.$forceUpdate();
						}
					})
					.catch(function (error) {
						console.log(error);
					});
				}
				
			}
		}
    }
</script>