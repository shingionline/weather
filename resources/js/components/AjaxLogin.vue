<template>
    <main class="signup-form">
    <div class="container">
        <div class="row justify-content-center m-0">
            <div class="col-md-4">

                <div class="card mt-4 mb-2">
                <div class="card-header normal">Login</div>
                    <div class="card-body">

                  <div class="alert alert-danger text-center" role="alert" v-if="error_message">
                        <span v-html="error_message"></span>
                    </div>
                    
                    <div class="alert alert-success mb-0 text-center" role="alert" v-if="success_message">
                        <span v-html="success_message"></span>
                    </div>

                    <div v-if="!submitted"> 

                      <div class="form-group mb-3">
                        <input id="email" type="email" placeholder="Email" class="btn-block py-2 px-2" name="email" v-model="email">
                      </div>

                      <div class="form-group mb-3">
                        <input id="password" type="text" placeholder="Password" class="btn-block py-2 px-2" name="password" v-model="password">
                      </div>

                        <div class="d-grid mx-auto">
                          <div v-if="loading" class="text-center"><i class="fas fa-spinner fa-spin fa-1x"></i></div>
                          <button v-else type="submit" class="btn btn-primary btn-block" @click="submitForm">Login</button>
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
      password: '',
      error_message: null,
      success_message: null,
      loading: false,
      showPassword: false,
      submitted: false,
      auth_token: null,
    };
  },

  methods: {

      submitForm() {

          this.error_message = null;
          this.success_message = null;

          if (this.email=='') { this.sweetfire('Please enter email address')}
          else if (this.password=='') { this.sweetfire('Please enter password')}

          else {

          this.loading = true;

          axios
          .post('/api/v1/login', {email: this.email, password: this.password})
          .then((response) => {
            
            if(response.data.success) {
              this.auth_token = response.data.token;
              localStorage.setItem('auth_token', this.auth_token);
              this.webLogin();
            }

            else {
              this.error_message = response.data.message;
              this.loading = false;
            }

          });

          }
      },

      webLogin() {

          axios
          .post('/web-login', {auth_token: this.auth_token})
          .then((response) => {
            
            if(response.data.success) {
              window.location.href = response.data.url;
            }

            else {
              this.error_message = response.data.message;
              this.loading = false;
            }

          });

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