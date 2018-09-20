<template>
    <section class="">
        <div class="columns">
            <div class="column is-half">
                <ProfileBox class="is-green" :avatar-src="$parent.user.profile">
                    <h4 class="profile-title">Dr. {{ $parent.user.first_name }} {{ $parent.user.last_name }}</h4>
                    <p class="mb-15">{{ $parent.user.specialization | ucfirst }}</p>
                    <router-link to="/profile" tag="button" class="button is-outlined is-rounded is-white">View Profile</router-link>
                </ProfileBox>
            </div>

            <div class="column is-half">
                <section class="card">
                    <div class="card-header"><span class="card-header-title">Join a Hospital</span></div>
                    <div class="card-content">
                        <AddServiceProvider @success="success" model="DOCTOR"/>
                    </div>
                </section>
            </div>
        </div>

        <div class="columns">
            <div class="column is-half">
                <div class="card osq-table">
                    <div class="card-header">
                        <span class="card-header-icon"><i class="ti ti-pulse"></i></span>
                        <h1 class="card-header-title">Recently Viewed Patients</h1>
                    </div>
                    <div class="card-content p-0">
                        <table id="recent-views" class="table middle is-fullwidth">
                            <tr>
                                <th width="100px">Photo</th>
                                <th>Full Name</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td><img :src="$root.avatar" class="avatar avatar-50"/></td>
                                <td class="">Jonas King</td>
                                <td class=""><span class="tag is-info">Active</span></td>
                            </tr>
                            <tr>
                                <td><img :src="$root.avatar" class="avatar avatar-50"/></td>
                                <td class="">Richard Kane</td>
                                <td class=""><span class="tag is-success">Closed</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="column is-half">
                <accordion :show="true" v-if="$parent.pendingHospital.length > 0">
                    <template slot="heading">
                        <i class="tag is-primary p-5 mr-15">{{ $parent.pendingHospital.length }}</i> Pending Hospitals                     
                    </template>
                    <template slot="content">
                        <section class="menu content pl-10 pr-10">
                            <div class="py-5" v-for="(hospital, index) in $parent.pendingHospital" :key="index">
                                <button @click="$parent.manageHospital(hospital, 'accept')" class="button is-outlined is-pulled-right is-rounded is-primary">Accept</button>
                                <h4 class="title is-5 mb-0">{{ hospital.name}}</h4>
                                <span class="has-text-primary">{{ hospital.chcode }}</span>
                            </div>
                        </section>
                    </template>
                </accordion>
                <accordion>
                    <template slot="heading">
                        <i class="tag is-primary p-5 mr-15">{{ $parent.sentHospital.length }}</i> Hospitals Sent
                    </template>
                    <template slot="content">
                        <section class="menu content pl-10 pr-10">
                            <div class="py-5" v-for="(hospital, index) in $parent.sentHospital" :key="index">
                                <h4 class="title is-5 mb-0">{{ hospital.name}}</h4>
                                <span class="has-text-primary">{{ hospital.chcode }}</span>
                            </div>
                        </section>
                    </template>
                </accordion>
            </div>
        </div>
    </section>
</template>

<style scoped="" lang="scss">
	table#recent-views {
        tr > {
            td, th {
                &:first-child {
                    text-align: center;
                }
            }
        }

		tr > td {
            vertical-align: middle;
        }
	}
</style>

<script>
import Modal from '@/components/Modal.vue'
import LoggedIn from '@/Mixins/LoggedIn'

export default {
	components: {Modal},
    name: 'Dashboard',
    data() {return {
    }},
    methods: {
        success() {
            this.$parent.fetchHospitals();
        }
    }
}
</script>
