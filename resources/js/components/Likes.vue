<template>
  <div class="absolute right-0 flex like-wrapper">
    <span :class="'likeCnt-'+word_id+' text-xs text-gray-500 h-4 mr-1'">{{ rate }}</span>
    <div @click="like(word_id)" :class="type + 'Btn likeBtn-'+word_id+(liked?' liked':'')+' cursor-pointer w-4 h-4 justify-center items-center text-xs'"></div>
  </div>
</template>

<script>

    export default {
        name: "Likes",

        props: [
            'word_id', 'rate', 'liked', 'user', 'type',
        ],

        methods: {
            like: function (word_id) {
                if (!this.user) {
                    $cookies.set('redirect', location.href);
                    location.href = '/login';
                } else {
                    if ($('.likeBtn-' + word_id).hasClass('liked')) {
                        $('.likeBtn-' + word_id).removeClass('liked');
                        $('.likeCnt-' + word_id).text(parseInt($('.likeCnt-' + word_id).text()) - 1);
                        axios.delete('/api/likes/' + word_id)
                            .then(response => {

                            })
                            .catch(errors => {
                                if (errors.response.status == 401) {
                                    $cookies.set('redirect', location.href);
                                    location.href = '/login';
                                }
                            });
                    } else {
                        $('.likeBtn-' + word_id).addClass('liked');
                        $('.likeCnt-' + word_id).text(parseInt($('.likeCnt-' + word_id).text()) + 1);
                        axios.post('/api/likes', {word_id: word_id})
                            .then(response => {

                            })
                            .catch(errors => {
                                if (errors.response.status == 401) {
                                    location.href = '/login';
                                }
                            });
                    }
                }
            }
        }
    }
</script>

<style scoped>
  .loveBtn {background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Ctitle%3Elike_outline_24%3C%2Ftitle%3E%3Cpath%20d%3D%22M0%2C0H24V24H0Z%22%20fill%3D%22none%22%2F%3E%3Cpath%20d%3D%22M17%2C2.9A6.43%2C6.43%2C0%2C0%2C1%2C23.4%2C9.33c0%2C3.57-1.43%2C5.36-7.45%2C10l-2.78%2C2.16a1.9%2C1.9%2C0%2C0%2C1-2.33%2C0L8.05%2C19.37C2%2C14.69.6%2C12.9.6%2C9.33A6.43%2C6.43%2C0%2C0%2C1%2C7%2C2.9a6.46%2C6.46%2C0%2C0%2C1%2C5%2C2.54A6.46%2C6.46%2C0%2C0%2C1%2C17%2C2.9ZM7%2C4.7A4.63%2C4.63%2C0%2C0%2C0%2C2.4%2C9.33c0%2C2.82%2C1.15%2C4.26%2C6.76%2C8.63l2.78%2C2.16a.1.1%2C0%2C0%2C0%2C.12%2C0L14.84%2C18c5.61-4.36%2C6.76-5.8%2C6.76-8.63A4.63%2C4.63%2C0%2C0%2C0%2C17%2C4.7c-1.56%2C0-3%2C.88-4.23%2C2.73L12%2C8.5l-.74-1.07C10%2C5.58%2C8.58%2C4.7%2C7%2C4.7Z%22%20fill%3D%22%23828a99%22%2F%3E%3C%2Fsvg%3E"); width: 16px; height: 16px;}
  .loveBtn.liked {background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg%20viewBox%3D%220%200%2024%2024%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22m0%200h24v24h-24z%22%20fill%3D%22none%22%2F%3E%3Cpath%20d%3D%22m17%202.9a6.43%206.43%200%200%201%206.4%206.43c0%203.57-1.43%205.36-7.45%2010l-2.78%202.16a1.9%201.9%200%200%201%20-2.33%200l-2.79-2.12c-6.05-4.68-7.45-6.47-7.45-10.04a6.43%206.43%200%200%201%206.4-6.43%205.7%205.7%200%200%201%205%203.1%205.7%205.7%200%200%201%205-3.1z%22%20fill%3D%22%23ff3347%22%2F%3E%3C%2Fsvg%3E");}
  .fuckBtn {background: url('/img/fuck.png') 0 0 no-repeat; background-size: cover; width: 16px; height: 16px;}
  .fuckBtn.liked {background-position: 0 -16px;}
  .like-wrapper {bottom: -6px;}
</style>