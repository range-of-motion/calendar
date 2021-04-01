<template>
    <div class="wrapper">
        <div v-for="(day, i) in days" :key="'day-' + i" class="day">
            <div v-for="(hour, j) in endingHour - startingHour" :key="'hour-' + j" class="hour">
                <div class="label">{{ startingHour + hour - 1 }}:00</div>
                <div class="appointments">
                    <div v-for="appointment in getAppointments(day, startingHour + hour - 1)" :key="'appointment-' + appointment.id" class="appointment">
                        {{ appointment.memo }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            days: [],
            startingHour: 9,
            endingHour: 17,

            appointments: []
        };
    },

    methods: {
        fetchAppointments() {
            axios.get('/api/appointments').then(response => {
                this.appointments = response.data;
            });
        },

        getAppointments(day, hour) {
            return this.appointments.filter(appointment => {
                const date = appointment.scheduled_at.split(' ')[0];
                const time = appointment.scheduled_at.split(' ')[1];

                return date == day && hour == time.split(':')[0];
            });
        }
    },

    created() {
        /**
         * Set up days
         */

        let today = new Date();

        for (let i = 4; i >= 0; i --) {
            const date = new Date();

            date.setDate(today.getDate() - i);

            this.days.push(date.toISOString().split('T')[0]);
        }

        /**
         * Fetch appointments
         */

        this.fetchAppointments();
    }
};
</script>

<style>
.wrapper {
    margin: 20px auto;
    display: flex;
    max-width: 1400px;
}

.day {
    flex: 1;
}

.day:nth-child(odd) {
    background: #FAFAFA;
}

.hour {
    display: flex;
    padding: 8px;
}

.label {
    margin-right: 20px;
}

.appointments {
    flex: 1;
    padding: 8px;
    min-height: 80px;
    background: #EEE;
    border-radius: 8px;
}

.appointment {
    padding: 4px 8px;
    background: #FFF;
    border: 1px solid #CCC;
    border-radius: 8px;
}
</style>
