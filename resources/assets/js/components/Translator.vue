<template>
  <div class="container">
    <header-menu></header-menu>
    <div class="pt-5"></div>
    <div class="card mt-3">
      <el-form :model="translateForm" ref="translateForm">
        <div class="card-body">
          <h2 class="card-title">Ayçaca Türkçe Çeviri</h2>
          <div class="row mt-3" v-loading="loading">
            <div class="col-6">
              <el-input
                  v-on:input="eventText(translateForm.text)"
                  type="textarea"
                  :rows="5"
                  v-model="translateForm.text"
                  placeholder="Ayçaca bir şey giriniz...">
              </el-input>
            </div>
            <div class="col-6">
              <el-input
                  type="textarea"
                  :rows="5"
                  v-model="result">
              </el-input>
            </div>
          </div>
        </div>
      </el-form>
    </div>
    <hr class="mt-5">
    <div class="card mt-5" v-loading="tLoading">
      <div class="card-body">
        <h2 class="card-title">Mevcut Söylenmişler</h2>

        <el-tag class="mr-2" v-on:click="move(single.ayca)" v-for="(single, index) in data" :key="single.id">{{ single.ayca }}
        </el-tag>

      </div>
      <div class="card-footer text-right">
        <a style="font-size: 12px" class="card-link text-muted" href="https://goksel.dev" target="_blank">
          <img class="img-fluid" style="height:20px" src="goksel.png">
          tarafından kodlandı.</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      tLoading: true,
      loading: false,
      translateForm: {
        text: ''
      },
      result: ''
    }
  },
  created() {
    this.getTag();
  },
  methods: {
    move: function (message) {
      this.translateForm.text = message;
      this.eventText()
    },
    getTag() {
      axios.get("api/v1/get-list")
          .then((response) => {
            this.data = response.data;
            console.log(response.data);
            this.tLoading = false;
          }).catch((err) => {
        this.tLoading = false;
        this.$notify.error({
          title: 'Hata Oluştur',
          message: "Bir hata oluştu, sayfayı yenileyip tekrar deneyin :)"
        });

      });
      console.log('hi');
    },

    async eventText() {
      this.result = ''
      let data = this.translateForm;
      this.loading = true;
      return axios.post('api/v1/translate', data).then(response => {
        if (response.status === 200) {
          this.result = response.data.turkce;
          this.loading = false;
        } else if (response.status === 202) {
          if (this.translateForm.text == '') {
            this.result = "";
            this.loading = false;
          } else {
            this.result = "Ayçaca'da henüz böyle bir kelime yok..";
            this.loading = false;
          }
        } else {
          this.$notify.error({
            title: 'Hata',
            message: "Bir şeyleri düzgün kodlayamamış yazılımcı arkadaş. Ona ulaşmak için me@goksel.dev'e yazabilirsin."
          });
          this.loading = false;
        }
      });
    },
  }
}
</script>
