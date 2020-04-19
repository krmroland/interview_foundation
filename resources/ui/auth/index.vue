<template>
  <b-container>
    <b-row class="mt-5">
      <b-col md="5" sm="6" xs="12" class="mx-auto">
        <component :is="activeComponent" />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
export default {
  data: () => ({
    activeComponent: 'registration-component',
  }),
  components: {
    RegistrationComponent: require('./registration').default,
  },
};
</script>
