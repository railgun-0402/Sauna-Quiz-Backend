<template>
    <center>
        <h1 class="my-3 ml-3">管理Top画面</h1>        
        <div class="d-flex flex-column align-items-center">
            <a :href="add" class="btn btn-outline-primary btn-lg">クイズ新規作成</a>
            <a :href="edit" class="btn btn-outline-secondary btn-lg">クイズを編集</a>
            <br>
            ※クイズを削除する場合は、編集画面へ遷移してください。
        </div>
        
    </center>
</template>

<script>
export default {
    data() {
      return {
        add: '/admin/quiz/add',
        edit: '/admin/quiz',        
      };
    },
};
</script>