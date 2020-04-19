<template>
  <b-card class="tw-border-none">
    <b-card-title class="text-center tw-my-3 tw-flex tw-flex-col">
      <span>
        <b-icon-shield-lock variant="primary" class="tw-text-6xl"></b-icon-shield-lock>
      </span>
      <span class="tw-mt-2 tw-text-2xl tw-font-bold">
        Login
      </span>
    </b-card-title>
    <b-form @submit.prevent="form.post('auth/login', { onSuccess })">
      <b-form-group label="Email address:">
        <b-form-input
          type="email"
          required
          placeholder="Enter email"
          v-model="form.fields.email"
          :state="form.errorState('email')"
        ></b-form-input>
        <b-form-invalid-feedback v-text="form.errors.email"></b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Password:">
        <b-form-input
          required
          type="password"
          placeholder="password"
          v-model="form.fields.password"
          :state="form.errorState('password')"
        ></b-form-input>
        <b-form-invalid-feedback v-text="form.errors.password"></b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="tw-mt-5 sm:tw-mt-10">
        <b-button block variant="primary" type="submit" :disabled="form.loading.value">
          Login
        </b-button>
      </b-form-group>
    </b-form>

    <p class="tw-text-right tw-px-2 tw-mt-5 md:tw-mt-10">
      Don't have an account already? Goto
      <b-button variant="link" @click.prevent="register">Register</b-button>
    </p>
  </b-card>
</template>
<script>
import { useForm } from '@/services/forms';
export default {
  props: {
    register: Function,
  },
  setup() {
    return { form: useForm({}) };
  },
  methods: {
    onSuccess() {
      window.location.reload();
    },
  },
};
</script>
