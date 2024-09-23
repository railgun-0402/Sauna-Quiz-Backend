<template>
    <center>
        <h1 class="my-3 ml-3">クイズ一覧画面</h1>

        <div class="col-5 ml-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>作成日時</th>
                        <th>更新日時</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                </thead>                
                <tbody>
                    <tr v-for="data in quiz_data" :key="data.id">
                        <td>{{ data.id }}</td>
                        <td>{{ data.content }}</td>
                        <td>{{ data.created_at }}</td>
                        <td>{{ data.updated_at }}</td>
                        <td>
                            <a @click="moveNextScreen(data.id)"
                                class="btn btn-success btn-sm">編集</a>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm">削除</a>
                        </td>
                    </tr>
                </tbody>                
            </table>
        </div>
    </center>
</template>

<script>
export default {
    props: {
        // Quizテーブルの値
        quiz_data: Object,
    },
    data() {
      return {
        edit: '/admin/quiz/edit',                
      };
    },
    methods: {
        moveNextScreen:function(id) {            
            this.$router.push({ path: this.edit, query: { id: id} })
        }
  },
};
</script>