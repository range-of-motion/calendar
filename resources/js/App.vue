<template>
    <div class="wrapper">
        <div v-for="(day, i) in days" :key="'day-' + i" class="day">
            <div class="day-label">{{ day }}</div>
            <div v-for="(hour, j) in endingHour - startingHour" :key="'hour-' + j" class="hour" :data-datetime="day + ' ' + ((startingHour + hour - 1).toString().padStart(2, 0)) + ':00:00'">
                <div class="hour-label">{{ (startingHour + hour - 1).toString().padStart(2, 0) }}:00</div>
                <div class="appointments">
                    <div v-for="appointment in getAppointments(day, startingHour + hour - 1)" :key="'appointment-' + appointment.id" class="appointment" draggable="true" :data-id="appointment.id">
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

            appointments: [],
            draggingPayload: null
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
    },

    updated() {
        /**
         * Appointments (payloads)
         */

        document.querySelectorAll('.appointment').forEach(element => {
            element.addEventListener('dragstart', e => {
                this.draggingPayload = e.target;
            });
        });

        /**
         * Hours (targets)
         */

        document.querySelectorAll('.hour').forEach(element => {
            /**
             * I have no idea why, but the "drop" event only triggers if the
             * following 2 events have been prevented..
             */

            element.addEventListener('dragenter', e => {
                e.preventDefault();
            });

            element.addEventListener('dragover', e => {
                e.preventDefault();
            });

            /**
             * And finally, the actual "drop" event
             */

            element.addEventListener('drop', e => {
                // Detach from previous parent
                this.draggingPayload.parentNode.removeChild(this.draggingPayload);

                element.querySelector('.appointments').appendChild(this.draggingPayload);

                /**
                 * Notify API of drag
                 */

                const id = this.draggingPayload.dataset.id;
                const targetDateTime = element.dataset.datetime;

                axios.post('/api/appointments/' + id + '/update', {
                    scheduled_at: targetDateTime
                }).then(() => {
                    console.log('gg');
                });
            });
        });
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

.day-label {
    padding: 8px;
    text-align: center;
}

.hour {
    display: flex;
    padding: 8px;
}

.hour-label {
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

.appointment:hover {
    cursor: pointer;
}
</style>
