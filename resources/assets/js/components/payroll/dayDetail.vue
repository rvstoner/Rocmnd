<template>
	<div>
		
			<div class="columns">
        <div class="column is-narrow">
          <a href="#" @click="selectDay" :class="{ 'is-active' : isActive }"><i class="fa" :class="iconClasses" v-show="hasTimepunches"></i></a>
        </div>
			  <div class="column">
			    {{ day.label }} {{ day.start }} {{ day.end }}
			  </div>
			  <div class="column">
			    Hours: {{ day.readableHours }}
			  </div>
			</div>
	     
	    <ul v-show="isActive" class="menu-list" >
        <timepunch-list
        :timepunches="day.timepunches"
        >
	    	</timepunch-list>
	    </ul>
   </div>
</template>

<script>
  export default {
    props: {
      day: Object,
      selected: { default: false }
    },
    data() {
      return {
        isActive: false,
        test: "testing"
      }
    },
    mounted() {
      this.isActive = this.selected;
    },
    computed: {
      iconClasses() {
        return {
          'fa-plus-square-o': !this.isActive,
          'fa-minus-square-o': this.isActive
        }
      },
      hasTimepunches: function () {
	      return this.day.timepunches &&
	        this.day.timepunches.length
	    }
    },
    methods: {
      selectDay() {
        
          this.isActive = !this.isActive
        
      }
    } 
  }

</script>