<template>
	<section>
		<div class="columns is-centered">
			<div class="column is-two-thirds">
				<div class="field has-addons-right">
					<p class="control has-icons-right has-shadow">
						<input type="text" class="input" placeholder="Find Service Provider by CH-Code">
						<span class="is-right icon"><i class="osf osf-search"></i></span>
					</p>
				</div>
			</div>
		</div>
		
		<section class="card">
			<div class="card-header">
				<span class="card-header-icon"><i class="icon osf osf-department"></i></span>
				<span class="card-header-title">Departments</span>
				<div class="m-10">
					<button class="button is-outlined is-white">ADD</button>
				</div>
			</div>
			<div class="tabs mb-5">
				<ul>
					<li :class="{'is-active': current == 1}"><a @click.prevent="current=1" href="#">Hospital</a></li>
					<li :class="{'is-active': current == 2}"><a @click.prevent="current=2" href="#">Pharmacy</a></li>
					<li :class="{'is-active': current == 3}"><a @click.prevent="current=3" href="#">Laboratory</a></li>
					<li :class="{'is-active': current == 4}"><a @click.prevent="current=4" href="#">Doctors</a></li>
				</ul>
			</div>
			<pager align="top" :current="current">
				<div class="px-15" :slot="'p'+ai" :key="ai" v-for="ai in 5">
					<table class="table is-hoverable is-fullwidth">
						<tr>
							<th width="100">CHCODE</th>
							<th>Provider Name</th>
							<th>Email</th>
							<th width="50">Status</th>
						</tr>
						<tr v-for="(a) in 5">
							<td>CH/30{{a}}</td>
							<td>Peter Lakewood's Hospital</td>
							<td>help@plh.care</td>
							<td><span class="tag is-primary">Active</span></td>
						</tr>
					</table>
				</div>
			</pager>
		</section>
	</section>
</template>

<script>
	import Pager from '@/components/Pager.vue';

	export default {
		components: {Pager},
		name: 'Users',
		data() {return {
			current: 0,
			columns: [{}],
		}}
	}
</script>
