### Use laravel Project

**Command:-**
composer create-project laravel/laravel laravel_vue

### After Clone

1. Add new Database
2. copy .env.example to .env file

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=root
    DB_PASSWORD=

3. run composer install
4. then php artisan key:generate
5. Now Run Below Command

**Command:-**
npm install

npm run dev

### After SetUp All This

**Make Migration and Model and Controller**

**Command:-**

php artisan make:model Information

php artisan make:migration create_information_table

php artisan make:model InformatiomController

### Add code in migration database/migrations/create_information_table.php

$table->id();
$table->string('first_name')->nullable();
$table->string('middle_name')->nullable();
$table->string('last_name')->nullable();
$table->string('dob')->nullable();
$table->timestamps();

**After add and save file Create table in Database**

**Command:-**
php artisan migrate

### Add code in Model app/Models/Information.php

protected $table = 'information';
protected $fillable = ['first_name','middle_name','last_name','dob'];

### Add code in Controller app\Http\Controllers\InformationController.php

**In function**

public function index() {
    return Information::all();
}
public function store(Request $request) {
    $currentTime = Carbon::now()->format('y-m-d');
    $data = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required', 
        'middle_name' => '', 
        'dob' => 'required|before:' . $currentTime
    ]);
    Information::create($data);
    return ['message' => 'Information created!'];
    
}

**On Top**

use App\Models\Information;
use Carbon\Carbon;

### Add Code in routes/web.php

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

### Add Code in routes/api.php

**On Top**
use App\Http\Controllers\InformationController;

**On Bottom**
Route::apiResource('information', InformationController::class);

### Install Laravel Vue UI

composer require laravel/ui

php artisan ui vue

npm install vue-router vue-axios -force

npm install

npm run watch

### Initiate Vue in Laravel

**Create file in resources/views with name app.blade.php and Add Code**

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>VueJS CRUD</title>
    
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12" id="app">
                <Information/>
            </div>
        </div>
    </div>
    
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>

**Add Code in resources/js/App.js**

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Information', require('./components/Information.vue').default);

const app = new Vue({
    el: '#app',

});

**Now, create the following vue js component files inside the resources/js/components folder**
Information.vue

**Add Code in resources/js/components/Information.vue**

<template>
    <div>
        <div class="contact-form-success alert alert-success mt-4" v-if="success">
            <strong>Success!</strong> Information Submit successfully
        </div>
        <div class="contact-form-success alert alert-danger mt-4" v-if="error">
            <strong>Error!</strong> something wrong
            <span></span>
        </div>
            <div v-show="current_step == 1">
                <div class="mb-2">
                <label for="name" class="form-label">First Name</label>
                <input
                    type="text"
                    placeholder="Enter First Name"
                    class="form-control"
                    :class="hasError('first_name') ? 'is-invalid' : ''"
                    id="first_name"
                    v-model="item.first_name"
                >
                <div v-if="hasError('first_name')" class="invalid-feedback">
                    {{errors['first_name'][0]}}
                </div>
            </div>
            
            <div class="mb-2">
                <label for="tel" class="form-label">Last Name</label>
                <input
                    type="text"
                    placeholder="Enter Last Name"
                    class="form-control"
                    :class="hasError('last_name') ? 'is-invalid' : ''"
                    id="last_name"
                    v-model="item.last_name"
                >
                <div v-if="hasError('last_name')" class="invalid-feedback">
                    {{errors['last_name'][0]}}
                </div>
            </div>
        </div>
        <div v-show="current_step == 2">
            <div class="mb-2">
                <label for="tel" class="form-label">Middle Name</label>
                <input
                    type="text"
                    placeholder="Enter Middle Name"
                    class="form-control"
                    
                    id="middle_name"
                    v-model="item.middle_name"
                >
                
            </div>
        </div>
        <div v-show="current_step == 3">
            <div class="mb-2">
                <label for="tel" class="form-label">DOB</label>
                <input
                    type="date"
                    placeholder="Enter Date Of Birth"
                    class="form-control"
                    :class="hasError('dob') ? 'is-invalid' : ''"
                    id="dob"
                    v-model="item.dob"
                >
                <div v-if="hasError('dob')" class="invalid-feedback">
                    {{errors['dob'][0]}}
                </div>
            </div>
            

            <div class="col-md-12 mt-3 text-center" v-if="lists.length > 0">
                <h3 class="text-center" >All Information</h3>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Date Of Birth</th>
                        </tr>
                    </thead>
                    <tbody v-for="item in lists"
                        :key="item.id">
                        <tr>
                            <td>{{ item.first_name }}</td>
                            <td>{{ item.middle_name }}</td>
                            <td>{{ item.last_name }}</td>
                            <td>{{ item.dob }}</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
        
        <div class="d-grid">
            <button class="btn btn-success" @click="advanceStep">
                <span v-if="max_step === 3">Save</span>
                <!-- <span v-if="current_step === 2">Preview</span> -->
                <span v-else>Next</span>
            </button>
        </div>
    
    </div>
</template>
 
<script>
    export default {
        name: "Information",
        data() {
            return {
                error:false,
                success:false,
                errors:{},
                lists: [],
                item: {
                    first_name: "",
                    middle_name: "",
                    last_name: "",
                    dob: ""
                },
                current_step:1,
                max_step:1,
                
            }
        },
        mounted(){
            this.fetchAll();
        },
        methods: {
            fetchAll(){
                    axios.get('/api/information',this.item)
                    .then(res=> this.lists = res.data)
            },
            validate(){
                if(this.current_step === 1){
                    if(_.isEmpty(this.item.first_name) && _.isEmpty(this.item.last_name)){
                        axios.post('/api/information',this.item)
                        .catch((error) => {
                            if (error.response.status == 422) {
                                this.setErrors(error.response.data.errors)
                                
                            } else {
                                
                                this.onFailure(error.response.data.message)
                            }

                        })
                        return false
                    }
                    if(_.isEmpty(this.item.first_name)){
                        axios.post('/api/information',this.item)
                        .catch((error) => {
                            if (error.response.status == 422) {
                                this.setErrors(error.response.data.errors)
                                
                            } else {
                                
                                this.onFailure(error.response.data.message)
                            }

                        })
                        return false
                    }
                    if(_.isEmpty(this.item.first_name) || _.isEmpty(this.item.last_name)){
                        axios.post('/api/information',this.item)
                        .catch((error) => {
                            if (error.response.status == 422) {
                                this.setErrors(error.response.data.errors)
                                
                            } else {
                                
                                this.onFailure(error.response.data.message)
                            }

                        })
                        return false
                    }
                }
                
                return true;
            },
            advanceStep(){
                if(!this.validate()){
                    return
                }
                if(this.max_step === 3 ){
                    return this.save()
                }
                
                this.current_step++

                if(this.max_step < this.current_step){
                    this.max_step = this.current_step
                }

            },
            save() {
                try {
                    axios.post('/api/information',this.item)
                    .then((res)=>{
                        this.item = {
                            first_name: "",
                            middle_name: "",
                            last_name: "",
                            dob: ""
                        }
                        this.onSuccess(res.data.message)
                        this.fetchAll();

                    })
                    .catch((error) => {
                        if (error.response.status == 422) {
                            this.setErrors(error.response.data.errors)
                            
                        } else {
                            
                            this.onFailure(error.response.data.message)
                        }

                    })
                } catch (e) {
                    console.log(e);
                }
                
            },
            onSuccess(message){
                this.success = true;
            },
            onFailure(message){
                this.error = true;
            },
            setErrors(errors){
                this.errors = errors;
            },
            hasError(fieldname){
                return (fieldname in this.errors);
            }
        }
    }
</script>

### Start Laravel Vue Form Sumbittion

**To start this,run the two following commands respectively in two different terminals simultaneously:**

npm run watch

php artisan serve

**Open the URL in the browser:**
http://127.0.0.1:8000

## Powred By Netscape Labs Pvt.Ltd

**Client Name-**
**Ausar McGruder**