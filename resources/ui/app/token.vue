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

    <b-button
      variant="primary"
      class="tw-uppercase tw-tracking-widest"
      v-if="!isShowingForm"
      @click="isShowingForm = true"
    >
      Add github token
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
            {{ isSubmitting ? '.... processing' : 'ADD TOKEN' }}
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
      this.isSubmitting = true;
    },
  },
};
</script>
