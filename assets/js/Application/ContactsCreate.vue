<template>
	
    <body class="text-center">
	
	<form @submit.prevent="checkForm" autocomplete="off" >

	  <div v-if="errors.length" class="alert alert-danger" role="alert">Hata : <li v-for="error in errors">{{ error }}</li></div>
	  <div v-if="success.length" class="alert alert-success" role="alert">Başarılı : <li v-for="successdata in success">{{ successdata }}</li></div>
	  
      <h1 class="h3 mb-3 font-weight-normal">Rehber Ekle</h1>
	  
	  <label for="name" class="sr-only">Ad</label>
      <input type="text" id="name" name="name" v-model="name" class="form-control" placeholder="Ad">
	  
	  <label for="surname" class="sr-only">Soyad</label>
      <input type="text" id="surname" name="surname" v-model="surname" class="form-control" placeholder="Soyad">

	  <label for="phone" class="sr-only">Telefon</label>
      <input type="phone" id="phone" name="phone" v-model="phone" class="form-control" placeholder="Telefon">
	  
	  <button class="btn btn-lg btn-success btn-block" type="submit">Ekle</button>
	  
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

          this.contactId = this.$route.params.contactId;

          this.token = this.$cookie.get('user');

        },
        data() {
          return {
            errors: [],
            success: [],
            phone: null,
            name: null,
            surname: null,
            token: null,
          }
        },
        methods: {
          checkForm: function () {
            this.errors = [];
            this.success = [];

            if (!this.name)
              this.errors.push('Name required.');
            if (!this.surname)
              this.errors.push('Surname required.');
            if (!this.phone)
              this.errors.push('Phone required.');

            if (!this.errors.length) {

              this.axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;

              this.axios.post('/api/contacts/store', {
                phone: this.phone,
                name: this.name,
                surname: this.surname,
              })
              .then(response => {
                console.log(response);

                if(response.status !== 200)
                  this.errors.push(response.data.error);
                else
                {
                  this.$router.push('/contacts');
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