<template>
  <div>
    <chatRoomSelection-component v-if="currentRoom.id" :rooms="chatRooms" :currentRoom="currentRoom" v-on:roomchanged="setRooms($event)" />
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
          role="tab" aria-controls="home" aria-selected="true">
          Chat Rooms
        </button>
      </li> -->
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
          role="tab" aria-controls="profile" aria-selected="false">
          Messege
        </button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <!-- <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
       data
      </div> -->
      <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <message-container :messages="messages" />
        <input-message :room="currentRoom" v-on:messagesent="getMessages()" />
      </div>
    </div>
  </div>
</template>
<script>
import inputMessage from "./inputMessage.vue";
import MessageContainer from './messageContainer.vue';

export default {
  components: { inputMessage, MessageContainer },
  data: function () {
    return {
      chatRooms: [],
      currentRoom: [],
      messages: [],
    };
  },
  methods: {
    getRooms() {
      axios.get("/chat/rooms").then((response) => {
        this.chatRooms = response.data;
        this.setRooms(response.data[0]);

      }).catch(error => {
        console.log(error);
      });
    },
    setRooms(room) {
      this.currentRoom = room;
      this.getMessages();
    },
    getMessages() {
      axios.get('/chat/rooms/' + this.currentRoom.id + '/messages').then(response => {
        this.messages = response.data;
      }).catch(error => {
        console.log(error);
      });
    }
  },
  created() {
    this.getRooms();
  }
};
</script>
  