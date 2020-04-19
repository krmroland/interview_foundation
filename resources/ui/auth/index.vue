<template>
  <b-container>
    <b-row class="mt-5">
      <b-col md="5" sm="6" xs="12" class="mx-auto">
        <b-card>
          <b-card-title>
            Authentication
          </b-card-title>
          <b-tabs card fill>
            <b-tab title="Login" active lazy>
              <b-card-text>Login</b-card-text>
            </b-tab>
            <b-tab title="Register" lazy>
              <registration-component />
            </b-tab>
          </b-tabs>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
export default {
  components: {
    RegistrationComponent: require('./registration').default,
  },
};
</script>
