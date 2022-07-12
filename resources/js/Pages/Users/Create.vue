<template>
  <AppLayout :title="$t('Create user')">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <Link
          :href="route('users.index')"
          class="text-indigo-400 hover:text-indigo-600"
          >{{ $t("Users") }}
        </Link>
        /
        {{ $t("Create") }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
      </div>
    </div>
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
