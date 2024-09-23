<template>
  <div class="col-md-10 offset-md-2">
    <div class="d-flex flex-column align-items-center mt-4 p-3 rounded bg-light">
      <h4 class="mb-3 font-weight-bold">サウナクイズ</h4>
      <p class="mb-3">正しい知識を身につけてサウナに入りましょう</p>
      <a :href="quizUrl" class="btn btn-success bg-gradient">クイズに回答してみる</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quizUrl: "/quiz",
    };
  },
};
</script>
