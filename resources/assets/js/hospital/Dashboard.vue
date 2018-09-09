<template>
	<section id="hospital">
		<section class="content-top-bar">
			<h3>DASHBOARD</h3>
		</section>
		<div class="columns">
			<div class="column is-one-third">
				<form class="">
					<p class="">Enter the CH-CODE of any Doctor to invite them to the hospital.</p>
					<div class="field">
						<div class="control has-icons-right">
							<input class="input is-rounded" type="text" placeholder="CH-30000000">				
							<div class="icon is-right">
								<i class="osf osf-search"></i>								
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="column is-one-third" v-for="(entry, name) in depart">
				<router-link to="/doctors" tag="div" class="card is-shadowless short-card cursored">
					<h3 class="is-pulled-right osq-text-primary">{{ entry.count }}</h3>
					<span><i class="icon" :class="[$root.getIcon(entry.icon)]"></i>
					<span class="subtitle is-4">{{ entry.name }}</span></span>
				</router-link>
			</div>
		</div>
	</section>
</template>

<script>
export default {
	name: 'Dashboard',
	data() {return {
		modal: false,
		depart: [
			{name: 'Doctors', count: 7, icon: 'patient'}, 
			{name: 'Patients', count: 100, icon: 'doctor'},
		],
	}},
}	
</script>
