<template>
  <v-app>
    <router-view></router-view>
  </v-app>
</template>

<script>

export default {
  name: 'app',
  components: { },
  data () {
    return {
    }
  },
  methods: {
  }
}
</script>

<style lang="scss">
  @import "./scss/navigation.scss";
  @import "./scss/welcome.scss";
  @import "./scss/login.scss";
</style>
