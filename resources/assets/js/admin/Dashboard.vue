<template>
	<section class="content">
		<div class="card short-card">
			<h6 class="mb-0">Total Registered Users <span class="is-pulled-right">{{ registered_count }}</span></h6>
		</div>

		<div class="columns is-1 is-multiline mt-20">
			<div class="column is-half" v-for="(count, name) in individual_counts">
				<div class="card short-card">
					<h3 class="is-pulled-right osq-text-primary">{{ count }}</h3>
					<span><i class="icon"></i> <span class="osq-text-primary">{{ name }}</span></span>
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
				Patients: 2381,
				Doctors: 1232,
				Laboratory: 326,
				Hospital: 435,
				Pharmacy: 35,
			}
		}}
	}
</script>
