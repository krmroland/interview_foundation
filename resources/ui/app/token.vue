<template>
  <div>
    <div v-if="!currentToken">
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
    </div>

    <div class="tw-w-full md:tw-w-2/3 tw-mx-auto" v-if="notification">
      <b-alert show dismissible :variant="notification.type">
        {{ notification.message }}
      </b-alert>
    </div>

    <b-button
      :variant="currentToken ? 'light' : 'primary'"
      class="tw-uppercase tw-tracking-widest"
      v-if="!isShowingForm"
      @click="isShowingForm = true"
    >
      {{ currentToken ? 'Update Token' : 'Add github token' }}
    </b-button>

    <b-row class="mt-5" v-else>
      <b-col md="6" sm="10" class="mx-auto">
        <b-form-group label="Github token" class="tw-text-left">
          <b-form-input placeholder="Paste token here" v-model="token"></b-form-input>
        </b-form-group>
        <hr />
        <b-form-group class="tw-text-right">
          <b-button variant="light" @click.prevent="cancel" :disabled="isSubmitting">
            CANCEL
          </b-button>
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
      </b-col>
    </b-row>
  </div>
</template>
<script>
export default {
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
