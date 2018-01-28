
<section class="section">
  <div class="container">
    <h1 class="title">{{ $user->getNameOrUsername() }}</h1>
  </div>
</section>
<section class="section">
  <div class="columns">
    <div class="column">
      <template>
        <section>

          <b-collapse :open="false">
            <button class="button is-primary" slot="trigger">Time punches</button>

            <template>
              <b-table
              :data="tableDataSimple"
              detailed
              detail-key="start"
              @details-open="(row, index) => $toast.open(`Expanded ${row.start.date.toLocaleDateString()}`)"
              >

              <template slot-scope="props">
                <b-table-column label="Week dates" width="250">
                  
                    @{{ new Date(props.row.start.date).toLocaleDateString() }} to @{{ new Date(props.row.end.date).toLocaleDateString() }}
                  
                </b-table-column>

                <b-table-column label="Hours">
                  <template v-if="props.row.hours">
                    @{{ Math.floor(props.row.hours/60/60) }}:@{{ Math.floor(((props.row.hours % 86400) % 3600) / 60) }}
                  </template>
                </b-table-column>

                <b-table-column label="Roll over">
                  <template v-if="props.row.rollover">
                    @{{ props.row.rollover/60/60 }}
                  </template>
                </b-table-column>

                <b-table-column label="OT">
                  <template v-if="props.row.overtime">
                    @{{ props.row.overtime/60/60 }}
                  </template>
                </b-table-column>
              </template>

              <template slot="detail" slot-scope="props">

                <table class="table table is-narrow">
                  <tbody>
                    <tr v-for="day in props.row.days">
                      <th>@{{ getWeekDay(day.start.date) }}</th>
                      <td>@{{ Math.floor(day.hours/60/60) }}:@{{ Math.floor(((day.hours % 86400) % 3600) / 60) }}</td>
                    </tr>
                  </tbody>
                </table>

              </template>
            </b-table>
          </template>

        </b-collapse>

      </section>
    </template>
  </div>
</div>
</section>

@section('scripts')
<script>
  var app = new Vue({
    el: '#app',
    data: {
      tableDataSimple: {!! $user->payroll->period->weeks !!},
      isOpen: true,
      weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

    },
    methods: {
      getWeekDay: function (dateString) {
        d = new Date(dateString)   
        return this.weekdays[d.getDay()]
      }
    }
  });
</script>
@endsection