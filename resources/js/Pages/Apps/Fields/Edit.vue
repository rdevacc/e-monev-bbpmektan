<template>
    <Head>
        <title>Edit Kelompok | E-Monev BBP Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="bi bi-diagram-3-fill"></i> Edit Kelompok</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Nama Kelompok</label>
                                                <input class="form-control" v-model="form.name"
                                                    :class="{ 'is-invalid': errors.name }" type="text"
                                                    placeholder="Nama Kelompok">
                                            </div>
                                            <div v-if="errors.name" class="alert alert-danger">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Anggaran</label>
                                                <input class="form-control" v-model="form.budget"
                                                    :class="{ 'is-invalid': errors.budget }" type="number"
                                                    placeholder="Anggaran">
                                            </div>
                                            <div v-if="errors.budget" class="alert alert-danger">
                                                {{ errors.budget }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit"
                                                :disabled="form.processing">Update</button>
                                            <Link class="btn btn-warning shadow-sm rounded-sm ms-3" href="/apps/fields">Back
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

//import Head and useForm from Inertia
import { Head, Link, router, useForm } from '@inertiajs/vue3';

//import reactive from vue
import { reactive } from 'vue';

//import sweet alert2
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link
    },

    //props
    props: {
        errors: Object,
        field: Object,
    },

    //composition API
    setup(props) {

        //define form with reactive
        const form = useForm({
            name: props.field.name,
            budget: props.field.budget,
        });

        //method "submit"
        const submit = () => {

            //send data to server
            form.put(`/apps/fields/${props.field.id}`, {
                //data
                name: form.name,
                budget: form.budget,
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
            form,
            submit,
        };

    }
}
</script>

<style></style>