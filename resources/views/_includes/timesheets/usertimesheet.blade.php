 <section class="section">
  <div class="columns">
    <div class="column">
      <template>
        <section>
          <aside class="menu">
            <p class="menu-label">
                <div class="columns">
                  <div class="column is-narrow">
                    <a @click="selectUser" :class="{ 'is-active' : isActive }" :user="{{ $user }}" :weeks="{{ $user->payroll->periods->weeks }}">
                      <i class="fa" :class="iconClasses" v-show="hasWeeks"></i>
                    </a> 
                  </div>
                  <div class="column">
                    <a>{{ $user->getNameOrUsername() }}</a>
                  </div>
                  <div class="column">
                    Rollover: {{ $user->payroll->periods->readableRollover }}
                  </div>
                  <div class="column">
                    Hours: {{ $user->payroll->periods->readableHours }}
                  </div>
                  <div class="column">
                    Overtime: {{ $user->payroll->periods->readableOvertime }}
                  </div>
                </div>
              </p>
              <ul v-show="isActive" class="menu-list" >
                <week-list
                :weeks="{{$user->payroll->periods->weeks}}"
                ></week-list>
              </ul>
          </aside>

      </section>
    </template>
  </div>
</div>
</section>

@section('scripts')
<script>
 var app = new Vue({
    el: '#app',
    props: {
        
        selected: { default: false }
      },
      data: {
        user: Object,
        weeks: Array,       
          isActive: false
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
          return this.weeks &&
            this.weeks.length
        }
      },
      methods: {
        selectUser() {
          
            this.isActive = !this.isActive
          
        }
      } 
  });
</script>
@endsection