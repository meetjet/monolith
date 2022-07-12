<template>
  <ul
    v-if="show_breadcrumbs"
    class="flex text-2xl md:text-3xl text-slate-800 font-bold Breadcrumbs"
  >
    <li v-for="item in $page.props.breadcrumbs">
      <span v-if="item.is_current_page">{{ item.title }}</span>
      <Link
        v-else
        :href="item.url"
        class="text-indigo-400 hover:text-indigo-600"
        >{{ item.title }}
      </Link>
    </li>
  </ul>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  name: "Breadcrumbs",
  components: {
    Link,
  },
  props: {
    show_breadcrumbs: {
      type: Boolean,
      default: true,
    },
  },
};
</script>

<style scoped lang="postcss">
.Breadcrumbs li:not(:last-child)::after {
  content: "/";
  @apply mx-2 font-normal text-gray-400;
}
</style>
