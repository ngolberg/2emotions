<template>
  <div v-if="loading" class="p-6">
    <Preloader/>
  </div>
  <div v-else class="">
    <div :class="'text-center text-6xl pt-10 pl-2 pr-2 ' + textColor">
      {{ word.data.word }}, {{ __(wordType) }}
      <Likes class="likesComponent" :word_id="word.data.word_id" :rate="word.data.rate" :liked="word.liked" :user="user" :type="wordTypeClass"/>

      <vue-yandex-share v-bind="share"></vue-yandex-share>

      <a class="text-gray-600 text-sm underline" @click="copyLink">{{ __('Copy the link') }}</a>

      <div v-if="is_admin || user.id == word.data.user_id" class="relative">
        <button name="type" value="0" class="bg-red-400 text-sm py-1 px-4 ml-2 text-white rounded hover:bg-red-500" @click="modal = ! modal">
          {{ __('Delete') }}
        </button>
        <div v-if="modal" class="confirmation absolute bg-blue-900 text-sm text-white rounded-lg z-20 p-8 w-64">
          <p>{{ __('Are you sure you want to delete this word?') }}</p>

          <div class="flex items-center mt-6 justify-end">
            <button class="text-white pr-4" @click="modal = ! modal">{{ __('Cancel') }}</button>
            <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">{{ __('Delete') }}</button>
          </div>
        </div>
      </div>
      <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="modal = !modal"></div>
    </div>
  </div>
</template>

<script>
  import Preloader from './Preloader';
  import Likes from './Likes';
  import VueYandexShare from '@alexlit/vue-yandex-share';

  export default {
      name: "WordShow",

      mounted() {
          this.load();
      },

      data: function () {
          return {
              loading: true,
              modal: false,
              word: null,
              share: {
                  accessToken: null,
                  bare: false,
                  counter: false,
                  copy: 'last',
                  description: null,
                  direction: 'horizontal',
                  hashtags: null,
                  image: 'http://2emotions.local/img/logo.png',
                  lang: 'en',
                  limit: 24,
                  popupDirection: 'bottom',
                  popupPosition: 'inner',
                  size: 'm',
                  title: null,
                  url: null,
                  services: [
                      'facebook',
                      'vkontakte',
                      'linkedin',
                      'twitter',
                      'telegram',
                      'viber',
                      'whatsapp',
                  ]
              }
          }
      },

      props: [
          'user',
          'is_admin',
      ],

      components: {
          Preloader,
          Likes,
          VueYandexShare
      },

      watch: {
          $route(to, from) {
              this.load();
          }
      },

      methods: {
          load: function () {
              axios.get('/api/word/' + this.$route.params.id)
                  .then(response => {
                      this.word = response.data;

                      var title = this.word.data.word + ', ' + _.get(window.i18n.messages, this.wordType);
                      document.title = title;
                      this.share.title = title;
                      $('meta[property="og:title"]').attr('content', title);

                      this.loading = false;
                  })
                  .catch(error => {
                      this.loading = false;

                      alert('Unable to fetch a word.');

                      this.$router.push('/');
                  });
          },
          destroy: function () {
              this.loading = true;
              axios.delete('/api/words/' + this.$route.params.id)
                  .then(response => {
                      this.$router.push('/');
                  })
                  .catch(error => {
                      alert('Internal Error. Unable to delete a word.');
                  });
          },
          copyLink: function() {
              var copyText = document.createElement('input'),
                  text = window.location.href;
              document.body.appendChild(copyText);
              copyText.value = text;
              copyText.select();
              copyText.setSelectionRange(0, 99999);
              document.execCommand('copy');
              document.body.removeChild(copyText);
          }
      },

      computed: {
          textColor: function () {
              if (this.word.data.type == 0) {
                  return 'text-red-500';
              } else {
                  return 'text-blue-900';
              }
          },
          wordType: function () {
              if (this.word.data.type == 0) {
                  return 'I love you!';
              } else {
                  return 'fuck off!';
              }
          },
          wordTypeClass: function () {
              if (this.word.data.type == 0) {
                  return 'love';
              } else {
                  return 'fuck';
              }
          }
      }
  }
</script>

<style scoped>
  .likesComponent {
    position: relative;
    margin: 20px auto;
    width: 50px;
    zoom: 1.5;
  }
  .confirmation {
    top: -7rem;
    left: 50%;
    margin-left: -8rem;
  }
</style>