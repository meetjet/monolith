<template>
  <AppLayout :title="$t('Create user')">
    <template #content>
      <page-section>
        <Form @submit.prevent="submitHandler" v-model="form">
          <!-- Name -->
          <Input
            name="name"
            :label="$t('Name')"
            autocomplete="name"
            autofocus
            required
          />
          <!-- Email -->
          <Input
            name="email"
            :label="$t('Email')"
            autocomplete="email"
            required
          />
          <!-- Password -->
          <Input
            name="password"
            :label="$t('Password')"
            autocomplete="password"
            required
          />
          <Submit :label="$t('Create')" />
        </Form>
      </page-section>
    </template>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PageSection from "@/Shared/PageSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import {
  Form,
  Input,
  Submit,
} from "@protonemedia/form-components-pro-vue3-tailwind3-simple";

export default {
  components: {
    AppLayout,
    PageSection,
    Link,
    Form,
    Input,
    Submit,
  },
  data() {
    return {
      form: useForm({
        name: null,
        email: null,
        password: null,
      }),
    };
  },
  methods: {
    submitHandler() {
      this.form.post(this.route("users.store"));
    },
  },
};
</script>

<style scoped></style>
