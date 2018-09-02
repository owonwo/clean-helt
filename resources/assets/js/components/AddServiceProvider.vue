<template>
    <section class="card">
        <div class="card-header"><span class="card-header-title"> Add A Hospital</span></div>
        <div class="card-content">
            <div class="field">
                <div class="control has-icons-left">
                    <span class="icon is-left"><i class="ti ti-search"></i></span>
                    <input type="text" class="input" v-model="hospital_chcode" placeholder="Enter Hospital CHCODE e.g CHH-300958483"/>
                </div> 
            </div>
            <button @click="sendAddHospitalRequest()" :class="{'is-loading': isLoading}" class="button is-rounded is-primary">Send Request <i class="ti ti-angle-right"></i></button>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            
        }
    }
</script>

