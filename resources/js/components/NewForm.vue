<template>
	
	<div class="col-md-4 edit_area">
		<div class="alert alert-success" v-if="success">
			<p>Статья расхода успешно добавлена.</p>
		</div>
		<div class="alert alert-warning" v-if="errors">
			<ul>
		      <li v-for="err in errors">
		      	{{ err }}
		      </li>
			</ul>
		</div>
		<input type="hidden" v-model="id">
		<div class="form-group">
			<label>Название</label>
			<input class="form-control" v-model="name">
		</div>
		<div class="form-group">
			<label>Категория</label>
			<select class="form-control" v-model="category">
				<option v-for="(val, kkk) in cats" :key="kkk" v-bind:value="kkk">{{ val }}</option>
			</select>
		</div>
		<div class="form-group">
			<label>Сумма</label>
			<input class="form-control" v-model="summ">
		</div>
		<div class="form-group">
			<label>Дата</label>
			<input class="form-control date_input" v-model="date" placeholder="dd.mm.yyyy">
		</div>
		<button type="button" class="btn btn-success" v-if="newok" v-on:click="createNew">{{ button }}</button>
		<button type="button" class="btn btn-success" v-if="!newok" v-on:click="saveForm">Сохранить</button>
		<button type="button" class="btn btn-default" v-if="!newok" v-on:click="clearForm">Отменить</button>
	</div>
</template>

<script>
	import bus from './bus.js';

	export default {
		data() {
			return {
				newok: true,
				success: false,
				errors: null,
				id: null,
				date: null,
				name: null,
				category: null,
				summ: null,
				button: 'Добавить',
				cats: null
			}
		},
		methods: {
			checkForm: function () {
				this.errors = [];

				if (!this.name) {
					this.errors.push('Требуется указать название.');
				}

				if (!this.category) {
					this.errors.push('Требуется указать категорию.');
				}

				if (!this.summ) {
					this.errors.push('Требуется указать сумму.');
				}

				if (!this.date) {
					this.errors.push('Требуется указать дату.');
				}

				if (this.errors.length == 0) {
					this.errors = null;
				}

			},
			getCats() {
				axios
					.get('/api/cats')
					.then(response => {
						this.cats = response.data;
					});
			},
			createNew: function () {
				this.checkForm();
				if (this.errors == null) {
					axios
					.get('/api/items/add',{
						params: {
							name: this.name,
							category: this.category,
							summ: this.summ,
							date: this.date
						}
					})
					.then(response => {
						if(response.data.success) {
							bus.$emit('fetchData');
							this.clearForm();
						}
						this.errors = response.data.errors;
					});
				}
			},
			saveForm: function () {
				this.checkForm();
				if (this.errors == null) {
					axios
					.get('/api/items/edit',{
						params: {
							id: this.id,
							name: this.name,
							category: this.category,
							summ: this.summ,
							date: this.date
						}
					})
					.then(response => {
						if(response.data.success) {
							bus.$emit('fetchData');
							this.clearForm();
						}
						this.errors = response.data.errors;
					});
				}
			},
			clearForm: function() {
				this.newok = true;
				this.id = this.name = this.date = this.category = this.summ = null;
			},
			loadForm: function(id) {
				console.log(id);
				axios
					.get('/api/items/load',{
						params: {
							id: id
						}
					})
					.then(response => {
						this.clearForm();
						this.newok = false;
						this.id = response.data.id;
						this.name = response.data.name;
						this.category = response.data.category;
						this.summ = response.data.summ;
						this.date = response.data.date;
					});
			}
		},
		created() {
			this.getCats();
			bus.$on('loadRecord', this.loadForm);
		}
    }
</script>
