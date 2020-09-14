<template>
  <div class="container mt-5">
    <h1>Ayçaca Türkçe Çeviri</h1>
    <div class="card card-default mt-5">
      <el-form :model="translateForm" ref="translateForm">
        <div class="card-body">
          <div class="row"  v-loading="loading">
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
      loading:false,
      translateForm: {
        text: ''
      },
      result: ''
    }
  },
  methods: {
    async eventText() {
      this.result = ''
      let data = this.translateForm;
      this.loading = true;
      return axios.post('api/v1/translate', data).then(response => {
        if (response.status === 200) {
            this.result = response.data.turkce;
          this.loading=false;
        }
        else if (response.status === 202) {
            this.result = "Ayçaca'da henüz böyle bir kelime yok..";
          this.loading = false;
        }
        else {
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
