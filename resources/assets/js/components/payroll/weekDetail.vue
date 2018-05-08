<template>
	<div>
		
			<div class="columns">
        <div class="column is-narrow">
          <a href="#" @click="selectWeek" :class="{ 'is-active' : isActive }"><i class="fa" :class="iconClasses" v-show="hasDays"></i></a>
        </div>
			  <div class="column">
			    {{ week.start }} to {{ week.end }}
			  </div>
			  <div class="column">
			    Rollover: {{ week.readableRollover }}
			  </div>
			  <div class="column">
			    Hours: {{ week.readableHours }}
			  </div>
			  <div class="column">
			    Overtime: {{ week.readableOvertime }}
			  </div>
			</div>
	     
	    <ul v-show="isActive" class="menu-list" >
	    	<day-list
        :days="week.days"
        ></day-list>
	    </ul>
   </div>
</template>

<script>
  export default {
    props: {
      week: Object,
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
      hasDays: function () {
	      return this.week.days &&
	        this.week.days.length
	    }
    },
    methods: {
      selectWeek() {
        
          this.isActive = !this.isActive
        
      }
    } 
  }

</script>