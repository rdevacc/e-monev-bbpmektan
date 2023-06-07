<template>
    <Head>
        <title>Kegiatan | E-Monev BBPSI Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <div class="font-weight-bold mb-2">
                                    <span>PROGRES PELAKSANAAN KEGIATAN BBP MEKTAN TAHUN 2023</span>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <span>Sampai dengan akhir bulan</span>
                                    </div>
                                    <div class="col px-0">
                                        <span class="font-weight-bold">: {{ month }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <span>Bidan/Bagian</span>
                                    </div>
                                    <div class="col px-0">
                                        <span class="font-weight-bold">: {{ activity.field.name }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <span>Kelompok</span>
                                    </div>
                                    <div class="col px-0">
                                        <span class="font-weight-bold">: {{ activity.group.name }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <span>Penanggung Jawab</span>
                                    </div>
                                    <div class="col px-0">
                                        <span class="font-weight-bold">: {{ activity.user.name }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <span>Anggaran</span>
                                    </div>
                                    <div class="col px-0">
                                        <span class="font-weight-bold">: Rp. {{ formatPrice(activity.budget) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="float-end mb-3">
                                    <Link as="button" href="/apps/activities" class="btn btn-warning btn-sm"><i
                                        class="bi bi-arrow-bar-left"></i>
                                    Kembali
                                    </Link>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col" class="align-middle">Judul Kegiatan</th>
                                            <th scope="col" class="align-middle">Kelompok</th>
                                            <th scope="col" class="align-middle">Subkelompok</th>
                                            <th scope="col" class="align-middle">Target
                                                dan Realisasi
                                                Keuangan
                                            </th>
                                            <th scope="col" class="align-middle">Target
                                                dan Realisasi
                                                Fisik</th>
                                            <th scope="col" class="align-middle">Kegiatan yang
                                                sudah dikerjakan</th>
                                            <th scope="col" class="align-middle">Permasalahan</th>
                                            <th scope="col" class="align-middle">Tindak Lanjut</th>
                                            <th scope="col" class="align-middle">Kegiatan yang akan
                                                dilakukan ({{
                                                    next_month
                                                }})
                                            </th>
                                            <th scope="col" class="align-middle" style="width:15%"
                                                v-if="hasAnyPermission(['activities.delete'])">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="activity">
                                        <tr>
                                            <td><span>{{ activity.name }}</span></td>
                                            <td>
                                                <span class=" badge badge-primary shadow border-0 ms-2 mb-2">{{
                                                    activity.field.name }}</span>
                                            </td>
                                            <td><span class="badge badge-primary shadow border-0 ms-2 mb-2">{{
                                                activity.group.name }}</span></td>
                                            <td>
                                                <span>T: {{ activity.financial_target }} %</span>
                                                <br>
                                                <span>R: {{ activity.financial_realization }} %</span>
                                            </td>
                                            <td>
                                                <span>T: {{ activity.physical_target }} %</span>
                                                <br>
                                                <span>R: {{ activity.physical_realization }} %</span>
                                            </td>
                                            <td>
                                                <div class="mb-2" v-for="(done, index) in activity.dones">
                                                    <span v-if="done.value">{{ index + 1 }}. {{ done.value }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-2" v-for="(problem, index) in activity.problems">
                                                    <span v-if="problem.value">{{ index + 1 }}. {{ problem.value }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-2" v-for="(follow, index) in activity.follow_up">
                                                    <span v-if="follow.value">{{ index + 1 }}. {{ follow.value }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-2" v-for="(todo, index) in activity.todos">
                                                    <span v-if="todo.value">{{ index + 1 }}. {{ todo.value }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center" v-if="hasAnyPermission(['activities.delete'])">
                                                <Link :href="`/apps/activities/${activity.id}/edit`"
                                                    v-if="hasAnyPermission(['activities.edit'])"
                                                    class="btn btn-success btn-sm me-1"><i
                                                    class="fa fa-pencil-alt me-1"></i> Edit</Link>
                                                <button @click.prevent="destroy(activity.id)"
                                                    v-if="hasAnyPermission(['activities.delete'])"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <Pagination :links="activity.links" align="end" />
                        </div>

                        <!-- Chart -->
                        <!-- <div class="card border-0 rounded-3 shadow border-top-success">
                            <LineChart :chartData="testData" />
                        </div>
                        <div class="card border-0 rounded-3 shadow border-top-success">
                            <LineChart :chartData="testData" />
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
//import layout
import LayoutApp from '../../../Layouts/App.vue';

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import { Head, Link, router } from '@inertiajs/vue3';

// Import Chart
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

// Import Vue Multiselect
import VueMultiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css'

// Import ref
import { ref } from 'vue';

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link,
        Pagination,
        VueMultiselect,
        LineChart,
    },

    //props
    props: {
        activity: Object,
        month: String,
        next_month: String,
        errors: Object,
        financial_date: Array,
        financial_realization: Array,
    },
    setup(props) {

        //method random color
        function randomBackgroundColor(length) {
            var data = [];
            for (var i = 0; i < length; i++) {
                data.push(getRandomColor());
            }
            return data;
        }

        //method generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        //option chart
        const options = ref({
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                },
            },
            beginZero: true
        });

        // const chart

        const testData = {
            labels: props.financial_date,
            datasets: [
                {
                    data: props.financial_realization,
                    backgroundColor: randomBackgroundColor(props.financial_date.length),
                },
            ],
        };

        return { testData, options };

    },
}
</script>

<style></style>