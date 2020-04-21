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
          <b-form-group>
            <b-input-group>
              <b-form-input
                placeholder="Paste token here"
                class="tw-rounded-none"
                v-model="visibleToken"
                :disabled="!isVisible"
              ></b-form-input>
              <template v-slot:append>
                <b-button
                  variant="outline-info"
                  class="tw-rounded-none"
                  v-if="currentToken"
                  @click="isVisible = !isVisible"
                >
                  <b-icon-eye-slash v-if="isVisible" />
                  <b-icon-eye v-else />
                </b-button>
              </template>
            </b-input-group>
          </b-form-group>

          <b-form-group v-if="isVisible" class="tw-text-left">
            <b-button
              variant="primary"
              :disabled="!canSubmit"
              class="tw-rounded-none"
              :loading="true"
              @click="submitToken"
            >
              <b-spinner small v-if="isSubmitting"></b-spinner>
              <span>SAVE TOKEN</span>
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
      isVisible: !this.currentToken, // we will hide the token if it is available
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
    maskedToken() {
      return String('*').repeat(20);
    },
    visibleToken: {
      get() {
        return this.isVisible ? this.token : this.maskedToken;
      },
      set(value) {
        this.token = value;
      },
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
          this.isVisible = false;
          const deletedToken = !this.token;
          this.notification = {
            type: deletedToken ? 'warning' : 'success',
            message: deletedToken
              ? 'Token was removed successfully'
              : 'Token was updated successfully',
          };
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
