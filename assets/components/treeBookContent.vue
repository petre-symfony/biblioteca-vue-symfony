<template>
  <div :class="[$style.component, 'tree']">
    <ul>
      <node-tree :node="treeData"></node-tree>
    </ul>
  </div>
</template>

<script>
import NodeTree from './nodeTreeBookContent'

export default {
  name: "Tree",
  components: {
    NodeTree,
  },
  props: {
    treeData: {
      type: Object,
      required: true
    }
  },
  mounted() {
    this.$el.querySelectorAll('.caret .caret').forEach(el => {
      el.addEventListener('click', (event) => {
        event.stopPropagation()
        if (el.classList.contains('caret')){
          el.classList.remove('caret')
          el.classList.add('caret-down')
        } else if (el.classList.contains('caret-down')){
          el.classList.remove('caret-down')
          el.classList.add('caret')
        }
      }, false)
    })
  }
}
</script>

<style lang="scss" module>
.component :global {
  ul:nth-child(1) {
    padding-left: 0;
    margin: 0;
  }

  ul {
    padding-left: 16px;
    margin: 6px 0;
    list-style: none;
  }

  .caret .caret-down::before {
    content: "\25BC";
    color: black;
    display: inline-block;
    margin-right: 6px;
  }

  .caret .caret::before {
    content: "\25B6";
    color: black;
    display: inline-block;
    margin-right: 6px;
  }

  .caret .caret>ul {
    display: none;
  }
}
</style>