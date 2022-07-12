<template>
  <app-layout :title="$t('Users')">
    <template #content>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Edit form -->
        <page-section>
          <Form @submit.prevent="editHandler" v-model="editForm">
            <!-- Name -->
            <Input
              name="name"
              :label="$t('Name')"
              autocomplete="name"
              required
            />
            <!-- Email -->
            <Input
              name="email"
              :label="$t('Email')"
              autocomplete="email"
              required
            />
            <Submit :label="$t('Save')" />
          </Form>
        </page-section>
        <!-- Change password form -->
        <PageSection :title="$t('Change password')">
          <Form
            @submit.prevent="changePasswordHandler"
            v-model="changePasswordForm"
          >
            <Input
              name="password"
              :label="$t('Password')"
              autocomplete="password"
              required
            />
            <Submit :label="$t('Save')" />
          </Form>
        </PageSection>
        <!-- Delete form -->
        <PageSection v-if="$page.props.user.id !== entity.id">
          <Link class="text-red-500" type="button" @click="destroyHandler">{{
            $t("Delete")
          }}</Link>
        </PageSection>
      </div>
    </template>
  </app-layout>
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
  props: {
    entity: Object,
  },
  data() {
    return {
      editForm: useForm({
        name: this.entity.name,
        email: this.entity.email,
      }),
      changePasswordForm: useForm({
        password: null,
      }),
      translations: {
        delete: this.$t("Are you sure you want to delete this entity"),
      },
    };
  },
  methods: {
    editHandler() {
      this.editForm.put(this.route("users.update", this.entity.id));
    },
    changePasswordHandler() {
      this.changePasswordForm.put(
        this.route("users.change-password", this.entity.id),
        {
          onSuccess: () => this.changePasswordForm.reset(),
        }
      );
    },
    destroyHandler() {
      if (confirm(`${this.translations.delete}?`)) {
        this.$inertia.delete(this.route("users.destroy", this.entity.id));
      }
    },
  },
};
</script>

<style scoped></style>
