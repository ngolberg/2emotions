<template>
  <div>
    <div class="flex border-b p-2 bg-gray-200" @click="searchResultsShow = false">
      <div class="flex-grow logo">
        <router-link to="/" class="block lg:h-12 h-10">
          <img src="/img/logo.png" class="ml-2" alt="2emotions"/>
        </router-link>
      </div>

      <div class="flex-grow form-wrapper">
        <form class="inline-block relative" @submit.prevent="submitForm">
        <a href="/login" v-if="!user" class="block absolute top-0 bottom-0 right-0 left-0 bg-black opacity-0"></a>
        <input type="text" name="word" v-model="form.word" @input="updateField()" :placeholder="__('Who/what?')" class="w-48 sm:w-64 lg:h-12 h-10 border border-gray-400 py-1 px-2 rounded text-lg focus:outline-none focus:border-blue-500 focus:shadow focus:bg-gray-100 float-left input" autocomplete="off" maxlength="32"/>
        <button name="type" type="submit" @click="form.type=0" v-touch="submitForm" value="0" class="bg-heart-color lg:h-12 h-10 py-1 px-4 ml-2 text-white text-lg rounded hover:bg-red-500 focus:outline-none">
          <svg class="float-left md:mr-1" fill="#FFF" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve"><path fill-rule="evenodd" clip-rule="evenodd" d="M24.804,43.648L24,44l-0.804-0.352C12.862,37.313,2,22.893,2,14.884  C2.035,8.326,7.404,3.002,14,3.002c4.169,0,7.849,2.128,10,5.349c2.151-3.221,5.831-5.349,10-5.349c6.596,0,11.965,5.324,12,11.882  C46,22.893,35.138,37.313,24.804,43.648z M34,4.993c-3.354,0-6.469,1.667-8.335,4.46L24,11.946l-1.665-2.494  C20.469,6.66,17.354,4.993,14,4.993c-5.484,0-9.971,4.442-10,9.891c0,7.064,10.234,20.808,20,26.917  c9.766-6.109,20-19.852,20-26.907C43.971,9.435,39.484,4.993,34,4.993z"/></svg>
          <span class="hidden md:inline">{{ __('I love you!') }}</span></button>
        <button name="type" type="submit" @click="form.type=1" v-touch="submitForm" value="1" class="bg-gray-800 lg:h-12 h-10 py-1 px-4 ml-2 text-white text-lg rounded hover:bg-gray-900 focus:outline-none">
          <svg class="float-left md:mr-1" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink" height="24px" version="1.1" viewBox="0 0 60 60" width="24px"><title/><g fill-rule="evenodd" stroke="none" stroke-width="1"><path d="M37 25c-1.132 0-2.192.439-3.052 1.129C33.664 23.519 32.092 21 29 21c-1.24 0-2.233.409-3 1.063V5c0-2.663-2.336-5-5-5s-5 2.337-5 5v17.063C15.233 21.409 14.24 21 13 21c-3.436 0-5 3.11-5 6v2H5c-5 0-5 5.084-5 10 0 2.142.186 5.158 1.071 7.371l.143.358C3.195 51.692 6.51 60 15 60h15c5.951 0 12-12.189 12-19V30c0-2.663-2.337-5-5-5zm3 16c0 6.832-5.981 17-10 17H15c-7.134 0-9.905-6.943-11.929-12.014l-.143-.357C2.321 44.11 2 41.818 2 39c0-5.685.272-8 3-8h3v8a1 1 0 1 0 2 0V27c0-.163.034-4 3-4s3 3.837 3 4v2a1 1 0 1 0 2 0V5c0-1.542 1.458-3 3-3s3 1.458 3 3v24a1 1 0 1 0 2 0v-2c0-.163.034-4 3-4s3 3.837 3 4v6a1 1 0 1 0 2 0v-3c0-1.542 1.458-3 3-3s3 1.458 3 3v11z" transform="translate(7 0)" fill="#fff"/></g></svg>
          <span class="hidden md:inline">{{ __('fuck off!') }}</span></button>

        <div v-if="errorMessage()" class="absolute bg-red-500 text-white rounded-lg p-4 w-96 left-0 shadow z-20">
          {{ errorMessage() }}
        </div>

        <div v-if="searchResultsShow" class="absolute bg-gray-500 text-white rounded-lg p-4 w-96 left-0 shadow z-20">
          <div v-for="result in searchResults" @click="focus = false">
            <router-link :to="result.links.self" class="block">
              <div class="flex items-center">
                <div class="pl-3">
                  {{ result.data.word }}
                </div>
              </div>
            </router-link>
          </div>
        </div>

      </form>
      </div>

      <div class="flex-grow lg:block hidden">
        <select @change="changeLang($event)" class="lg:h-12 h-10 py-1 px-4 ml-1 bg-white text-lg order border-gray-400 rounded">
          <option value="ru" :selected="lang=='ru'">Русский</option>
          <option value="en" :selected="lang=='en'">English</option>
          <option value="it" :selected="lang=='it'">Italiano</option>
        </select>
      </div>
      <div class="flex-grow lg:block hidden">
        <router-link to="/logout" v-if="user" class="lg:h-12 h-10 py-1 px-4 ml-1 bg-white leading-10  text-lg border-gray-400 rounded inline-block hover:bg-gray-400">{{ __('Log out') }}</router-link>
        <router-link to="/login" v-else class="lg:h-12 h-10 py-1 px-4 ml-1 bg-white leading-10  text-lg border-gray-400 rounded inline-block hover:bg-gray-400">{{ __('Sign in') }}</router-link>
      </div>
    </div>

    <div class="border-b pl-2 lg:pl-4 menu">
      <router-link to="/" class="sortLink inline-block bg-white pl-3 pr-3 pt-1 pb-1 hover:bg-gray-100">{{ __('Latest') }}</router-link>
      <router-link to="/toplaved" class="sortLink inline-block bg-white pl-3 pr-3 pt-1 pb-1 hover:bg-gray-100">{{ __('Top loved') }}</router-link>
      <router-link to="/tophated" class="sortLink inline-block bg-white pl-3 pr-3 pt-1 pb-1 hover:bg-gray-100">{{ __('Top hated') }}</router-link>
      <router-link v-if="user" to="/mylist" class="sortLink inline-block bg-white pl-3 pr-3 pt-1 pb-1 hover:bg-gray-100">{{ __('My list') }}</router-link>
    </div>

    <div class="lg:hidden block z-20 bg-white border-t border-gray-400 bottom-0 left-0 right-0 pt-1 pb-1 fixed flex mobile-footer bottom-menu">
      <div>
        <select @change="changeLang($event)" class="h-10 py-1 px-4 ml-2 bg-white text-lg order border border-gray-400 rounded">
          <option value="ru" :selected="lang=='ru'">Русский</option>
          <option value="en" :selected="lang=='en'">English</option>
          <option value="it" :selected="lang=='it'">Italiano</option>
        </select>
      </div>
      <div>
        <router-link to="/logout" v-if="user" class="text-gray-900 right-0 text-lg text-bold mr-2 ml-2 leading-9 inline-block">{{ __('Log out') }}</router-link>
        <router-link to="/login" v-else class="text-gray-900 text-lg text-bold mr-2 ml-2 leading-9 inline-block lg:mt-1 mt-0">{{ __('Sign in') }}</router-link>
      </div>
    </div>
  </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        name: "TopBar",

        props: [
            'user',
            'lang',
            'is_admin',
        ],

        data: function () {
            return {
                form: {
                    'word': '',
                    'type': 0,
                },
                searchResults: [],
                searchResultsShow: false,
                errors: null,
                order: $cookies.get('order') ? $cookies.get('order') : 'top',
            }
        },

        methods: {
            updateField: _.debounce(function (e) {
                if (this.errors && this.errors['word']) {
                    this.errors['word'] = null;
                }

                if (this.form.word.length < 3) {
                    this.searchResults = [];
                    this.searchResultsShow = false;
                    return;
                }

                axios.post('/api/search', {searchTerm: this.form.word})
                    .then(response => {
                        if (this.form.word.length < 3) {
                            return false;
                        }

                        this.searchResults = response.data.data;
                        if (this.searchResults.length) {
                            this.searchResultsShow = true;
                        } else {
                            this.searchResultsShow = false;
                        }
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            }, 300),

            changeLang: function (event) {
                axios.patch('/api/lang/' + event.target.value)
                    .then(response => {
                        location.reload();
                    })
                    .catch(errors => {
                      alert(errors.response.message);
                    });
            },

            submitForm: function (event) {
                //this.form.type = event.submitter.value;
                this.searchResultsShow = false;

                axios.post('/api/words', this.form)
                    .then(response => {
                        this.form.word = '';
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            errorMessage: function () {
                if (this.errors && this.errors['word'] && this.errors['word'].length > 0) {
                    return this.errors['word'][0];
                } else {
                    return '';
                }
            },
        }
    }
</script>

<style scoped>
  .logo {
    min-width: 59px;
  }
  .logo img {
    height: 100%;
  }
  .form-wrapper {
    flex-grow: 100;
  }
  .h-12 {
    height: 3.6rem;
  }
  .mobile-footer {
    -webkit-box-shadow: 0px -2px 5px 0px rgba(50, 50, 50, 0.27);
    -moz-box-shadow:    0px -2px 5px 0px rgba(50, 50, 50, 0.27);
    box-shadow:         0px -2px 5px 0px rgba(50, 50, 50, 0.27);
  }

  .menu a {
    border-bottom: 2px solid #fff;
  }
  .menu a:not(.router-link-exact-active):hover {
    border-bottom: 2px solid #f7fafc;
  }
  .menu .router-link-exact-active {
    border-bottom: 2px solid #000;
  }

  .bottom-menu >div {
    text-align: right;
    width: 100%;
  }
  .bottom-menu >div:first-child {
    text-align: left;
  }

  @media (max-width: 400px) {
    button.px-4 {
      padding-left: 0.5rem;
      padding-right: 0.5rem;
    }
    .logo {
      min-width: 45px;
    }
    .logo img {
      margin: 0;
    }
  }
</style>