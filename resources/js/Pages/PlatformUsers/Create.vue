<template>
  <AppLayout :title="$t('Create user')">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <Link
          :href="route('users.index')"
          class="text-indigo-400 hover:text-indigo-600"
          >{{ $t("Platform users") }}
        </Link>
        /
        {{ $t("Create") }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

              <!-- Password -->
              <div class="pb-4 w-full">
                <JetLabel for="password" :value="$t('Password')" />
                <JetInput
                  id="password"
                  v-model="form.password"
                  type="text"
                  class="mt-1 block w-full"
                  autocomplete="password"
                  required
                />
                <JetInputError :message="form.errors.password" class="mt-2" />
              </div>
            </div>

            <JetButton
              class="mt-3"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              {{ $t("Create") }}
            </JetButton>
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
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        email: null,
        password: null,
      }),
    };
  },
  methods: {
    submitHandler() {
      this.form.post(route("users.store"));
    },
  },
};
</script>

<style scoped></style>
