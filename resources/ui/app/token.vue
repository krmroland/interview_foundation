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
            class="tw-uppercase tw-tracking-widest tw-mt-2 tw-shadow-none"
            v-if="!isShowingForm"
            @click="isShowingForm = true"
          >
            Add github token
          </b-button>
        </div>
        <div v-if="notification">
          <b-alert show dismissible :variant="notification.type">
            {{ notification.message }}
          </b-alert>
        </div>

        <div class="tw-mt-3" v-if="currentToken || isShowingForm">
          <h2 class="tw-text-left tw-mb-3 tw-text-2xl tw-tracking-widest">GITHUB TOKEN</h2>
          <b-form-group>
            <b-input-group>
              <b-form-input
                placeholder="Paste token here"
                class="tw-rounded-none tw-shadow-none"
                v-model="visibleToken"
                :disabled="!isVisible"
              ></b-form-input>
              <template v-slot:append>
                <b-button
                  variant="secondary"
                  class="tw-rounded-none tw-shadow-none"
                  v-if="currentToken"
                  @click="isVisible = !isVisible"
                >
                  <b-icon-eye-slash v-if="isVisible" />
                  <b-icon-eye v-else />
                </b-button>
              </template>
            </b-input-group>
            <div v-if="isVisible" class="tw-text-left">
              <b-button
                variant="link"
                v-if="currentToken"
                class="tw-rounded-none"
                @click="deleteToken"
                :disabled="isBusy"
              >
                <b-spinner small v-if="isDeleting"></b-spinner>
                <span>delete</span>
              </b-button>
              <b-button
                variant="link"
                :disabled="!canSubmit || isBusy"
                class="tw-rounded-none"
                @click="submitToken"
              >
                <b-spinner small v-if="isSaving"></b-spinner>
                <span>save</span>
              </b-button>
            </div>
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
      isSaving: false,
      notification: null,
      isDeleting: false,
      isVisible: !this.currentToken, // we will hide the token if it is available
    };
  },
  computed: {
    canSubmit() {
      // could have used the exact length 40 but I am not sure if the length can vary
      return !this.isSaving && this.currentToken !== this.token && String(this.token).length > 10;
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
    isBusy() {
      return this.isSaving || this.isDeleting;
    },
  },

  methods: {
    cancel() {
      this.isShowingForm = false;
      this.token = this.currentToken;
    },
    submitToken() {
      this.isSaving = true;
      this.$http
        .put('/auth/githubToken', { github_token: this.token })
        .then(() => {
          this.isSaving = false;
          this.isShowingForm = false;
          this.isVisible = false;
          const deletedToken = !this.token;
          this.notification = {
            type: 'success',
            message: 'Token was updated successfully',
          };

          this.$emit('update:currentToken', this.token);
        })
        .catch(() => {
          this.errorNotification();
        })
        .finally(() => {
          this.isSaving = false;
        });
    },
    deleteToken() {
      if (!window.confirm('Delete token?')) {
        return;
      }
      this.isDeleting = true;

      this.$http
        .delete('auth/githubToken')
        .then(() => {
          this.token = null;
          this.notification = { type: 'warning', message: 'Token was removed successfully' };
          this.$emit('delete:currentToken');
        })
        .catch(() => {
          this.errorNotification();
        })
        .finally(() => {
          this.isDeleting = false;
        });
    },
    errorNotification() {
      this.notification = { type: 'danger', message: 'Something went wrong, please try again' };
    },
  },
};
</script>
