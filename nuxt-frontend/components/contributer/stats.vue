<template>
  <div>
    <div class="flex gap-4 my-6">
        <ui-card title="total halts" :value="totalHalts" icon="halt" />
        <ui-card title="total agents" :value="totalAgents" icon="ongoingHalts" />
        <ui-card title="total payouts" :value="totalPayouts" icon="upcomingHalts" />
        <ui-card title="seconds balance" type="green" value="700 USDT" icon="secondsBalance" />
        <ui-card title="agents power" type="red" value="3 Gbit/S" icon="power" />
    </div>

    <contributer-chartContainer name="requests" total="255.555" :chartData="chartData" />
    <contributer-chartContainer name="packets" total="255.555" :chartData="chartData" />
    <contributer-chartContainer name="bandwith" total="255.555" :chartData="chartData" />
  </div>
</template>

<script>
export default {
    data() {
        return{
            chartData: [
                { date: '2024-01-01 22:00', value: 30 },
                { date: '2024-01-01 22:15', value: 86 },
                { date: '2024-01-01 22:30', value: 168 },
                { date: '2024-01-01 22:45', value: 50 },
                { date: '2024-01-01 23:00', value: 303 },
                { date: '2024-01-01 23:15', value: 50 },
                { date: '2024-01-02 00:00', value: 30 },
                { date: '2024-01-02 01:15', value: 86 },
                { date: '2024-01-02 01:30', value: 168 },
                { date: '2024-01-02 01:45', value: 50 },
                { date: '2024-01-02 02:00', value: 303 },
                { date: '2024-01-02 02:15', value: 50 }
            ],
            totalHalt: 15,
            totalAgents: 4,
            totalPayouts: '30500 USD'
        }
    }
}
</script>

<style>

</style>