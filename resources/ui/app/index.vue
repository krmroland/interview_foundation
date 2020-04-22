<template>
  <div>
    <nav class="navbar navbar-dark bg-primary">
      <span class="navbar-brand mb-0 tw-text-2xl tw-font-weight-bold">Starred</span>
      <div v-if="shortName">
        <span class="tw-text-white tw-texl-xl tw-font-bold">{{ shortName }}</span>
      </div>
    </nav>

    <b-container>
      <b-row class="mt-5">
        <b-col md="10" sm="12" class="mx-auto">
          <github-token
            :current-token="user.github_token"
            @update:currentToken="updateToken"
            @delete:currentToken="deleteToken"
          />
          <starred-repositories v-if="user.github_token" />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
export default {
  components: {
    GithubToken: require('./token').default,
    StarredRepositories: require('./starred-repositories').default,
  },
  data: () => ({
    user: window.App.user,
  }),
  computed: {
    shortName() {
      return String(this.user.name).split(' ')[0];
    },
  },
  methods: {
    updateToken(token) {
      this.$set(this.user, 'github_token', token);
    },
    deleteToken() {
      this.$delete(this.user, 'github_token');
    },
  },
};
</script>
