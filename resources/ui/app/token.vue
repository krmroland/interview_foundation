<template>
  <b-card class="tw-border-none text-center">
    <b-row>
      <b-col md="3">
        <b-card-title class="text-center tw-my-3 tw-flex tw-flex-col">
          <span>
            <github-icon class="tw-text-gray-600" />
          </span>
        </b-card-title>
      </b-col>
      <b-col md="9" class="mx-auto">
        <div v-if="notification">
          <b-alert show dismissible :variant="notification.type">
            {{ notification.message }}
          </b-alert>
        </div>
        <div v-if="!currentToken" class="tw-mb-2">
          <p class="tw-text-2xl">
            You haven't added a github token yet.
          </p>
          <p class="tw-text-xl">
            <span> Click</span>
            <a
              href="https://help.github.com/en/github/authenticating-to-github/creating-a-personal-access-token-for-the-command-line"
              class="tw-px-1"
              target="_blank"
            >
              here
            </a>
            <span> to learn how to make token</span>
          </p>
          <b-button
            variant="primary"
            class="tw-uppercase tw-tracking-widest tw-mt-2"
            v-if="!isShowingForm"
            @click="isShowingForm = true"
          >
            Add github token
          </b-button>
        </div>

        <div class="tw-mt-3" v-if="currentToken || isShowingForm">
          <h2 class="tw-text-left tw-mb-3 tw-text-2xl tw-tracking-widest">GITHUB TOKEN</h2>
          <b-form-group class="tw-text-left">
            <b-form-input placeholder="Paste token here" v-model="token"></b-form-input>
          </b-form-group>

          <b-form-group class="tw-text-right">
            <b-button
              variant="primary"
              :disabled="!canSubmit"
              class="tw-mx-1"
              :loading="true"
              @click="submitToken"
            >
              {{ isSubmitting ? '.... processing' : 'SAVE TOKEN' }}
            </b-button>
          </b-form-group>
        </div>
      </b-col>
    </b-row>
  </b-card>
</template>
<script>
export default {
  components: {
    GithubIcon: require('./github.icon').default,
  },
  props: {
    currentToken: { type: String, required: false },
  },
  data() {
    return {
      isShowingForm: false,
      token: this.currentToken,
      isSubmitting: false,
      notification: null,
    };
  },
  computed: {
    canSubmit() {
      // could have used the exact length 40 but I am not sure if the length can vary
      return (
        !this.isSubmitting &&
        this.currentToken !== this.token &&
        (!this.token || String(this.token).length > 10)
      );
    },
  },
  methods: {
    cancel() {
      this.isShowingForm = false;
      this.token = this.currentToken;
    },
    submitToken() {
      this.notification = null;
      this.isSubmitting = true;
      this.$http
        .post('/auth/updateGithubToken', { github_token: this.token })
        .then(() => {
          this.isSubmitting = false;
          this.isShowingForm = false;
          this.notification = { type: 'success', message: 'Token was updated successfully' };
          this.$emit('update:currentToken', this.token);
        })
        .catch(() => {
          this.isSubmitting = false;
          this.notification = { type: 'danger', message: 'Something went wrong, please try again' };
        });
    },
  },
};
</script>
