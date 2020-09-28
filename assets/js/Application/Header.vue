<template>

	<nav class="navbar navbar-light bg-light">
	
		<li class="navbar-brand">
			<span v-if="$cookie.get('user')">
				<router-link class="navbar-brand" to="/profile" tag="a">Profile</router-link>
				<router-link class="navbar-brand" to="/contacts" tag="a">Contacts</router-link>
        <router-link class="navbar-brand" to="#" @click.native.stop="logout">Log out</router-link>
			</span>
			<span v-else>
				<router-link class="navbar-brand" to="/login" tag="a">Login</router-link>
				<router-link class="navbar-brand" to="/register" tag="a">Register</router-link>
			</span>  
		</li>
	
	</nav>

</template>

<script>
export default {
	methods: {
		logout: function () {

			let token = this.$cookie.get('user');
			
			this.axios.get(
				'/api/logout',
				{ headers: { "Authorization": "Bearer " + token } }
			)
			.then(response => {
			
			})
			.catch(error => {
				console.log('Error Logout');
			});
		
			this.$cookie.delete('user');
			this.$router.push('/login');
			this.$forceUpdate();
		}
	}
}
</script>