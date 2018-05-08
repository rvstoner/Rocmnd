<template>
  <div>
      <li v-for="user in users">

        <user-detail :user="user">
        </user-detail>
        
      </li>
    
  </div>
</template>

<script>
  export default {
    props: {
      users: Array
    },
    data() {
      return {
        
      }
    }
  }

</script>

