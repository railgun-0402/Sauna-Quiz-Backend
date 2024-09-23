<template>
  <div class="mt-1" v-if="show">
    <div class="p-1 mb-1 rounded shadow-lg" :style="customStyle">
      <h4 class="text-warning">
        <!-- {{ $t("message.comment") }} -->
        解説
      </h4>
      <div>
        <!-- TODO あとで動的に出力 -->
        サウナはフィンランド発祥の健康法であり、冷暖を交互に繰り返すことで血流を促進し、<br />
        デトックス効果を期待できます。<br />
        また、リラクゼーション効果も高く、心身の健康維持に非常に有用です。<br />
        それぞれの選択肢については以下の通りです。<br />
      </div>
      <ul :style="listStyle">
        <!-- TODO あとで動的に出力 -->
        <li>解答以外の選択肢</li>
        <li>解答以外の選択肢</li>
        <li>解答以外の選択肢</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    comment: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      show: true,
      customStyle: {
        border: '2px solid #6b8e23',
        boxShadow: '5px 5px 10px rgba(0, 0, 0, 0.2)',
      },
      listStyle: {
        listStyle: 'none',
      }
    };
  }
};
</script>
