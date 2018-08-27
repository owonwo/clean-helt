<template>
	<section>
		<small class="is-info">Access to this patient information will be revoked on the <b>28th of April</b>.</small>
		<section class="columns">
			<div class="column is-half">
				<div class="card osq-profile-card is-fullwidth is-green is-landscape">
					<img src="$root.avatar" alt="" class="avatar">
					<div class="card-content has-text-right">
						<h3 class="profile-title">Dean Samuel</h3>
						<span><b>"</b>5.5 <b>-O</b></span>
						<br>
						<button class="button is-text">View Bio</button>
					</div>
				</div>
			    <accordion class="menu">
					<template slot="heading">Emergency Contact</template>
					<section slot="content" class="content">
						<table>
							<tr>
								<td>Brother</td>
								<td>+039958839288</td>
							</tr>
						</table>
					</section>
				</accordion>
				<accordion class="">
					<template slot="heading">Emergency Hospital</template>
					<section slot="content">
						<h3 class="m-0">Hospital Name: EZ Hospitals</h3>
						<b class="m-0">Address:</b>
						<p>No 35 whimpey junction, Diobu. Rivers State</p>
					</section>
				</accordion>
			</div>
			<div class="column is-half">
				LAST NOTE DESCRIPTION
				DRUGS
			</div>
		</section>

		<h1 class="osq-group-subtitle">Medical Records</h1>
		<div>	
		</div>
	</section>
</template>

<script>
	import Accordion from '@/components/Accordion.vue'

	export default {
		components: {Accordion},
		name: "PatientRecord",
		data() {return {

		}},
	}
</script>
