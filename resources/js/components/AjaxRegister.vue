<template>
<main class="signup-form">
    <div class="container">
        <div class="row justify-content-center m-0">
            <div class="col-md-4">

                <div class="card mt-4 mb-2">
                <div class="card-header normal">Register</div>
                    <div class="card-body">

                        <div class="alert alert-danger text-center" role="alert" v-if="error_message">
                        <span v-html="error_message"></span>
                        </div>
                        
                        <div class="alert alert-success mb-0 text-center" role="alert" v-if="success_message">
                            <span v-html="success_message"></span>
                        </div>
                          
                          <div v-if="!submitted">
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Name" class="btn-block py-1 px-2" v-model="name">
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Surname" class="btn-block py-1 px-2" v-model="surname">

                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" class="btn-block py-1 px-2" v-model="email">
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Password" class="btn-block py-1 px-2" v-model="password">
                            </div>

                            <div class="d-grid mx-auto">
                                <div v-if="loading" class="text-center"><i class="fas fa-spinner fa-spin fa-1x"></i></div>
                                <button v-else type="submit" :class="'btn btn-primary btn-block'" @click="submitForm">Register</button>
                            </div>
                          </div>

                    </div>

                </div>

                <div v-if="!submitted" class="text-center pt-2 pb-3"><a href="/">Login</a></div>

            </div>
        </div>
    </div>
</main>
</template>

<script>

export default {
  data() {
    return {
      name: '',
      surname: '',
      email: '',
      password: '',
      error_message: '',
      success_message: '',
      loading: false,
      submitted: false,
    };
  },

  methods: {

      submitForm() {

          this.error_message = '';

          if (this.name=='') { this.sweetfire('Please enter your name')}
          else if (this.surname=='') { this.sweetfire('Please enter your surname')}
          else if (this.email=='') { this.sweetfire('Please enter your email address')}
          else if (this.password=='') { this.sweetfire('Please enter your password')}

          else {

          this.loading = true;

          axios
          .post('/api/v1/register', {
            name: this.name, 
            surname: this.surname, 
            email: this.email,
            password: this.password,
            })
          .then((response) => {
            
            if (response.data.success) {
                window.location.href = response.data.url;
            }

            else {
              this.error_message = response.data.message;
              this.loading = false;
            }

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