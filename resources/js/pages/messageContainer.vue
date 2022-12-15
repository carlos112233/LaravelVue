<template>
  <div class="container-xxl " style="height:400px; overflow-y: scroll;">
    <div v-for="(message, index) in messages" :key="index">
      <message-item :message="message" />
    </div>
  </div>
</template>
<script>
import messageItem from './messageItem.vue'

export default {
  components: { messageItem },
  props: ['messages'],
}
</script>
  