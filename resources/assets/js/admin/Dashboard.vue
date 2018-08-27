<template>
	<section class="content">
		<div class="card short-card">
			<h6 class="mb-0">Total Registered Users <span class="is-pulled-right">{{ registered_count }}</span></h6>
		</div>

		<div class="columns is-1 is-multiline mt-20">
			<div class="column is-half" v-for="(entry, name) in individual_counts">
				<div class="card short-card">
					<h3 class="is-pulled-right osq-text-primary">{{ entry.count }}</h3>
					<span><i class="icon" :class="[$root.getIcon(entry.icon_name)]"></i> <span class="osq-text-primary">{{ name }}</span></span>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	export default {
		name: 'Dashboard',
		data() {return {
			registered_count: 395030,
			individual_counts: {
				Patients: {count: 2381, icon_name: "patient"},
				Doctors: {count: 1232, icon_name: "doctor"},
				Laboratories: {count: 326, icon_name: "lab"},
				Hospitals: {count: 435, icon_name: "hospital"},
				Pharmacies: {count: 35, icon_name: "pharmacy"},
			}
		}}
	}
</script>
