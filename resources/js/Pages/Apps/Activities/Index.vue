<template>
    <Head>
        <title>Kegiatan | E-Monev BBPSI Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="bi-clipboard-data-fill"></i> Kegiatan</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="row">
                                        <div class="col-4 input-group mb-3">
                                            <Link href="/apps/activities/create"
                                                v-if="hasAnyPermission(['activities.create'])"
                                                class="btn btn-primary input-group-text"> <i
                                                class="fa fa-plus-circle me-2"></i>
                                            Baru</Link>

                                            <input type="text" v-model="search" class="form-control"
                                                placeholder="Cari berdasarkan nama kegiatan..." autofocus>

                                            <button class="btn btn-primary input-group-text" type="submit"> <i
                                                    class="fa fa-search me-2"></i> Search</button>

                                        </div>
                                    </div>
                                </form>
                                <form @submit.prevent="filter" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="fw-bold">Kelompok</label>
                                            <VueMultiselect v-model="sfi" :options="fields" :close-on-select="true"
                                                :clear-on-select="false" placeholder="Pilih Kelompok" label="name"
                                                track-by="name" />
                                        </div>

                                        <div class="col-md-4">
                                            <label class="fw-bold">Subkelompok</label>
                                            <VueMultiselect v-model="sgi" :options="groups" :close-on-select="true"
                                                :clear-on-select="false" placeholder="Pilih Subkelompok" label="name"
                                                track-by="name" />
                                        </div>

                                        <div class="col-md-4">
                                            <label class="fw-bold">PJ</label>
                                            <VueMultiselect v-model="sui" :options="users" :close-on-select="true"
                                                :clear-on-select="false" placeholder="Pilih PJ" label="name"
                                                track-by="name" />
                                        </div>

                                        <!-- <div class="col-md-4">
                                            <div>
                                                <label class="form-label fw-bold">Tanggal Awal</label>
                                                <input type="date" v-model="start_date" class="form-control">
                                            </div>
                                            <div v-if="errors.start_date" class="alert alert-danger">
                                                {{ errors.start_date }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label class="form-label fw-bold">Tanggal Akhir</label>
                                                <input type="date" v-model="end_date" class="form-control">
                                            </div>
                                            <div v-if="errors.end_date" class="alert alert-danger">
                                                {{ errors.end_date }}
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div>
                                                <button class="btn btn-md btn-purple border-0 shadow w-100"><i
                                                        class="fa fa-filter"></i> FILTER</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <div v-if="activities">
                                    <!-- Button Excel and PDF -->
                                    <div class="export text-end mb-3">
                                        <a :href="`/apps/activities/export?sfi=${fieldSearchId}&sgi=${groupSearchId}&sui=${userSearchId}`"
                                            target="_blank" class="btn btn-success btn-md border-0 shadow me-3"><i
                                                class="fa fa-file-excel"></i> EXCEL</a>
                                        <a :href="`/apps/activities/export-pdf?sfi=${fieldSearchId}&sgi=${groupSearchId}&sui=${userSearchId}`"
                                            target="_blank" class="btn btn-danger btn-md border-0 shadow"><i
                                                class="fa fa-file-pdf"></i> PDF</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" class="align-middle">No</th>
                                                    <th scope="col" class="align-middle">Judul Kegiatan</th>
                                                    <th scope="col" class="align-middle">Kelompok</th>
                                                    <th scope="col" class="align-middle">Subkelompok</th>
                                                    <th scope="col" class="align-middle" style="width: 10%;">Anggaran PJ
                                                    </th>
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
                                                    <th scope="col" class="align-middle" style="width:10%"
                                                        v-if="hasAnyPermission(['activities.edit'])">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(  activity, index  ) in   activities.data  " :key="index">
                                                    <td><span>{{ index + 1 }}</span></td>
                                                    <td>
                                                        <Link :href="`/apps/activities/${activity.id}`"
                                                            style="text-decoration: none; color: black;"><span>{{
                                                                activity.name
                                                            }}</span></Link>
                                                    </td>
                                                    <td>
                                                        <span>{{
                                                            activity.field.name }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{
                                                            activity.group.name }}</span>
                                                    </td>
                                                    <td><span>Rp. {{ formatPrice(activity.budget) }}</span></td>
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
                                                        <div class="mb-2" v-for="(  done, index  ) in   activity.dones  ">
                                                            <span v-if="done.value">{{ index + 1 }}. {{ done.value
                                                            }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mb-2"
                                                            v-for="(  problem, index  ) in   activity.problems  ">
                                                            <span v-if="problem.value">{{ index + 1 }}. {{ problem.value
                                                            }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mb-2"
                                                            v-for="(  follow, index  ) in   activity.follow_up  ">
                                                            <span v-if="follow.value">{{ index + 1 }}. {{ follow.value
                                                            }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mb-2" v-for="(  todo, index  ) in   activity.todos  ">
                                                            <span v-if="todo.value">{{ index + 1 }}. {{ todo.value
                                                            }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" v-if="hasAnyPermission(['activities.edit'])">
                                                        <Link :href="`/apps/activities/${activity.id}`"
                                                            v-if="hasAnyPermission(['activities.show'])"
                                                            class="btn btn-purple btn-sm me-1"><i class="bi bi-eye"></i>
                                                        </Link>
                                                        <Link :href="`/apps/activities/${activity.id}/edit`"
                                                            v-if="hasAnyPermission(['activities.edit'])"
                                                            class="btn btn-success btn-sm me-1"><i
                                                            class="fa fa-pencil-alt me-1"></i></Link>
                                                        <button @click.prevent="destroy(activity.id)"
                                                            v-if="hasAnyPermission(['activities.delete'])"
                                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <Pagination :links="activities.links" align="end" />
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

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import { Head, Link, router } from '@inertiajs/vue3';

// import ref
import { ref } from 'vue';
import Swal from 'sweetalert2';

// Import Vue Multiselect
import VueMultiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css'

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link,
        Pagination,
        VueMultiselect,
    },

    //props
    props: {
        activities: Object,
        next_month: String,
        fields: Object,
        fieldSearchId: Object,
        groupSearchId: Object,
        userSearchId: Object,
        field_name: Array,
        groups: Object,
        users: Object,
        errors: Object,
    },
    setup(props) {

        const search = ref('' || (new URL(document.location)).searchParams.get('q'));
        const sfi = ref('');
        const sgi = ref('');
        const sui = ref('');
        // const start_date = ref('' || (new URL(document.location)).searchParams.get('start_date'));
        // const end_date = ref('' || (new URL(document.location)).searchParams.get('end_date'));

        const handleSearch = () => {
            router.get('/apps/activities', {
                q: search.value,
            });
        }

        const destroy = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    router.delete(`/apps/activities/${id}`);

                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        }

        const filter = () => {
            router.get('/apps/activities/filter', {
                sfi: sfi.value.id,
                sgi: sgi.value.id,
                sui: sui.value.id,
                // start_date: start_date.value,
                // end_date: end_date.value,
            });
        }

        return {
            search,
            filter,
            handleSearch,
            destroy,
            sfi,
            sgi,
            sui,
            // start_date,
            // end_date,
        };

    },
}
</script>

<style></style>