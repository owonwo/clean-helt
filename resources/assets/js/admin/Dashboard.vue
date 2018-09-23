<template>
	<section class="">
		<nav class="content-top-bar">
			<h3>Dashboard</h3>
		</nav>
		<div class="columns is-1 is-multiline mt-20">
			<div class="column is-one-fifth" v-for="(entry, name) in individual_counts">
				<div class="card short-card">
					<h3 class="has-text-right osq-text-primary">{{ entry.count }}</h3>
					<span>
						<i class="icon" :class="[$root.getIcon(entry.icon_name)]"></i> 
						<span class="">{{ name }}</span>
					</span>
				</div>
			</div>
		</div>

		<div class="card short-card">
			<h6 class="mb-0">Total Registered Users <span class="is-pulled-right">{{ registered_count }}</span></h6>
		</div>
	</section>
</template>

<script>
	export default {
		name: 'Dashboard',
		data() {return {
		}},
		computed: {
			registered_count() { 
				let {individual_counts: count_holder} = this;
				return Object.values(count_holder).map(e => e.count).reduce((e, i) => e + i);
			},
			counts() { return this.$parent.counts },
			individual_counts() { return {
				Patients: {count: this.counts.patients , icon_name: "client-alt"},
				Doctors: {count: this.counts.doctors, icon_name: "doctor"},
				Laboratories: {count: this.counts.labs, icon_name: "lab"},
				Hospitals: {count: this.counts.hospitals, icon_name: "hospital"},
				Pharmacies: {count: this.counts.pharmacies, icon_name: "pharmacy"},
			}}
		}
	}
</script>
