<template>
    <div v-if="loading" class="p-6">
      <Preloader/>
    </div>
    <div v-else class="pl-2 pr-2 lg:pb-4 pb-16 relative" id="WordsList">
      <div v-if="words.data.length">
        <div class="overflow-hidden text-center">
          <div v-for="word in words.data" class="inline-block lg:ml-6 lg:mr-6 ml-4 mr-4 mt-2 mb-2 relative">
            <router-link :to="'/word/' + word.data.word_id" :class="'lg:text-5xl text-2xl text-' + wordColor(word.data.type) + ' ' + wordFont()">
                {{ word.data.word }}, {{ __(wordType(word.data.type)) }}
            </router-link>
            <Likes :word_id="word.data.word_id" :rate="word.data.rate" :liked="word.liked" :user="user" :type="wordTypeClass(word.data.type)"/>
          </div>
        </div>
        <div v-if="autoloading" class="p-6">
          <Preloader/>
        </div>
      </div>
      <div v-else class="pl-2 pr-2 lg:pb-4 pb-16 pt-10 text-center text-3xl">
        {{ __('Still empty. Send something first.') }}
      </div>
    </div>
</template>

<script>
  import Preloader from './Preloader';
  import Likes from './Likes';

  export default {
      name: "WordsList",

      components: {
          Preloader,
          Likes
      },

      props: [
          'user',
      ],

      data: function () {
          return {
              words: {},
              loading: true,
              page: 1,
              loadmore: true,
              autoloading: false
          }
      },

      watch: {
          $route(to, from) {
              this.load(to.path);
          }
      },

      methods: {
          load: function (path) {
              if (path == '/') {path = '';}
              var url = '/api/words' + path;

              this.loading = true;
              this.loadmore = true;
              axios.get(url)
                  .then(response => {
                      this.words = response.data;

                      this.loading = false;
                  })
                  .catch(error => {
                      this.loading = false;

                      alert('Unable to fetch words.');
                  });
          },
          scroll: function (path) {
              window.onscroll = () => {
                  if ($('#WordsList').length) {
                      let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight >= document.documentElement.scrollHeight - 20;

                      if (bottomOfWindow) {
                          if (this.loadmore) {
                              this.autoloading = true;
                              this.page++;
                              this.loadmore = false;
                              var path = this.$router.currentRoute.path == '/' ? '' : this.$router.currentRoute.path;
                              var url = '/api/words' + path + '/' + this.page;

                              axios.get(url)
                                  .then(response => {
                                      if (response.data.data.length) {
                                          this.words.data = this.words.data.concat(response.data.data);
                                          this.loadmore = true;
                                      }
                                      else {
                                          this.loadmore = false;
                                      }

                                      this.autoloading = false;
                                  })
                                  .catch(error => {
                                      this.autoloading = false;

                                      alert('Unable to fetch words.');
                                  });
                          }
                      }
                  }
              }
          },
          wordType: function (type) {
              if (type == 0) {
                  return 'I love you!';
              } else {
                  return 'fuck off!';
              }
          },
          wordTypeClass: function (type) {
              if (type == 0) {
                  return 'love';
              } else {
                  return 'fuck';
              }
          },
          wordColor: function (type) {
              if (type == 0) {
                  return 'red-600';
              } else {
                  return 'gray-800';
              }
          },
          wordFont: function () {
              let fonts = ['font-sans', 'font-mono', 'font-serif'];
              let font = fonts[Math.floor(Math.random() * fonts.length)]
              return font + (Math.random() > 0.7 ? ' italic':'') + (Math.random() > 0.7 ? ' font-semibold':'');
          }
      },

      computed: {

      },

      mounted() {
          this.load(this.$router.currentRoute.path);
          this.scroll();
      }
  }
</script>

<style scoped>

</style>