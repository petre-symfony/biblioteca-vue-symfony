<template>
  <li :class="[$style.component, 'node-tree']">
    <span v-if="node.t_e_x_t" class="label">{{ node.t_e_x_t }}</span>

    <ul v-if="node.children && node.children.length">
      <node
          v-for="(child, index) in node.children"
          :key=index
          :node="child"
      ></node>
    </ul>
  </li>
</template>

<script>
export default {
  name: "node",
  props: {
    node: {
      type: Object,
      required: true
    }
  },
  mounted() {
    if (this.node.children && this.node.children.length) {
      this.$el.classList.add('caret')
    }
  }
}
</script>

<style lang="scss" module>
  .component {

  }
</style>