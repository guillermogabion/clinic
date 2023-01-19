<template>
<v-app>
    <div>
    <v-sheet
    style="max-height: 101.2vh;"
    fluid
    >
    <div class="text-center login">
                    <v-card
                    width="500"
                    class="mx-auto"
                    elevation="3"
                    color="white"
                    >
                    <v-card>
                        
                        <!-- <div
                         style="padding-top: 4%"
                        >
                        <v-img 
                        contain
                        :src="logocard"
                        max-height="30%"
                        width="50%"
                        class="mx-auto"
                        />
                    </div> -->
                    <span class="login_title">Dental Clinic</span>

                    <v-col>
                        <v-text-field
                            v-model="email"
                            filled
                            rounded
                            dense
                            label="Email"
                        ></v-text-field>
                
                        <v-text-field
                            v-model="password"
                            filled
                            rounded
                            dense
                            :type="isPasswordVisible ? 'text' : 'password'"
                            label="Password"
                            placeholder="············"
                            :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                            @click:append="isPasswordVisible = !isPasswordVisible"
                        
                        ></v-text-field>
                        
                        <v-card-actions>
                        <v-spacer></v-spacer>
                            <v-btn
                                rounded
                                color="success"
                                class= "mb-2 px-7"
                                @click="Login()"
                            >
                                Login
                            </v-btn>
                            <v-btn
                                rounded
                                color="primary"
                                class= "mb-2 px-3"
                                @click="register()"
                            >
                                Register
                            </v-btn>
                        <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-col>
                    </v-card>
                    </v-card>
                    <v-dialog 
                        v-model="dialog"
                        width="500px"
                        >
                        <v-card>

                            <v-form
                                ref="form"
                                v-model="valid"
                                lazy-validation
                            >
                                <v-card-title>Register</v-card-title>
                                <v-sheet
                                class="ma-2"
                                >
                                    <v-text-field
                                        outlined
                                        label="First Name"
                                        v-model="payload.first_name"
                                        :rules="firstRules"
                                    ></v-text-field>
                                    <v-text-field
                                        outlined
                                        label="Last Name"
                                        v-model="payload.last_name"
                                        :rules="lastRules"
                                    ></v-text-field>
                                    <v-text-field
                                        outlined
                                        label="Age"
                                        type="number"
                                        :rules="ageRules"
                                        v-model="payload.age"
                                    ></v-text-field>
                                    <v-text-field
                                        outlined
                                        label="Birth Date"
                                        type="date"
                                        :rules="birthRules"
                                        v-model="payload.birthdate"
                                    ></v-text-field>
                                    <v-text-field
                                        outlined
                                        label="Address"
                                        :rules="addressRules"
                                        v-model="payload.address"
                                    ></v-text-field>
                                    <v-text-field
                                        outlined
                                        label="Contact"
                                        :rules="contactRules"
                                        v-model="payload.contact"
                                        type="number"
                                    ></v-text-field>
                                    <v-text-field
                                        outlined
                                        label="Email"
                                        :rules="emailRules"
                                        v-model="payload.email"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="payload.password"
                                        outlined
                                        :type="isPasswordVisible ? 'text' : 'password'"
                                        label="Password"
                                        placeholder="············"
                                        :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                                        @click:append="isPasswordVisible = !isPasswordVisible"
                                    
                                    ></v-text-field>
                                    <v-checkbox
                                        v-model="payload.medical"
                                        label="Do you have medical concerns?"
                                        class="align-label"
                                    ></v-checkbox>

                                    <v-text-field 
                                    v-if="payload.medical == true"
                                    outlined
                                    v-model="payload.medical_record"
                                    ></v-text-field>
                                    <v-checkbox
                                        v-model="payload.dental"
                                        label="Do you have dental history?"
                                    ></v-checkbox>
                                    <v-text-field 
                                    v-if="payload.dental == true"
                                    outlined
                                    v-model="payload.dental_record"
                                    ></v-text-field>
                                </v-sheet>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        :disabled="!valid"
                                        rounded
                                        color="primary"
                                        class= "mb-2 px-3"
                                        @click="save()"
                                    >
                                        Submit
                                </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
                    </v-dialog>
                   
                </div>
     
    </v-sheet>
</div>
     

    <!-- <v-card
      class="mx-auto"
      max-width="344"
      padding-top="20px"
      outlined
    >
      
  
      <v-card-actions>
      
      </v-card-actions>
    </v-card> -->
</v-app>
</template>

<script>
import logo from '../assets/logo.jpg'
import logocard from '../assets/logocard.png'
import { mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { login, store } from "../repositories/user.api";
export default {
   data() {
    return {
        valid : true,
        isPasswordVisible: false,
        icons: {
            mdiEyeOutline,
            mdiEyeOffOutline,
        },
        logo, 
        logocard,
        email: '',
        password: '',
        dialog : false,
        payload : {
            first_name: '',
            last_name : '',
            age : '',
            address : '',
            birthdate : '',
            contact: '',
            email : '',
            password : '',
            medical: false,
            dental : false,
            medical_record: '',
            dental_record : '',
        },
        firstRules: [
            v => !!v || 'First Name is required',
        ],
        lastRules: [
            v => !!v || 'Last Name is required',
        ],
        ageRules: [
            v => !!v || 'Age is required',
        ],
        birthRules: [
            v => !!v || 'Birth Date is required',
        ],
        addressRules: [
            v => !!v || 'Address is required',
        ],
        passwordRules: [
            v => !!v || 'Password is required',
        ],
        contactRules: [
            v => !!v || 'Contact is required',
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
    }
   },
   methods : {
        Login() {
          const login_data = {
              email: this.email,
              password: this.password
          }
          login(login_data).then(({data}) => {
            //   this.$store.commit('login', data)
              localStorage.setItem('token', data.access_token)
              this.routeEnter();
          }).catch((errors)=> {
              console.log(errors)
            //   this.snackbar = true
              
          })
        },
        routeEnter(){
            this.$router.push('/dashboard');
        },
        routeAttend(){
            this.$router.push('/attendance');
        },
        register(){
            this.dialog = true
        },
        async save(){
            const isValid = await this.$refs.form.validate();
                if (isValid) {

                    store(this.payload).then(({data})=> {
                        console.log(data.data)
                        this.$refs.form.reset()
                        this.$refs.form.resetValidation()
                        alert('Account successfully made.');
                        this.dialog = false
                    })
                    this.dialog = true;

                }
        },
        close() {
            this.payload = ''
            this.$refs.form.reset()
            this.$refs.form.resetValidation()
        }
   },
   watch : {
    dialog(val) {
        val || this.close()
    }
   }
}
</script>
<style>
/* .login-page {
padding-top : 10em;
background-color: green;
} */
body {
  overflow: hidden; /* Hide scrollbars */
}

.login {
    padding-top: 10%;
}
.login_title{
    font-size: 50px;
    font-weight: bold;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}



.border {
    background-color: white;
    border-top-left-radius: 100% 55%;
    border-bottom-left-radius: 100% 55%;
    height: 100%;
    border-style: solid;
    border-width: 5px;
    box-shadow: 2px 2px 4px #000000;
    padding-left: 2em;
    padding-right: 2em;
}
.align-label {
    display: flex;
    align-items: center;
}
.align-label .v-input--selection-controls {
    margin-right: 10px;
}


</style>