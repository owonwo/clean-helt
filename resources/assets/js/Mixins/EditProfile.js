import {mapGetters, mapMutations} from 'vuex'

export default {
	data() {return {
		edit: {
			basic: true,
			whiteList: [],//keys to accept
		},
	}},
	methods: {
		save_basic() {
			if(this.edit.basic === false) {
				this.edit.basic = true
			} else {
				let {edit, user} = this
				let data = Object.assign({}, user)

				for(let key of Object.keys(data)) { 
					edit.whiteList.includes(key) || (delete data[key])
				}
				this.$http.patch(edit.url, data).then(response => {
					this.edit.basic = false
					this.$notify({text: 'Profile Updated!', type: 'success', duration: 2000})
				}).catch(err => {
					this.$notify({type:'error', text: err.response.data.message, duration: 2500})
				})
			}
		},
		save_emerg() {
			if(this.edit.emergency === false) {
				this.edit.emergency = true
			} else {
				const {emergency_hospital_name, emergency_hospital_address} = this.user
				let data =  {emergency_hospital_name, emergency_hospital_address}
				this.$http.patch(`/api/patient/${this.user.chcode}/emergency`, data).then(response => {
					this.edit.emergency = false
					this.$notify({text: 'Emergency Profile Updated!', type: 'success', duration: 2000})
				}).catch(err => {
					this.$notify({type:'error', text: err.response.data.message, duration: 2500})
				})
			}
		},
		showCopiedNotification() {
			this.$notify({text: 'CHCODE COPIED', type: 'success', duration: 500 })
		},
		fallbackCopyTextToClipboard(text) {
			let textArea = document.createElement('textarea')
			textArea.value = text
			document.body.appendChild(textArea)
			textArea.focus()
			textArea.select()

			try {
				let successful = document.execCommand('copy')
				let msg = successful ? 'successful' : 'unsuccessful'
				// console.log('Fallback: Copying text command was ' + msg);
				this.showCopiedNotification()
			} catch (err) {
				console.error('Fallback: Oops, unable to copy', err)
			}
			document.body.removeChild(textArea)
		},
		copyTextToClipboard(text) {
			if (!navigator.clipboard) {
				this.fallbackCopyTextToClipboard(text)
				return
			}
			navigator.clipboard.writeText(text).then(function() {                
				this.showCopiedNotification()
				// console.log('Async: Copying to clipboard was successful!');
			}, function(err) {
				console.error('Async: Could not copy text: ', err)
			})
		}
	},
}
