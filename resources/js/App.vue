<template>
    <div class="wrapper">
        <div v-for="(day, i) in days" :key="'day-' + i" class="day">
            {{ day }}
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            days: []
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
