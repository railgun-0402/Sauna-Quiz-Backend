<template>
  <div class="container my-5 text-center col-md-10 offset-md-2">
    <!-- エラー表示エリア -->
    <div
      v-if="errors"
      class="alert alert-warning text-dark col-md-10 offset-md-2"
      role="alert"
    >
      <ul class="mb-0 list-unstyled">
        <!-- エラーメッセージリスト -->
        <li v-for="(errorList, index) in errors" :key="'error-' + index">
          <div v-for="error in errorList" :key="error">{{ error }}</div>
        </li>
      </ul>
    </div>

    <!-- クイズの質問部分 -->
    <div class="row">
      <div class="col-md-10 offset-md-2">
        <div class="question py-4">
          <h5 class="text-danger mb-0 d-inline-block">Q.</h5>
          <h5 class="ml-2 d-inline-block">{{ quiz.content }}</h5>
        </div>
      </div>
    </div>

    <!-- 選択肢一覧 -->
    <div class="row mt-3 col-md-10 offset-md-2">
      <div class="col-lg-6 offset-lg-4">
        <!-- 各選択肢 -->
        <div
          class="form-check mt-2 d-flex align-items-center"
          v-for="(choice, index) in choices"
          :key="index"
        >
          <input
            class="form-check-input"
            type="radio"
            name="a"
            :id="'a' + (index + 1)"
            v-model="selectedAnswer"
            :value="choice.id"
            :disabled="correct !== null"
          />
          <label class="form-check-label" :for="'a' + (index + 1)">{{
            choice.content
          }}</label>
        </div>
      </div>
    </div>

    <!-- 回答ボタン -->
    <div class="row mt-5">
      <div class="col-lg-5 offset-lg-4 d-flex justify-content-center">
        <button
          class="btn btn-warning btn-lg mr-4 me-4 px-4"
          type="button"
          :disabled="correct !== null"
        >
          正解を見る
        </button>
        <button
          class="btn btn-success btn-lg ml-4 px-4"
          type="button"
          @click="submitAnswer"
          :disabled="correct !== null"
        >
          回答する
        </button>
      </div>
    </div>

    <!-- 正誤のフィードバックとコメント表示 -->
    <div class="row mt-5 col-md-10 offset-md-2" v-if="correct !== null">
      <div class="col-12">
        <div v-if="correct" class="alert alert-success" role="alert">正解！</div>
        <div v-else class="alert alert-danger" role="alert">不正解…</div>
        <QuizComment :comment="comment" />
      </div>
    </div>

    <!-- 次のクイズへ進むボタン -->
    <div class="row mt-1 col-md-10 offset-md-2" v-if="correct !== null">
      <div class="col-lg-8 offset-lg-2 d-flex justify-content-center">
        <button
          type="button"
          class="btn btn-primary btn-lg px-4 waves-effect waves-light"
          @click="loadNextQuiz"
        >
          <i class="fas fa-arrow-right mr-2"></i>次へ
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import QuizComment from "./QuizComment.vue";
import axios from "axios";

export default {
  components: {
    QuizComment,
  },
  props: {
    quiz: {
      type: [Object, Array],
      required: true,
    },
    choices: {
      type: [Object, Array],
      required: true,
    },
  },
  data() {
    return {
      selectedAnswer: null,
      correct: null,
      comment: null,
      errors: null,
    };
  },
  methods: {
    submitAnswer() {
      axios
        .post(route("quiz.submit"), {
          answer: this.selectedAnswer,
          quiz_id: this.quiz.id,
        })
        .then((response) => {
          this.correct = response.data.correct;
          this.comment = response.data.comment;
        })
        .catch((error) => {
          if (error.response && error.response.data && error.response.data.errors) {
            this.errors = error.response.data.errors;
          }
        });
    },
    loadNextQuiz() {
      window.location.href = route("quiz.index");
    },
  },
  watch: {
    selectedAnswer() {
      // selectedAnswerが変更されるたびにerrorsをリセット
      this.errors = null;
    },
  },
};
</script>
