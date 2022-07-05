<template>
  <AppLayout :title="$t('Platform users')">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <Link
          :href="route('users.index')"
          class="text-indigo-400 hover:text-indigo-600"
          >{{ $t("Platform users") }}
        </Link>
        /
        {{ form.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Edit form -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-8">
          <form @submit.prevent="submitHandler">
            <div class="flex flex-wrap">
              <!-- Name -->
              <div class="pb-4 w-full">
                <JetLabel for="name" :value="$t('Name')" />
                <JetInput
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="mt-1 block w-full"
                  autocomplete="name"
                  required
                />
                <JetInputError :message="form.errors.name" class="mt-2" />
              </div>

              <!-- Email -->
              <div class="pb-4 w-full">
                <JetLabel for="email" :value="$t('Email')" />
                <JetInput
                  id="email"
                  v-model="form.email"
                  type="text"
                  class="mt-1 block w-full"
                  autocomplete="email"
                  required
                />
                <JetInputError :message="form.errors.email" class="mt-2" />
              </div>
            </div>

            <div class="mt-3 flex items-center">
              <Link
                v-if="$page.props.user.id !== entity.id"
                class="text-red-500"
                type="button"
                @click="destroyHandler"
              >
                {{ $t("Delete") }}
              </Link>
              <JetButton
                class="ml-auto"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                {{ $t("Save") }}
              </JetButton>
            </div>
          </form>
        </div>
        <!-- Change password form -->
        <div
          class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-8"
        >
          <div class="font-bold text-xl mb-4">
            {{ $t("Change password") }}
          </div>
          <form @submit.prevent="changePasswordHandler">
            <div class="flex flex-wrap items-center">
              <span class="w-full md:w-1/2">
                <JetInput
                  id="password"
                  v-model="changePasswordForm.password"
                  type="text"
                  class="w-full"
                  autocomplete="email"
                  required
                />
                <JetInputError
                  :message="changePasswordForm.errors.password"
                  class="mt-2"
                />
              </span>
              <span class="w-full md:w-1/2 mt-7 md:mt-0">
                <JetButton
                  class="ml-0 md:ml-4"
                  :class="{ 'opacity-25': changePasswordForm.processing }"
                  :disabled="changePasswordForm.processing"
                >
                  {{ $t("Save") }}
                </JetButton>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";

export default {
  components: {
    AppLayout,
    Link,
    JetInput,
    JetInputError,
    JetLabel,
    JetButton,
  },
  props: {
    entity: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.entity.name,
        email: this.entity.email,
      }),
      changePasswordForm: this.$inertia.form({
        password: null,
      }),
      translations: {
        delete: this.$t("Are you sure you want to delete this entity"),
      },
    };
  },
  methods: {
    submitHandler() {
      this.form.put(route("users.update", this.entity.id));
    },
    changePasswordHandler() {
      this.changePasswordForm.put(
        route("users.change-password", this.entity.id),
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
