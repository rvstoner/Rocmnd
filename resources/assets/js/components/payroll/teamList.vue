<template>
<aside class="menu">
  <template v-for="team in teams">
    <p class="menu-label">
      {{ team.display_name }}
    </p>
    
    <ul class="menu-list">
      <user-list
        :users="team.users"
      ></user-list>
    </ul>
  </template>
</aside>
</template>

<script>
  export default {
    props: {
      teams: Array
    },
    data() {
      return {
      
      }
    }
    
  }

</script>

<style scoped>
  
</style>