<template>
  <div>
      <li v-for="week in weeks">

        <week-detail :week="week">
        </week-detail>
        
      </li>
    
  </div>
</template>

<script>
  export default {
    props: {
      weeks: Array
    },
    data() {
      return {
        
      }
    }
  }

</script>

