<template>
  <div>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal">
      <el-menu-item index="1"><b>Ayça ÖZEFE</b></el-menu-item>
      <el-menu-item index="4"><a href="https://instagram.com/aycaozefe" target="_blank">Instagram</a></el-menu-item>
      <el-menu-item index="5"><a href="https://twitch.tv/aycaozefe" target="_blank">Twitch</a></el-menu-item>
      <el-menu-item index="6"><a href="https://youtube.com/aycaozefe" target="_blank">YouTube</a></el-menu-item>
      <el-menu-item index="7"><a href="https://twitter.com/aycaozefe" target="_blank">Twitter</a></el-menu-item>
      <el-menu-item index="3"><a href="http://discord.gg/aycaozefe" target="_blank">Discord</a></el-menu-item>
      <el-menu-item index="8"><a href="https://aycaozefe.com" target="_blank">Web</a></el-menu-item>


      <el-submenu index="2" class="float-right">
        <template slot="title"><b>Yeni Çeviri Öner</b></template>
        <el-menu-item index="2-1" @click="centerDialogVisible = true">Çeviri Yolla</el-menu-item>
<!--        <el-menu-item index="2-2">Tüm Çeviriler</el-menu-item>-->

      </el-submenu>
    </el-menu>

    <el-dialog
        title="Yeni Çeviri Gönderme Formu"
        :visible.sync="centerDialogVisible"
        width="30%"
        center>
    <span>Kişileri ve etnik değerleri hedef alan kötü söz ve hakaretler onaylanmayacaktır. <br/>
      Çeviri gönderen kişinin IP adresi güvenlik sebebiyle kaydedilerek saklanacaktır.</span><br/>
      <el-form :model="translateForm" ref="translateForm"  v-loading="bLoading" >
        <div class="row pt-4">
          <div class="col-lg-6 col-xs-12">
            <el-input
                type="textarea"
                placeholder="Ayça'ca metni giriniz"
                :rows="3"
                v-model="translateForm.text"
                maxlength="60"
                show-word-limit
            ></el-input>
          </div>
          <div class="col-lg-6 col-xs-12">
            <el-input
                type="textarea"
                placeholder="Türkçe karşılığını giriniz."
                :rows="3"
                v-model="translateForm.translate"
                maxlength="60"
                show-word-limit
            ></el-input>
          </div>
          <div class="col-12 pt-2">
            <small>* gönderilen çeviriler onaylandıktan sonra görülebilecektir.</small>
          </div>
        </div>

      </el-form>
      <span slot="footer" class="dialog-footer">
    <el-button @click="centerDialogVisible = false">Vazgeç</el-button>
    <el-button type="success" @click="sendTranslate()">Çeviri Gönder</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<script>
export default {
  data() {
    return {
      bLoading: false,
      translateForm: {
        text: '',
        translate: '',
      },
      centerDialogVisible: false,
      activeIndex: '1',
      activeIndex2: '1'
    };
  },
  methods: {
//centerDialogVisible = false
    sendTranslate(){
    let data = this.translateForm;
    this.bLoading = true;
    return axios.post('api/v1/create/translate', data).then(response => {
      if (response.status === 200) {
        this.$notify.info({
          title: 'Mevcut Çeviri',
          message: "Böyle bir çeviri zaten mevcut."
        });
        this.bLoading = false;
      }

      else if (response.status === 201) {
        this.$notify.success({
          title: 'Başarılı',
          message: "Çeviri başarıyla yollandı, değerlendirme sonrasında aktif olacaktır."
        });
        this.translateForm.text = '';
        this.translateForm.translate = '';
        this.bLoading = false;
        this.centerDialogVisible = false
      }else {
        this.$notify.error({
          title: 'Hata',
          message: "Bir şeyleri düzgün kodlayamamış yazılımcı arkadaş. Ona ulaşmak için me@goksel.dev'e yazabilirsin."
        });
        this.bLoading = false;
      }
    })
        .catch((err) => {
         if (err.response.status === 429) {
            this.$notify.warning({
              title: 'Zaman Aşımı',
              message: "Bu kadar çok istek atamazsınız, birazdan tekrar deneyiniz."
            });
            this.bLoading = false;
          }
        });
    }
  }
}
</script>