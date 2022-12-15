<template>
  <div class="col col-lg-12">
      <div class="row">
        <div class="col-9">  {{ selected.name }} Chat</div>
        <div class="col">  
        
    <select class="form-select" aria-label="Default select example" v-model="selected"
      @change="$emit('roomchanged', selected)">
      <option selected disabled>Selected</option>
      <option v-for="(room, index) in rooms" :key="index" :value="room">{{ room.name }}</option>
    </select></div>
      </div>
    
  </div>
</template>
<script>

export default {
  props: ['rooms', 'currentRoom'],
  data: () => ({
    selected: ''
  }),
  created() {
    this.selected = this.currentRoom
  }
}
</script>
  