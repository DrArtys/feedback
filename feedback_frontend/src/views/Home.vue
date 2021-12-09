<template>
	<div class="wrapper">
		<div class="container mx-auto h-full flex justify-center items-center">
			<div class="card bg-white p-3 rounded-xl shadow-sm w-1/3">
				<div class="h-full w-full flex flex-col justify-around">
					<input
						:disabled="loading"
						v-model="feedback_info.name"
						placeholder="Ваше имя"
						type="text"
						class="px-2 py-1 rounded-lg outline-none ring-2 ring-gray-200 focus:ring-blue-200 mb-3"
					/>
					<input
						:disabled="loading"
						v-model="feedback_info.phone_number"
						type="number"
						placeholder="Ваш номер телефона"
						class="px-2 py-1 rounded-lg outline-none ring-2 ring-gray-200 focus:ring-blue-200 mb-3"
					/>
					<textarea
						:disabled="loading"
						v-model="feedback_info.feedback_text"
						placeholder="Ваш отзыв"
						rows="8"
						class="px-2 resize-none py-1 rounded-lg outline-none ring-2 ring-gray-200 focus:ring-blue-200 mb-3"
					></textarea>
					<button
						@click="send_feedback"
						:disabled="loading"
						:class="{ 'bg-blue-300': false, 'bg-blue-500 hover:bg-blue-600': true }"
						class="flex justify-center items-center text-white uppercase font-bold px-2 py-1 rounded-lg mb-3"
					>
						<span v-if="!loading">Отправить</span>
						<svg
							v-if="loading"
							class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
						>
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path
								class="opacity-75"
								fill="currentColor"
								d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
							></path>
						</svg>
						<span v-if="loading">Загрузка</span>
					</button>
					<transition name="list">
						<div v-if="errors.length" class="w-full p-2 rounded-lg bg-red-400 text-white shadow-inner flex flex-col">
							<span v-for="i of errors" :key="i">Error: {{ i }}</span>
						</div>
					</transition>
					<transition name="list">
						<div v-if="message_window.enable" class="w-full p-2 rounded-lg bg-green-400 text-white shadow-inner flex flex-col">
							<span>{{ message_window.message }}</span>
						</div>
					</transition>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
	data() {
		return {
			message_window: {
				enable: false,
				message: '',
			},
			feedback_info: {
				name: '',
				phone_number: '',
				feedback_text: '',
			},
		}
	},
	methods: {
		...mapActions(['send_feedback_to_endpoint']),
		send_feedback() {
			this.send_feedback_to_endpoint(this.feedback_info).then((res) => {
				this.feedback_info.name = ''
				this.feedback_info.phone_number = ''
				this.feedback_info.feedback_text = ''
				this.open_message_window(res)
			})
		},
		open_message_window(message) {
			this.message_window.message = message
			this.message_window.enable = true
			setTimeout(() => {
				this.message_window.enable = false
			}, 3000)
		},
	},
	computed: {
		...mapState(['loading', 'errors']),
	},
}
</script>

<style scoped>
.list-item {
	display: inline-block;
	margin-right: 10px;
}
.list-enter-active,
.list-leave-active {
	transition: all 1s;
}
.list-enter, .list-leave-to /* .list-leave-active до версии 2.1.8 */ {
	opacity: 0;
	animation-delay: 0.1s;
	transform: translateY(30px);
}
</style>
