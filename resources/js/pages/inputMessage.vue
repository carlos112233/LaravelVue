<template>

  <div class="container-xxl">
    <div class="col col-lg-12">
      <div class="row">
        <div class="col-10">
          <input type="text" class="form-control form-control-sm" v-model="message" @keyup.enter="sendMessage()"
            placeholder="Say someting....">
        </div>
        <div class="col-2">
          <button @click="sendMessage()" class="btn btn-secondary btn-sm " style="float: left"> Send</button>
        </div>
      </div>
    </div>
  </div>

</template>
<script>
export default {
  props: ['room'],
  data: () => ({
    message: ''
  }),
  methods: {
    sendMessage() {
      if (this.message == ' ') {
        return;
      }
      axios.post('/chat/rooms/' + this.room.id + '/message', {
        message: this.message
      }).then(response => {
        if (response.status == 201) {
          this.message = '';
          this.$emit('messagesent');
        }
      }).catch(error => { console.log(error); });
    }
  },
}
</script>
  