<template>
  <table class="table">
    <router-link :to="{ name: 'contacts-create' }" class="btn btn-sm btn-success">
      <span>Oluştur</span>
    </router-link>
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ad</th>
      <th scope="col">Soyad</th>
      <th scope="col">Telefon</th>
      <th scope="col" style="width: 250px">İşlemler</th>
    </tr>
    </thead>
    <tbody>
    <template v-for="(item, index) in users">
      <tr>
        <th scope="row">{{ (index+1) }}</th>
        <td>{{ item.name }}</td>
        <td>{{ item.surname }}</td>
        <td>{{ item.phone }}</td>
        <td>
          <router-link :to="{ name: 'contacts-edit', params: { contactId: item.id } }" class="btn btn-sm btn-dark">
            <span>Düzenle</span>
          </router-link>
          <router-link to="#" @click.native.stop="removeContact(item.id)" class="btn btn-sm btn-danger">
            <span>Sil</span>
          </router-link>
        </td>
      </tr>
    </template>
    </tbody>
  </table>

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

          this.token = this.$cookie.get('user');

          this.getContacts();
        },
		    data() {
			    return {
              users: null,
              token: null,
			    }
		    },
        methods: {
          getContacts: function ()
          {
            this.axios.get(
                '/api/contacts/',
                { headers: { "Authorization": "Bearer " + this.token } }
            )
                .then(response => {
                  this.users = response.data;
                  console.log(this.users)
                })
                .catch(error => {

                });
          },
          async removeContact(id)
          {
            let token = this.$cookie.get('user');

            await this.axios.delete(
                '/api/contacts/delete/' + id,
                { headers: { "Authorization": "Bearer " + token } }
            );

            this.getContacts();
          }
		    }
    }
</script>