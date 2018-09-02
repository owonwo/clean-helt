<template>
    <section class="">
        <div class="columns">
            <div class="column is-half">
                <ProfileBox class="is-green" :avatar-src="$store.state.user.profile">
                    <h4 class="profile-title">Dr. {{ $store.state.user.first_name }} {{ $store.state.user.last_name }}</h4>
                    <p class="mb-15">{{ $store.state.user.specialization | ucfirst }}</p>
                    <router-link to="/profile" tag="button" class="button is-outlined is-rounded is-white">View Profile</router-link>
                </ProfileBox>
            </div>

            <div class="column is-half">
                <AddServiceProvider/>
            </div>
        </div>

        <div class="columns">
            <div class="column is-fullwidth">
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
    mixins: [LoggedIn],
	components: {Modal},
    name: 'Dashboard',
    data() {return {
        hospital_chcode: "",
        isLoading: false,
    }},
    methods: {
        sendAddHospitalRequest(send) {
            this.isLoading = true;
            this.$parent.addHospital(this.hospital_chcode).then(() => {
                this.hospital_chcode = ""
                this.isLoading = false;
            })
        }
    }
}
</script>
