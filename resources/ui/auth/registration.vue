<template>
  <b-card class="tw-border-none">
    <b-card-title class="text-center tw-my-3 tw-flex tw-flex-col">
      <span>
        <b-icon-shield-lock variant="primary" class="tw-text-6xl"></b-icon-shield-lock>
      </span>
      <span class="tw-mt-2 tw-text-2xl tw-font-bold">
        Registration
      </span>
    </b-card-title>
    <b-form>
      <b-form-group label="Name:">
        <b-form-input required placeholder="Enter name"></b-form-input>
      </b-form-group>

      <b-form-group label="Email address:">
        <b-form-input type="email" required placeholder="Enter email"></b-form-input>
      </b-form-group>

      <b-form-group label="Password:">
        <b-form-input type="password" required placeholder="password"></b-form-input>
      </b-form-group>

      <b-form-group class="tw-mt-5 sm:tw-mt-10">
        <b-button block variant="primary">
          Register
        </b-button>
      </b-form-group>
    </b-form>
  </b-card>
</template>
<script></script>
