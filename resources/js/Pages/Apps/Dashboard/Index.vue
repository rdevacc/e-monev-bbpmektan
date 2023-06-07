<template>
    <Head>
        <title>Dashboard | E-Monev BBPSI Mektan</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="bi bi-bar-chart-line-fill"></i> BAGAN TARGET DAN
                                    REALISASI KEUANGAN BULANAN</span>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-5 card border-0 rounded-3 shadow border-top-warning mx-2">
                                        <BarChart :chartData="ftChart" :options="ftOptions" />
                                    </div>
                                    <div class="col-5 card border-0 rounded-3 shadow border-top-success mx-2">
                                        <BarChart :chartData="frChart" :options="frOptions" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="bi bi-bar-chart-line-fill"></i> BAGAN TARGET DAN
                                    REALISASI FISIK BULANAN</span>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-5 card border-0 rounded-3 shadow border-top-warning mx-2">
                                        <BarChart :chartData="ptChart" :options="ptOptions" />
                                    </div>
                                    <div class="col-5 card border-0 rounded-3 shadow border-top-success mx-2">
                                        <BarChart :chartData="prChart" :options="prOptions" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
//import layout
import LayoutApp from '../../../Layouts/App.vue';

//import Heade and useForm from Inertia
import { Head } from '@inertiajs/vue3';

// Import ref
import { ref } from 'vue';

// Import Chart
import { BarChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

export default {

    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        BarChart,
    },

    props: {
        errors: Object,
        ftDate: Array,
        frDate: Array,
        ptDate: Array,
        prDate: Array,
        financial_target: Array,
        financial_realization: Array,
        physical_target: Array,
        physical_realization: Array,
    },

    setup(props) {


        // Method random color
        function randomBackgroundColor(length) {
            var data = [];
            for (var i = 0; i < length; i++) {
                data.push(getRandomColor());
            }
            return data;
        }

        // Method generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // FT option chart
        const ftOptions = ref({
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: "Target Keuangan BBPSI Mektan"
                },
            },
            beginZero: true
        });

        // FR option chart
        const frOptions = ref({
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: "Realisasi Keuangan BBPSI Mektan"
                },
            },
            beginZero: true
        });

        // PT option chart
        const ptOptions = ref({
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: "Target Fisik BBPSI Mektan"
                },
            },
            beginZero: true
        });

        // PR option chart
        const prOptions = ref({
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: "Realisasi Fisik BBPSI Mektan"
                },
            },
            beginZero: true
        });

        // const chart financial target
        const ftChart = {
            labels: props.ftDate,
            datasets: [
                {
                    data: props.financial_target,
                    backgroundColor: randomBackgroundColor(props.ftDate.length),
                },
            ],
        };

        // const chart financial realization
        const frChart = {
            labels: props.frDate,
            datasets: [
                {
                    data: props.financial_realization,
                    backgroundColor: randomBackgroundColor(props.frDate.length),
                },
            ],
        };

        // Const chart physical target
        const ptChart = {
            labels: props.ptDate,
            datasets: [
                {
                    data: props.physical_target,
                    backgroundColor: randomBackgroundColor(props.ptDate.length),
                }
            ]
        }

        // Const chart physical realization
        const prChart = {
            labels: props.prDate,
            datasets: [
                {
                    data: props.physical_realization,
                    backgroundColor: randomBackgroundColor(props.prDate.length),
                }
            ]
        }

        return {
            ftChart,
            frChart,
            ptChart,
            prChart,
            ftOptions,
            frOptions,
            ptOptions,
            prOptions,
        };
    },
}
</script>

<style></style>