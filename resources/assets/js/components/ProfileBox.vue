<template>
    <div class="card osq-profile-card">
        <figure class="avatar-wrapper">
            <img class="avatar" :src="avatarSrc" alt="">
        </figure>

        <div class="card-content">
            <div class="osq-text-center">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['avatar-src'],
}
</script>