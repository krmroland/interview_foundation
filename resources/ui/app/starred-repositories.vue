<template>
  <b-card class="tw-border-none tw-mt-3">
    <b-card-title class="tw-flex tw-items-center tw-justify-between tw-flex-wrap">
      <span>
        <b-icon-star variant="primary" class="tw-text-3xl"></b-icon-star>
      </span>
      <span class="tw-font-bold">STARRED REPOSITORIES</span>
      <b-button
        class="tw-tracking-widest"
        variant="primary"
        @click="fetchRepositories"
        :disabled="isFetching"
      >
        REFRESH
      </b-button>
    </b-card-title>

    <p v-if="!refreshed && !isFetching" class="text-center tw-py-2 tw-text-2xl">
      Click the Refresh button to fetch the starred repositories
    </p>

    <b-table
      striped
      hover
      :items="respositories"
      :fields="fields"
      small
      responsive
      :busy="isFetching"
    >
      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
      <template v-slot:cell(view)="data">
        <a :href="data.item.html_url" class="tw-text-small" target="_blank">details</a>
      </template>
    </b-table>
  </b-card>
</template>
<script>
export default {
  data: () => ({
    respositories: null,
    isFetching: false,
    refreshed: false,
    error: null,
    fields: ['full_name', 'forks', 'view'],
  }),

  methods: {
    fetchRepositories() {
      this.error = null;
      this.isFetching = true;
      this.$http
        .get('auth/starredGithubRepositories')
        .then(({ data }) => {
          this.respositories = data;
        })
        .catch((error) => {
          this.error = 'Something went wrong';
          this.respositories = [];
        })
        .finally(() => {
          this.isFetching = false;
          this.refreshed = true;
        });
    },
  },
};
</script>
