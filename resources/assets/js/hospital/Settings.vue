<template>
    <section class="p-15">
        <div class="card card-content is-paddingless">
            <div class="osq-two-columns">
                <aside class="osq-sidenav p-10">
                    <div class="menu">
                        <div class="menu-label"><i class="ti icon ti-settings" style="font-size: 1.5em;vertical-align: middle;"></i> Settings</div>
                        <ul class="menu-list" v-pager-controls.prevent="{activeClass: 'active'}">
                            <li v-for="(name, index) in ['Notification','Manage Doctors']"><a href="#">{{ name }}</a></li>
                        </ul>
                    </div>
                </aside>
                <section class="content">
                    <pager :current="page">
                        <div slot="p1" class="p-10">
                            <div class="menu-label">NOTIFICATIONS</div>
                            <toggle-switch size="sm" :value="false" />
                            <span>Notifications</span>
                            <p style="font-size: small" class="is-small">I want to receive notifications.</p>
                        </div>
                        <v-scrollbar slot="p2" class="p-10">
                            <!-- preloader -->
                            <div v-preload v-if="!!!doctors.length" class="block is-rounded mx-15 my-5 mb-0" style="height:10px;border-radius: 0" />
                            <!--  top navigation -->
                            <nav class="mb-15">
                                <search-box></search-box>
                            </nav>
                            <!-- doctors table -->
                            <table class="table is-hoverable is-fullwidth">
                                <tr>
                                    <th>Full Name</th>
                                    <th>Options</th>
                                </tr>
                                <tr v-for="(doctor, index) in orderDoctor">
                                    <td>
                                        Dr. {{ doctor.first_name }} {{ doctor.last_name }}
                                        <span v-if="!doctor.status" class="tag ml-15">pending</span>
                                        <br>
                                        <small><span class="osq-text-green mr-15">{{ doctor.chcode }}</span> {{ doctor.phone }}</small>
                                    </td>
                                    <td>
                                        <button v-if="doctor.status" @click="modal.remove = true" class="button is-hovered-danger has-no-motion is-outlined is-rounded">
                                            <i class="ti ti-trash"></i> delete
                                        </button>
                                        <button v-if="!doctor.status" @click="acceptDoctor(doctor)" class="button is-rounded has-no-motion is-outlined is-success">
                                            <i class="ti ti-check"></i> accept
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <div class="has-text-right">
                                <button @click="modal.add = true" class="md-btn-circle has-no-motion">
                                    <i class="ti icon ti-plus"></i>
                                </button>
                            </div>
                        </v-scrollbar>
                    </pager>
                </section>
            </div>
            <!-- remove doctor modal -->
            <modal :show="modal.remove" size="sm" @closed="(modal.remove = false)">
                <div class="content is-center">
                    <h5 class="title has-text-centered is-6">
						<div>
							<i class="ti ti-key" style="font-size: 4em"></i>
						</div>
						INSERT PASSWORD
					</h5>
                    <div class="field">
                        <input type="password" v-model="password" class="input" placeholder="Password">
                    </div>
                </div>
                <div slot="modal-footer" class="column is-fullwidth">
                    <button @click="checkPassword()" class="button is-fullwidth is-primary">
                        PROCEED
                    </button>
                </div>
            </modal>
            <!-- add doctor modal -->
            <modal :show="modal.add" size="sm" @closed="(modal.add = false)">
                <div class="content is-center">
                    <h5 class="title has-text-centered is-6">
						<div>
							<i class="osf osf-doctor" style="font-size: 4em"></i>
						</div>
						ADD DOCTOR
					</h5>
                    <div class="field">
                        <input type="text" class="input" placeholder="Enter Doctor CHCODE">
                    </div>
                </div>
                <div slot="modal-footer" class="column is-fullwidth">
                    <button @click="checkPassword()" class="button is-fullwidth is-primary">
                        <span class="ti mr-10 ti-email"></span> Send Invite
                    </button>
                </div>
            </modal>
        </div>
    </section>
</template>
<script>
import ToggleSwitch from '@/components/ToggleSwitch.vue'

export default {
    name: 'HospitalSettings',
    mounted: () => { document.title = "Settings | CleanHelt" },
    components: { ToggleSwitch },
    created() {
        const { buildStatus } = this;
        const fetchDoctors = Promise.all([this.$parent.getDoctors(), this.$parent.getDoctorsPending()]);
        //TODO: Remove the buildStatus function
        fetchDoctors.then((res) => {
            let [acceptedDoctors, pendingDoctors] = res;
            this.doctors = [
                ...buildStatus(pendingDoctors.data.doctors)(false),
                ...buildStatus(acceptedDoctors.data.doctors)(true)
            ];
        }).catch(function(err) {
            console.groupCollapsed('Hospital Settings Warnings')
            console.log(err);
            console.groupEnd();
        });
    },
    computed: {
    	orderDoctor(){
        	return this.doctors.sort(e => e.status == true);
        },
    },
    data() {
        return {
            page: 0,
            password: "",
            doctors: [],
            modal: { add: false, remove: false, },
            notification_state: true,
        }
    },
    methods: {
        setPage(page = 0) {
            this.page = page;
        },
        acceptDoctor(doctor) {
            const url = `/api/hospital/doctors/${doctor.chcode}/accept`;
            this.$http.patch(url).then((res) => {
                doctor.status = true;
            }).catch(() => {
                console.log('Accept Failed!');
            })
        },
        buildStatus: objects => state => {
            return objects.map(e => _.extend(e, { status: state }));
        },
        checkPassword() {
            this.$http.post('').then((res) => {})
        },
        revokeAccess() {
            this.modal.remove = false
        }
    }
}
</script>
