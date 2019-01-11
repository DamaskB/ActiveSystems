<template>
	<div class="col-md-8">
		<div class="alert alert-warning" v-if="errors">
			<ul>
		      <li v-for="err in errors">
		      	{{ err }}
		      </li>
			</ul>
		</div>
		<form>
				<label>Выборка по дате</label>
			<div class="input-group">
				<label class="input-group-addon">От</label>
				<input class="form-control date_input" placeholder="dd.mm.yyyy" v-model="start">
			</div>
			<div class="input-group">
				<label class="input-group-addon">До</label>
				<input class="form-control date_input" placeholder="dd.mm.yyyy" v-model="end">
			</div>
			<div type="button" class="btn btn-primary" v-on:click="fetchData">Найти</div>
		</form>
		<div class="list_area" v-if="items">
			<table class="table table-bordered table-hover">
				<thead>
					<th>
						Дата
					</th>
					<th>
						Название
					</th>
					<th>
						Категория
					</th>
					<th>
						Сумма
					</th>
					<th>
						Действия
					</th>
				</thead>
				<tbody>
					<tr v-for="item in items">
						<td>{{ item.date }}</td>
						<td>{{ item.name }}</td>
						<td>{{ cats[item.category] }}</td>
						<td>{{ item.summ }}</td>
						<td>
							<button class="btn btn-primary btn-xs" v-on:click="editRec(item.id)">Изменить</button>
							<button class="btn btn-danger btn-xs" v-on:click="deletex(item.id)">Удалить</button>
						</td>
					</tr>
				</tbody>
			</table>
			<ul v-if="item_cats">
				<li v-for="(item, key) in item_cats"><b>{{ cats[key] }}:</b> {{ item }}</li>
				<li><b>Итого:</b> {{ total }}</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import bus from './bus.js';

	export default {
		data () {
			return {
				items: null,
				start: null,
				end: null,
				errors: null,
				cats: null,
				item_cats: null,
				total: null
			}
		},
		created() {
			this.fetchData();
			this.getCats();
			bus.$on('fetchData', this.fetchData);
		},
		methods: {
			getCats() {
				axios
					.get('/api/cats')
					.then(response => {
						this.cats = response.data;
					});
			},
			fetchData() {
				axios
					.get('/api/items',{
						params: {
							start: this.start,
							end: this.end
						}
					})
					.then(response => {
						this.items = response.data.items;
						this.errors = response.data.errors;
						this.item_cats = response.data.cats;
						this.total = response.data.total;
					});
			},
			deletex(id) {
				axios
					.get('/api/items/delete',{
						params: {
							id: id
						}
					})
					.then(response => {
						this.fetchData();
					});
			},
			editRec(id) {
				bus.$emit('loadRecord', id);
			}
		}
	}
</script>

<style>
	form {
	    display: flex;
    	margin-bottom: 20px;
	}
	form .date_input {
		width: 100px !important;
	}
	form .input-group, form .btn {
		margin-left: 10px;
	}
</style>