<template>
    <div v-if="show">
        <!-- The Modal -->
        <div
            @click="hideModal"
            id="myModal"
            class="modal"
        >
            <div class="row justify-content-center modal-container">
                <!-- Modal content -->
                <div
                    @click.stop
                    class="modal-content col-11 col-sm-10 col-md-8 col-lg-6 mt-md-5"
                >
                    <div class="float-right">
                        <button @click="hideModal" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:{
            show: {
                default: false
            }
        },
        watch:{
            show: function(value){
                if(value){
                    window.addEventListener('keyup', this.hideOnEscape, true);
                }
            }
        },
        methods:{
            hideModal(){
                this.$emit('update:show', false)
            },
            hideOnEscape(e){
                if (e.key == 'Escape' || e.key == 'Esc') {
                    this.hideModal()
                    window.removeEventListener('keyup', this.hideOnEscape, true);
                }
            }
        }
    }
</script>

<style scoped>
    /* The Modal (background) */
    .modal {
        display: block;
        position: fixed; /* Stay in place */
        z-index: 100; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    .modal-container {
        height: 100%;
    }
    /* Modal Content/Box */
    .modal-content {
        background-color: #f2f2f2;
        padding: 20px;
        border: 1px solid #888;
        height: 90% ;
    }
</style>