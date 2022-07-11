<template>
  <header class="sticky top-0 bg-white border-b border-slate-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 -mb-px">
        <!-- Header: Left side -->
        <div class="flex">
          <!-- Hamburger button -->
          <button
            class="text-slate-500 hover:text-slate-600 lg:hidden"
            @click.stop="$emit('toggle-sidebar')"
            aria-controls="sidebar"
            :aria-expanded="sidebarOpen"
          >
            <span class="sr-only">Open sidebar</span>
            <v-icon class="mr-4" name="ri-menu-2-line" />
          </button>
        </div>

        <!-- Header: Right side -->
        <div class="flex items-center space-x-3">
          <div class="ml-3 relative">
            <!-- Teams Dropdown -->
            <JetDropdown
              v-if="
                $page.props.jetstream.hasTeamFeatures &&
                $page.props.user.current_team
              "
              align="right"
              width="60"
            >
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition"
                  >
                    {{ $page.props.user.current_team.name }}

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <div class="w-60">
                  <!-- Team Management -->
                  <template
                    v-if="
                      $page.props.jetstream.hasTeamFeatures &&
                      $page.props.user.current_team
                    "
                  >
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      {{ $t("Manage Team") }}
                    </div>

                    <!-- Team Settings -->
                    <JetDropdownLink
                      :href="route('teams.show', $page.props.user.current_team)"
                    >
                      {{ $t("Team Settings") }}
                    </JetDropdownLink>

                    <JetDropdownLink
                      v-if="$page.props.jetstream.canCreateTeams"
                      :href="route('teams.create')"
                    >
                      {{ $t("Create New Team") }}
                    </JetDropdownLink>

                    <div class="border-t border-gray-100" />

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      {{ $t("Switch Teams") }}
                    </div>

                    <template
                      v-for="team in $page.props.user.all_teams"
                      :key="team.id"
                    >
                      <form @submit.prevent="switchToTeam(team)">
                        <JetDropdownLink as="button">
                          <div class="flex items-center">
                            <svg
                              v-if="team.id == $page.props.user.current_team_id"
                              class="mr-2 h-5 w-5 text-green-400"
                              fill="none"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              stroke="currentColor"
                              viewBox="0 0 24 24"
                            >
                              <path
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                              />
                            </svg>
                            <div>{{ team.name }}</div>
                          </div>
                        </JetDropdownLink>
                      </form>
                    </template>
                  </template>
                </div>
              </template>
            </JetDropdown>
          </div>

          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <JetDropdown align="right" width="48">
              <template #trigger>
                <button
                  v-if="$page.props.jetstream.managesProfilePhotos"
                  class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                >
                  <img
                    class="h-8 w-8 rounded-full object-cover"
                    :src="$page.props.user.profile_photo_url"
                    :alt="$page.props.user.name"
                  />
                </button>

                <span v-else class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"
                  >
                    {{ $page.props.user.name }}

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ $t("Manage Account") }}
                </div>

                <JetDropdownLink :href="route('profile.show')">
                  {{ $t("Profile") }}
                </JetDropdownLink>

                <JetDropdownLink
                  v-if="$page.props.jetstream.hasApiFeatures"
                  :href="route('api-tokens.index')"
                >
                  {{ $t("API Tokens") }}
                </JetDropdownLink>

                <div class="border-t border-gray-100" />

                <!-- Authentication -->
                <form @submit.prevent="logout">
                  <JetDropdownLink as="button">{{
                    $t("Log Out")
                  }}</JetDropdownLink>
                </form>
              </template>
            </JetDropdown>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { ref } from "vue";

import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "Header",
  props: ["sidebarOpen"],
  components: {
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
  },
  setup() {
    const searchModalOpen = ref(false);
    const logout = () => {
      Inertia.post(route("logout"));
    };
    return {
      searchModalOpen,
      logout,
    };
  },
};
</script>
