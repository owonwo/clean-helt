<template>
	<section class="card">
		<article class="card-content content">
			<hgroup class="mb-15">
				<h5 class="osq-text-primary m-0">{{ title }}</h5>
				<div>By {{ doctor_name }}</div>
			</hgroup>
			<p>{{ content }}</p>
		</article>
		
	</section>
</template>

<script>
export default {
	name: "DoctorNote",
	data() {return {
		title: "Gum decay happening in mouth.",
		doctor_name: "Dr. Aima Gook",
		timestamp: {date: "2018-01-09", time: "08:00pm"},
		content: "I observiced that lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore, autem illum ullam obcaecati modi blanditiis et, eum ipsam, veritatis culpa a magni, voluptates neque. Modi officiis et expedita, voluptate id possimus repellat magnam eos placeat corporis fuga adipisci officia ipsum consequatur accusantium rerum recusandae perferendis inventore quod! Et dignissimos, deleniti veniam vitae laud......",
		list: [],
	}}
}
</script>