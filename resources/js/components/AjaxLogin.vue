<template>
    <main class="signup-form">
    <div class="container">
        <div class="row justify-content-center m-0">
            <div class="col-md-4">

                <div class="card mt-4 mb-2">
                <div class="card-header normal">Login</div>
                    <div class="card-body">

                  <div class="alert alert-secondary text-center" role="alert" v-if="error_message">
                        <span v-html="error_message"></span>
                    </div>
                    
                    <div class="alert alert-success mb-0 text-center" role="alert" v-if="success_message">
                        <span v-html="success_message"></span>
                    </div>

                    <div v-if="!submitted"> 
                      <div class="form-group mb-3">
                        <input id="email" type="email" placeholder="Email" class="btn-block py-1 px-2" name="email" v-model="email">
                      </div>

                        <div class="d-grid mx-auto">
                          <div v-if="loading" class="text-center"><i class="fas fa-spinner fa-spin fa-1x"></i></div>
                          <button v-else type="submit" class="btn btn-primary btn-block" @click="submitForm">Get login link</button>
                        </div>
                    </div>

                    </div>
                </div>

              <div v-if="!submitted" class="text-center pt-2 pb-3"><a href="/register">Create new account</a></div>

            </div>
        </div>
    </div>
</main>
</template>

<script>
export default {

  data() {
    return {
      email: '',
      error_message: null,
      success_message: null,
      loading: false,
      showPassword: false,
      submitted: false,
    };
  },

  methods: {

      submitForm() {

          this.error_message = null;
          this.success_message = null;

          if (this.email=='') { this.sweetfire('Please enter email address')}

          else {

          this.loading = true;

          axios
          .post('/login-post', {email: this.email})
          .then((response) => {
            
            if(response.data.success) {
              this.success_message = response.data.message;
              this.submitted = true;
            }

            else {
              this.error_message = response.data.message;
            }
            
            this.loading = false;

          });

          }
      },


    sweetfire(text) {

      Swal.fire({
      title: text,
      showConfirmButton: false,
      showDenyButton: false,
      showCancelButton: true,
      focusConfirm: false,
      cancelButtonText: 'Ok',
      customClass: {
              title: "popup-title",
            },
    })

    },

  },
};

</script> 

<style>

</style>