<template>
    <div class="container">
        <div class="card text-center mt-4">
            <div class="card-body" :value="user_data">
                <h3 class="card-title">プロフィール編集</h3>
                <form action="/mypage/edit/change" method="POST" @submit="submit">
                    <input type="hidden" name="_token" :value="csrf">
                    <br><br>

                    <!-- ユーザー名 -->
                    <div class="form-group">
                        <h5 class="card-title">ユーザ名:</h5>
                        <input type="text" class="form-control" name="name" v-model="name">
                    </div>

                    <!-- 自己紹介 -->
                    <div class="form-group">
                        <h5 class="card-title">自己紹介 (200文字以内):</h5>
                        <textarea class="form-control" name="introduction" v-model.trim="introduction" maxlength="200"></textarea>
                        <p>{{ introduction.length }}/200</p>
                    </div>

                    <!-- 性別 -->
                    <div class="form-group">
                        <h5 class="card-title">性別:</h5>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="sex" value="1" v-model="sex">
                            <label for="sex">男性</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="sex" value="2" v-model="sex">
                            <label for="sex">女性</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="sex" value="3" v-model="sex">
                            <label for="sex">その他</label>
                        </div>
                    </div>

                    <!-- アイコンの写真アップロード -->
                    <div class="form-group">
                        <h5 class="card-title">〜アイコンの設定〜</h5><br>
                        <div>
                            <input type="file" ref="preview" @change="uploadFile" />
                        </div>
                    </div>

                    <!-- アップロード処理 -->
                    <div class="form-group">
                        <div v-if="url" style="position: relative">
                            <div style="position:absolute" @click="deletePreview">X</div>
                            <img :src="url" class="rounded-circle" />
                        </div>
                    </div>

                    <!-- 保存ボタン -->
                    <button type="submit" class="btn btn-primary">保存</button>
                </form>
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
    submit(){
            const ans = confirm('この内容で更新しますか。');
            if(!ans) event.preventDefault();
        }

    },
    props: ["user_data"],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            upload: '/upload',
            url: '',
            user_name: '',
            introduction: '',
            sex: '',
        };
    },
    mounted() {
        console.log(this.user_data);
        this.name = this.user_data.name;
        this.introduction = this.user_data.introduction;
        this.sex = this.user_data.sex;
  }
};
</script>