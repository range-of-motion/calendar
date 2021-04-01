<template>
    <div class="wrapper">
        <div v-for="(day, i) in days" :key="'day-' + i" class="day">
            <div v-for="(hour, j) in endingHour - startingHour" :key="'hour-' + j">
                {{ startingHour + hour - 1 }}:00
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
            endingHour: 17
        };
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
</style>
