<template>
	<div class="container-fluid">
		<Header />
		<router-view></router-view>
	</div>
</template>

<script>

import Header from "./Header.vue"

export default {
	components : {
		Header
	}
}

</script>