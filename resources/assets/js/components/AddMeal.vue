<template>
    <div class="text-dark">
        <bs-modal-popup :show.sync="showModal">
            <div class="text-center">
                <h3>Add Meal</h3>
                <div class="form-group">
                    <input
                        v-model="search"
                        autofocus
                        placeholder="Search meals..."
                        type="text"
                        class="form-control form-control-lg text-center"
                    />
                </div>
                <div>
                    <p
                        v-for="option in mealOptions"
                        @click="addMealToDate(option.id)"
                        class="meal-option text-dark"
                    >{{ option.name }}</p>
                    <p
                        v-if="search"
                        @click="addMealToDatabaseAndDate()"
                        class="meal-option"
                    >Add {{ search }}</p>
                </div>
            </div>
        </bs-modal-popup>
        <div class="text-center mt-2">
            <button class="btn btn-sm btn-link text-light" @click="showAddMealModal">
                <i class="fa fa-plus"></i> Add meal
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
            bsModalPopup: require('./BsModalPopup.vue')
        },
        props:{
            meals: Array,
            date: String
        },
        data(){
            return {
                showModal: false,
                search: "",
                mealOptions: []
            }
        },
        watch: {
            search: function () {
                this.filterMeals()
            },
            showModal: function(){
                this.search = ""
            }
        },
        methods: {
            getMeals() {
                axios.get('/api/meals', {
                    params: {
                        search: this.search,
                        excluded_meals: this.meals.map(meal => meal.id)
                    }
                })
                    .then(response => {
                        this.mealOptions = response.data
                    })
            },
            filterMeals: _.debounce(function () {
                this.getMeals()
            }, 400),
            addMealToDate(mealId) {
                axios.post('/api/calendar/' + this.date + '/meals/', {
                    meal_id: mealId
                })
                    .then(response => {
                        this.$emit('reload-meals')
                        this.showModal = false
                    })
            },
            addMealToDatabaseAndDate() {
                axios.post('api/meals', {
                    name: this.search
                })
                    .then(response => {
                        this.addMealToDate(response.data.data.id)
                    })
            },
            showAddMealModal() {
                this.mealOptions = []
                this.getMeals();
                this.showModal = true;
            }
        }
    }
</script>

<style scoped>

    .meal-option {
        cursor: pointer;
        background: white;
        border-radius: 3px;
        padding: 5px;

        text-align: center;
    }

</style>