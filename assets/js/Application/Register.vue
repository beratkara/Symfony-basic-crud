<template>
	
    <body class="text-center">
	
	<form @submit.prevent="checkForm" autocomplete="off">
      <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
	  
	  <div v-if="errors.length" class="alert alert-danger" role="alert">Hata : <li v-for="error in errors">{{ error }}</li></div>
	  <div v-if="success.length" class="alert alert-success" role="alert">Başarılı : <li v-for="successdata in success">{{ successdata }}</li></div>
	  
      <h1 class="h3 mb-3 font-weight-normal">Register</h1>
	  
	  <label for="name" class="sr-only">Name</label>
      <input type="text" id="name" name="name" v-model="name" class="form-control" placeholder="Name">
	  
	  <label for="surname" class="sr-only">Surname</label>
      <input type="text" id="surname" name="surname" v-model="surname" class="form-control" placeholder="Surname">
	  
	  <label for="email" class="sr-only">Email address</label>
      <input type="text" id="email" name="email" v-model="email" class="form-control" placeholder="Email address" autocomplete="off">
	  
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" v-model="password" class="form-control" placeholder="Password" autocomplete="off">
	  
	  <label for="phone" class="sr-only">Phone</label>
      <input type="phone" id="phone" name="phone" v-model="phone" class="form-control" placeholder="05418264103">
	  
	  <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
	  
    </form>
	
	</body>
</template>

<script>
    export default {
        mounted() {
            console.log('Register..')
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
				
				if (!this.password)
					this.errors.push("Password required.");

				if (!this.email)
					this.errors.push('Email required.');

				if (!this.phone)
					this.errors.push('Phone required.');
					
				if (!this.name)
					this.errors.push('Name required.');
					
				if (!this.surname)
					this.errors.push('Surname required.');


				if (!this.errors.length) {
					
					this.axios.post('/api/register', {
						email: this.email,
						password: this.password,
						name: this.name,
						surname: this.surname,
            phone: this.phone,
					})
					.then(response => {
						console.log(response);

						if(response.status !== 200)
							this.errors.push("Hesap Oluşturulamadı !");
						else
							this.success.push(response.success);
					})
					.catch(function (error) {
						console.log(error);
					});
				}
				
			}
		}
    }
</script>