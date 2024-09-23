<template>
  <div class="container">
    <div class="card text-center mt-4">
      <div class="card-body" :value="user_data">
        <h3 class="card-title">マイページ</h3>
        <br><br>

        <!-- ユーザー名表示 -->
        <h5 class="card-title">〜あなたの名前〜</h5>
        <br>

        <h5 class="card-title">{{ user_data.name }}</h5>
        <br><br>

        <!-- クイズの回答数 -->
        <h5 class="card-title">〜クイズの回答数〜</h5>
        <br>

        <h5 class="card-title">20問解答済み</h5>
        <br><br>

        <!-- 自己紹介 -->
        <h5 class="card-title">〜自己紹介〜</h5>
        <br>
        <h5 class="card-title">{{ user_data.introduction }}</h5>
        <br><br>

        <!-- 性別 -->
        <h5 class="card-title">〜性別〜</h5>
        <br>
        <h5 class="card-title">
          <p v-if="user_data.sex === '1'">男性</p>
          <p v-else-if="user_data.sex === '2'">女性</p>
          <p v-else>未回答</p>                    
        </h5>
        <br><br>
        <!-- アイコンの写真アップロード -->
        <h5 class="card-title">〜アイコンの設定〜</h5><br>        
        <div>
          <input type="file" ref="preview" @change="uploadFile" />
        </div>
        <br>

        <!-- アップロード処理 -->
        <div v-if="url" style="position: relative">
          <div style="position:absolute" @click="deletePreview">X</div>
          <img :src="url" class="rounded-circle" />
        </div>
        <br><br>

        <!-- 編集ボタン -->
        <a :href="edit" class="btn btn-success bg-success bg-gradient">プロフィール編集</a>
        <br><br>  
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    uploadFile() {      
      const file = this.$refs.preview.files[0];
      this.url = URL.createObjectURL(file);
      // 同じ写真をプレビューすると、うまく表示されなかったので消す
      this.$refs.preview.value = "";
    },
    deletePreview(){
      this.url = '';
      URL.revokeObjectURL(this.url);
    }
  },
  props:["user_data"],
  data() {
      return {
        edit: '/mypage/edit',
        upload: '/upload',
        url: ''
      };
    },
  mounted() {
    
  }
};
</script>
