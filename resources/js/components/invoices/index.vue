<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter()


let invoices = ref([])
let searchInvoice = ref([])

onMounted(async () => {
    getInvoices()
})


const getInvoices = async() => {
    let response = await axios.get("/api/get_all_invoice")
    // console.log('response1',response);
    invoices.value = response.data.invoices
}

const search = async () => {
    let response = await axios.get("/api/search_invoice?s="+searchInvoice.value)
    // console.log('response2', response.data.invoices);
    invoices.value = response.data.invoices
}

const newInvoice = async () => {
    let form = await axios.get("/api/create_invoice")//laravel route
    // console.log('form',form.data)
    router.push('/invoice/new')
}

const onShow = (id) => {
    router.push('/invoice/show/'+id)
}

</script>

<template>
        <div class="container">
            <div class="invoices">
        
        <div class="card__header">
            <div>
                <!-- <a href="/"><h2 class="invoice__title">Invoice</h2></a>  -->
            </div>

        </div>

        <div class="table card__content">
            <div class="table--filter">
                <a href="/"><h2 class="invoice__title">Invoice</h2></a> 
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <div class="table--filter--listWrapper">
                   
                    <ul class="table--filter--list">
                        <li>
                            
                            <div>
                                <a class="btn btn-secondary" @click="newInvoice">
                                    <font-awesome-icon :icon="['fas', 'plus']" /> Invoice
                                </a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a class="btn btn-secondary" @click="newInvoice">
                                    <font-awesome-icon :icon="['fas', 'plus']" /> Customer
                                </a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a class="btn btn-secondary" @click="newInvoice">
                                    <font-awesome-icon :icon="['fas', 'plus']" /> Product
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table--search">

                <div class="relative">
                    <i class="table--search--input--icon fas fa-search "></i>
                    <input class="table--search--input" type="text" placeholder="Search invoice" v-model="searchInvoice" @keyup="search()">
                </div>
            </div>

            <div class="table--heading">
                <p>ID</p>
                <p>Date</p>
                <p>Number</p>
                <p>Customer</p>
                <p>Due Date</p>
                <p>Total</p>
            </div>

            <!-- item 1 -->
            <div v-if="invoices.length > 0" >
                <div class="table--items" v-for="item in invoices" :key="item.id" >
                    <a href="#" @click="onShow(item.id)">{{ item.id }}</a>
                    <p>{{ item.date }}</p>
                    <p>#{{ item.number }}</p>
                    <p v-if="item.customer">
                        {{ item.customer.firstname }}
                    </p>
                    <p v-else>

                    </p>
                    <p>{{ item.due_date }}</p>
                    <p>₱ {{ item.total }}</p>
                </div>
            </div>
            <div class="table--items" v-else>
                <p>Invoice not found</p>
            </div>
                

        </div>
        
    </div>

    <br><br><br>
        </div>
</template>