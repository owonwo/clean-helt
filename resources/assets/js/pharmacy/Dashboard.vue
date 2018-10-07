<template>
    <section class="">
        <div class="columns">
            <div class="column is-half">
                <ProfileBox class="is-green" :avatar-src="$parent.user.profile">
                    <h4 class="profile-title mb-15">{{ $parent.user.name }}</h4>
                    <router-link to="/profile" tag="button" class="button is-outlined is-rounded is-white">View Profile</router-link>
                </ProfileBox>
            </div>
            <div class="column is-half">
                <accordion>
                    <template slot="heading">
                        <i class="tag is-primary p-5 mr-15">{{ $parent.pendingUsers.length }}</i> New Clients Shared their Medical Records                      
                    </template>
                    <template slot="content">
                        <section class="menu content pl-10 pr-10">
                            <div class="py-5" v-for="(profile, index) in $parent.pendingUsers" :key="index">
                                <button @click="$parent.acceptShare(profile.id)" class="button is-outlined is-pulled-right is-rounded is-primary">Accept</button>
                                <h4 class="title is-5 mb-0">{{ profile.patient.first_name }} {{ profile.patient.last_name }}</h4>
                                <span>Access expired {{ profile.expired_at | moment("from") }}</span>
                            </div>
                        </section>
                    </template>
                </accordion>
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
    created() {
      axios.get('/api/pharmacy/notifications').then((res) => {
        res.data;
      })
    },
    methods: {
        success() {
            this.$parent.fetchHospitals();
        }
    }
}
</script>
