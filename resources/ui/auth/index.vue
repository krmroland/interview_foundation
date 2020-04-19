<template>
  <b-container>
    <b-row class="mt-5">
      <b-col md="5" sm="6" xs="12" class="mx-auto">
        <component :is="activeComponent" :login="login" :register="register" />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
export default {
  data: () => ({
    activeComponent: 'login-component',
  }),
  components: {
    RegistrationComponent: require('./registration').default,
    LoginComponent: require('./login').default,
  },
  methods: {
    login() {
      this.activeComponent = 'login-component';
    },
    register() {
      this.activeComponent = 'registration-component';
    },
  },
};
</script>
