<template>
	<div>
		
			<div class="columns">
        <div class="column is-narrow">
          <a @click="selectUser" :class="{ 'is-active' : isActive }">
            <i class="fa" :class="iconClasses" v-show="hasWeeks"></i>
          </a> 
        </div>
			  <div class="column">
			    <a :href="'/manage/usertimesheet/' + user.id">{{ user.first_name }} {{ user.last_name }}</a>
			  </div>
			  <div class="column">
			    Rollover: {{ user.payroll.periods.readableRollover }}
			  </div>
			  <div class="column">
			    Hours: {{ user.payroll.periods.readableHours }}
			  </div>
			  <div class="column">
			    Overtime: {{ user.payroll.periods.readableOvertime }}
			  </div>
			</div>
	    
	    <ul v-show="isActive" class="menu-list" >
	    	<week-list
	    	:weeks="user.payroll.periods.weeks"
	    	></week-list>
	    </ul>
   </div>
</template>

<script>
  export default {
    props: {
      user: Object,
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
      hasWeeks: function () {
	      return this.user.payroll.periods.weeks &&
	        this.user.payroll.periods.weeks.length
	    }
    },
    methods: {
      selectUser() {
        
          this.isActive = !this.isActive
        
      }
    } 
  }

</script>