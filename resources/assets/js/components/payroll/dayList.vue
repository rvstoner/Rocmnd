<template>
  <div>
      <li v-for="day in days">

        <day-detail :day="day">
        </day-detail>
        
      </li>
    
  </div>
</template>

<script>
  export default {
    props: {
      days: Array
    },
    data() {
      return {
        
      }
    }
  }

</script>