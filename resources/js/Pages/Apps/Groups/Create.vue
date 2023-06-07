<template>
    <Head>
        <title>Add New Groups | E-Monev BBP Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-user"></i> Add New Group</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Group Name</label>
                                                <input class="form-control" v-model="form.name"
                                                    :class="{ 'is-invalid': errors.name }" type="text" placeholder="Group">
                                            </div>
                                            <div v-if="errors.name" class="alert alert-danger">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Spv Name</label>
                                                <input class="form-control" v-model="form.spv"
                                                    :class="{ 'is-invalid': errors.spv }" type="text"
                                                    placeholder="Spv Name">
                                            </div>
                                            <div v-if="errors.spv" class="alert alert-danger">
                                                {{ errors.spv }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Field Name</label>
                                                <br>
                                                <select v-model="form.field_id">
                                                    <option disabled value="">Please select one</option>
                                                    <option v-for="field in fields" :value="field.id">{{ field.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.field_id" class="alert alert-danger">
                                                {{ errors.field_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit"
                                                :disabled="form.processing">Save</button>
                                            <Link class="btn btn-warning shadow-sm rounded-sm ms-3" href="/apps/groups">Back
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
        fields: Object,
        users: Object,
    },

    //composition API
    setup() {

        //define form with reactive
        const form = useForm({
            field_id: '',
            name: '',
            spv: '',
        });

        //method "submit"
        const submit = () => {

            //send data to server
            form.post('/apps/groups', {
                //data
                field_id: form.field_id,
                name: form.name,
                spv: form.spv,
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