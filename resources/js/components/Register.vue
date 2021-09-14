<template>

    <div class="container">

        <div id="app">
            <section class="vh-100 bg-image"
                     style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.jpg');">
                <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                    <div class="container h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                                <div class="card" style="border-radius: 15px;">
                                    <div class="card-body p-5">
                                        <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                                        <form>

                                            <div class="alert-danger"
                                                v-if="error"
                                                 v-for="(message,index) in errorMessage " :key="index">
                                                <div>
                                                    {{ message }}
                                                </div>

                                            </div>

                                            <div class="form-outline mb-4">
                                                <input
                                                    required
                                                    type="text" id="name" class="form-control form-control-lg"
                                                    v-model="data['name']"/>
                                                <label class="form-label" for="name">Your Name</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="email" id="email" class="form-control form-control-lg"
                                                       v-model="data['email']"
                                                       required/>
                                                <label class="form-label" for="email">Your Email</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="password" id="password"
                                                       class="form-control form-control-lg"
                                                       v-model="data['password']"
                                                       required/>
                                                <label class="form-label" for="password">Password</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="password" id="password_confirmation"
                                                       class="form-control form-control-lg"
                                                       v-model="data['password_confirmation']"
                                                       required/>

                                                <label class="form-label" for="password_confirmation">Repeat your
                                                    password</label>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="button"
                                                        class="btn btn-success btn-block btn-lg gradient-custom-4 text-body"
                                                        @click=" submit()"
                                                >
                                                    Register
                                                </button>
                                            </div>

                                            <p class="text-center text-muted mt-5 mb-0">Have already an account? <a
                                                href="#!" class="fw-bold text-body"><u>Login here</u></a></p>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            data: [],
            error: false,
            errorMessage: []
        }
    },
    methods: {
        submit() {
            const jsonData = {
                "name": this.data.name,
                "email": this.data.email,
                "password": this.data.password,
                "password_confirmation": this.data.password_confirmation
            }
            axios.post('/api/register', jsonData)
                .then((response) => {
                    if (response.status === 200) {
                    }
                })
                .catch((error) => {
                    if (error) {
                        this.error = true
                        this.errorMessage = error.response.data.errors
                    }
                });

        }
    }
}
</script>
<style scoped>
.gradient-custom-3 {
    /* fallback for old browsers */
    background: #84fab0;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5))
}

.gradient-custom-4 {
    /* fallback for old browsers */
    background: #84fab0;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1))
}

</style>
