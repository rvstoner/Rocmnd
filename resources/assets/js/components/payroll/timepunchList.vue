<template>
  <div>
      <li v-for="timepunch in timepunches">

        <timepunch-detail :timepunch="timepunch">
        </timepunch-detail>
        
      </li>
    
  </div>
</template>

<script>
  export default {
    props: {
      timepunches: Array
    },
    data() {
      return {
        
      }
    }
  }

</script>