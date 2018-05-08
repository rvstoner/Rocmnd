<template>
	<div>
		
			<div class="columns">
        <div class="column is-narrow">
          {{ timepunch.reason }}
        </div>
        <div class="column is-narrow">
          Shift: {{ timepunch.readableRollover }}
        </div>
			  <div class="column">
			    {{ timepunch.start }} to {{ timepunch.end }}
			  </div>
			  <div class="column is-narrow">
			    Edited: {{ timepunch.readableOvertime }}
			  </div>
			</div>
	     
   </div>
</template>

<script>
  export default {
    props: {
      timepunch: Object
    },
    data() {
      return {
        
      }
    },
    computed: {
      
    }
  }

</script>