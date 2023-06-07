<template>
    <Head>
        <title>Edit Kegiatan | E-Monev BBP Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-warning">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="bi-clipboard-data-fill"></i>
                                    Edit Kegiatan</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row" v-if="hasAnyPermission(['activities.delete'])">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Judul Kegiatan</label>
                                                <input class="form-control" v-model="form.name"
                                                    :class="{ 'is-invalid': errors.name }" type="text"
                                                    placeholder="Nama Kegiatan">
                                            </div>
                                            <div v-if="errors.name" class="alert alert-danger">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" v-if="hasAnyPermission([' activities.delete'])">
                                        <div class=" col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Bidang</label>
                                                <br>
                                                <select v-model="form.field_id" class="form-select">
                                                    <option disabled value="">Please select one</option>
                                                    <option v-for="  field   in   fields  " :value="field.id">{{
                                                        field.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.field_id" class="alert alert-danger">
                                                {{ errors.field_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" v-if="hasAnyPermission([' activities.delete'])">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Kelompok</label>
                                                <br>
                                                <select v-model="form.group_id" class="form-select">
                                                    <option disabled value="">Please select one</option>
                                                    <option v-for="  group   in   groups  " :value="group.id">{{
                                                        group.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.group_id" class="alert alert-danger">
                                                {{ errors.group_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" v-if="hasAnyPermission([' activities.delete'])">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Penganggung Jawab</label>
                                                <br>
                                                <select v-model="form.user_id" class="form-select">
                                                    <option disabled value="">Please select one</option>
                                                    <option v-for="  user   in   users  " :value="user.id">{{ user.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.user_id" class="alert alert-danger">
                                                Kolom {{ errors.user_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" v-if="hasAnyPermission([' activities.delete'])">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Anggaran Penanggung Jawab</label>
                                                <br>
                                                <div v-if="hasAnyPermission(['activities.delete'])"
                                                    class="input-group mb-3">
                                                    <Money3Component class="form-control" v-model.number="budgetPJ"
                                                        v-bind="config">
                                                    </Money3Component>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Target dan Realisasi Keuangan</label>
                                                <br>
                                                <div v-if="hasAnyPermission(['activities.delete'])"
                                                    class="input-group mb-3">
                                                    <span class="input-group-text">Target</span>
                                                    <!-- <input v-model="financial_target" type="number" class="form-control"
                                                        placeholder="Rp."> -->
                                                    <Money3Component class="form-control" v-model.number="financial_target"
                                                        v-bind="config">
                                                    </Money3Component>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Realisasi</span>
                                                    <Money3Component class="form-control"
                                                        v-model.number="financial_realization" v-bind="config">
                                                    </Money3Component>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Target dan Realisasi Fisik</label>
                                                <br>
                                                <div v-if="hasAnyPermission(['activities.delete'])"
                                                    class="input-group mb-3">
                                                    <span class="input-group-text">Target</span>
                                                    <Money3Component class="form-control" v-model.number="physical_target"
                                                        v-bind="config">
                                                    </Money3Component>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Realisasi</span>
                                                    <Money3Component class="form-control"
                                                        v-model.number="physical_realization" v-bind="config">
                                                    </Money3Component>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="fw-bold">Kegiatan yang sudah dilakukan</label>
                                        <div v-for="( item, index ) in  dones " :key="item">
                                            <div class="input-group mb-3">
                                                <input class="form-control" v-model="item.value"
                                                    :class="{ 'is-invalid': errors.item }" type="text"
                                                    placeholder="Kegiatan yang sudah dilakukan">
                                                <button @click.prevent="addDones()" preserve-scroll
                                                    class="btn btn-success input-group-text">
                                                    <i class="fa fa-plus-circle"></i></button>
                                                <button @click.prevent="removeDones(index)" preserve-scroll
                                                    class="btn btn-danger input-group-text">
                                                    <i class="fa fa-minus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="fw-bold">Permasalahan</label>
                                        <div v-for="( item, index ) in  problems " :key="item">
                                            <div class="input-group mb-3">
                                                <input class="form-control" v-model="item.value"
                                                    :class="{ 'is-invalid': errors.item }" type="text"
                                                    placeholder="Permasalahan">
                                                <button @click.prevent="addProblems()" preserve-scroll
                                                    class="btn btn-success input-group-text">
                                                    <i class="fa fa-plus-circle"></i></button>
                                                <button @click.prevent="removeProblems(index)" preserve-scroll
                                                    class="btn btn-danger input-group-text">
                                                    <i class="fa fa-minus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="fw-bold">Tindak Lanjut</label>
                                        <div v-for="( item, index ) in  follow_up " :key="item">
                                            <div class="input-group mb-3">
                                                <input class="form-control" v-model="item.value"
                                                    :class="{ 'is-invalid': errors.item }" type="text"
                                                    placeholder="Permasalahan">
                                                <button @click.prevent="addFollowup()" preserve-scroll
                                                    class="btn btn-success input-group-text">
                                                    <i class="fa fa-plus-circle"></i></button>
                                                <button @click.prevent="removeFollowup(index)" preserve-scroll
                                                    class="btn btn-danger input-group-text">
                                                    <i class="fa fa-minus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="fw-bold">Kegiatan yang akan dilakukan ({{ next_month
                                        }})</label>
                                        <div v-for="( item, index ) in  todos " :key="item">
                                            <div class="input-group mb-3">
                                                <input class="form-control" v-model="item.value"
                                                    :class="{ 'is-invalid': errors.item }" type="text"
                                                    placeholder="Kegiatan yang akan dilakukan">
                                                <button @click.prevent="addTodos()" preserve-scroll
                                                    class="btn btn-success input-group-text">
                                                    <i class="fa fa-plus-circle"></i></button>
                                                <button @click.prevent="removeTodos(index)" preserve-scroll
                                                    class="btn btn-danger input-group-text">
                                                    <i class="fa fa-minus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit"
                                                :disabled="form.processing">Update</button>
                                            <Link class="btn btn-warning shadow-sm rounded-sm ms-3" href="/apps/activities">
                                            Back
                                            </Link>
                                        </div>
                                    </div>
                                </form>

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

// Import V-Money
import { Money3Component } from 'v-money3';

//import Head and useForm from Inertia
import { Head, Link, router, useForm } from '@inertiajs/vue3';

//import reactive from vue
import { reactive } from 'vue';

// Import ref from Vue
import { ref } from 'vue';

//import sweet alert2
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link,
        Money3Component,
    },

    //props
    props: {
        activity: Object,
        errors: Object,
        users: Object,
        groups: Object,
        fields: Object,
        auth: Object,
        next_month: String,
    },

    //composition API
    setup(props) {

        const config = {
            masked: false,
            prefix: 'Rp. ',
            suffix: '',
            thousands: '.',
            decimal: ',',
            precision: 0,
            disableNegative: true,
            disabled: false,
            min: null,
            max: 999999999999,
            allowBlank: false,
            minimumNumberOfCharacters: 0,
            shouldRound: true,
            focusOnRight: false,
        }

        const budgetPJ = ref(props.activity.budget);
        const financial_target = ref(props.activity.financial_target);
        const financial_realization = ref(props.activity.financial_realization);
        const physical_target = ref(props.activity.physical_target);
        const physical_realization = ref(props.activity.physical_realization);
        const dones = props.activity.dones;
        const problems = props.activity.problems;
        const follow_up = props.activity.follow_up;
        const todos = props.activity.todos;


        // Method addDones
        const addDones = () => {
            dones.push({ value: '' });
        }

        // Method removeDones
        const removeDones = (index) => {
            dones.splice(index, 1);
        }

        // Method addProblems
        const addProblems = () => {
            problems.push({ value: '' });
        }

        // Method removeProblems
        const removeProblems = (index) => {
            problems.splice(index, 1);
        }

        // Method addFollowup
        const addFollowup = () => {
            follow_up.push({ value: '' });
        }

        // Method removeFollowup
        const removeFollowup = (index) => {
            follow_up.splice(index, 1);
        }

        // Method addTodos
        const addTodos = () => {
            todos.push({ value: '' });
        }

        // Method removeTodos
        const removeTodos = (index) => {
            todos.splice(index, 1);
        }

        //define form with reactive
        const form = reactive({
            user_id: props.activity.user_id,
            group_id: props.activity.group_id,
            field_id: props.activity.field_id,
            name: props.activity.name,
        });

        //method "submit"
        const submit = () => {
            //send data to server
            router.post(`/apps/activities/${props.activity.id}`, {
                //data
                _method: 'PUT',
                user_id: form.user_id,
                group_id: form.group_id,
                field_id: form.field_id,
                name: form.name,
                budget: budgetPJ.value,
                financial_target: financial_target.value,
                financial_realization: financial_realization.value,
                physical_target: physical_target.value,
                physical_realization: physical_realization.value,
                dones: dones,
                problems: problems,
                follow_up: follow_up,
                todos: todos,
            }, {
                onSuccess: () => {
                    //show success alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'User saved successfully.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });

        }

        return {
            config,
            budgetPJ,
            addDones,
            removeDones,
            addProblems,
            removeProblems,
            addFollowup,
            removeFollowup,
            addTodos,
            removeTodos,
            form,
            submit,
            dones,
            problems,
            follow_up,
            todos,
            financial_target,
            financial_realization,
            physical_target,
            physical_realization,
        };

    }
}
</script>

<style></style>