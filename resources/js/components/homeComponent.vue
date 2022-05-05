<template>

        <div class="container">
        <transition>
            <div class="modal-overlay" v-if="showModal"></div>
        </transition>
        <transition>
            <div class="modalList" v-if="showModal" >
                <div v-for="(employee, index) in employeeList" :key="employee.id">
                    <div v-if="index == indexModal">
                        <div class="row align-items-start">
                            <div class="col-2">
                                Name: 
                            </div>
                            <div class="col-10">{{employee.name}}</div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-2">
                                email: 
                            </div>
                            <div class="col-10">{{employee.email}}</div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-2">
                                phone: 
                            </div>
                            <div class="col-10">{{employee.phone}}</div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-2">
                                address: 
                            </div>
                            <div class="col-10">{{employee.address}}</div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-2">
                                position: 
                            </div>
                            <div class="col-10">{{employee.position}}</div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-2">
                                salary: 
                            </div>
                            <div class="col-10">{{employee.salary}}</div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-2">
                                skills: 
                            </div>
                            <div class="col-10">{{employee.skills}}</div>
                        </div>
                    </div>
                </div>
                <button @click="showModal = false" class="btn">Cerrar</button>
            </div>
        </transition>
        <!-- <button @click="showModal = true">abrir modal</button> -->
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">LISTADO DE EMPLEADOS</div>
                        <div class="card-body py-3">
                            <label for="email">Busqueda por Correo Electronico</label><br>
                            <input name="email" type="text" class="form-control" v-model="filterEmail">
                            <table class="table display responsive nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th ></th>
                                        <th >Name</th>
                                        <th >Email</th>
                                        <th >Position</th>
                                        <th >Salary</th>
                                        <th >More</th>
                                    </tr>
                                </thead>
                                <tbody style="color:black" v-for="(employee, index) in employeeList" :key="employee.id">
                                    <tr v-if="employee.email.includes(filterEmail) || filterEmail == ''">
                                        <td>{{index}}</td>
                                        <td>{{employee.name}}</td>
                                        <td>{{employee.email}}</td>
                                        <td>{{employee.position}}</td>
                                        <td>{{employee.salary}}</td>
                                        <td><center><button type="button" class="edit btn btn-info btn-sm" @click="showModal = true, indexModal = index"><i class="far fa-file-alt"></i></button></center></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        data(){
            return {
                employeeList: [],
                showModal: false,
                indexModal:0,
                filterEmail: '',
            }
        },
        created(){
            axios.get('/empleadosList')
                .then(
                    response => this.employeeList = response.data
                    )
                .catch();
        },
    }

</script>

<style>
    .modal-overlay{
        position: absolute;
        top:0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 100;
        background: rgb(0, 0, 0, 0.4);
    }
    .modalList{
        width: 40%;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #FFF;
        padding: 20px;
        boder-radius:15px;
        box-shadow: 3px 3px rgb(0, 0, 0, 0.4);
        z-index: 110 ;
    }
    .btn{
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>