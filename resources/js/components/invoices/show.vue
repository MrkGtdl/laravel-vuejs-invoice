<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter()

let form = ref({id: ''})

const props = defineProps({
    id:{
        type:String,
        default:''
    }
})

onMounted(async () =>{
    getInvoice()
})

const getInvoice = async () => {
    let response = await axios.get(`/api/show_invoice/${props.id}`)
    form.value = response.data.invoice
    console.log(form.value)
}

const print = () => {
    window.print()
    router.push('/').catch(() => {})
}

const onEdit = (id) => {
    router.push('/invoice/edit/'+id)
}

const deleteInvoice = (id) => {
    axios.get('/api/delete_invoice/' + id)
    router.push('/')
}


</script>

<template>
  <div class="container">
    <div class="invoices">
        <div class="table invoice">

            <div class="action">
                <a href="/"><h2 class="invoice__title">Invoice</h2></a> 
                <ul  class="card__header-list">
                    <li>
                        <!-- Select Btn Option -->
                        <div>
                            <a class="btn btn-secondary" @click="print()">
                                <font-awesome-icon :icon="['fas', 'print']" /> Print
                            </a>
                        </div>
                        <!-- End Select Btn Option -->
                    </li>
                    <li>
                        <!-- Select Btn Option -->
                        <div>
                            <a class="btn btn-secondary" @click="onEdit(form.id)">
                                <font-awesome-icon :icon="['fas', 'edit']" /> Edit
                            </a>
                        </div>
                        <!-- End Select Btn Option -->
                    </li>
                    <li>
                        <!-- Select Btn Option -->
                        <div>
                            <a class="btn btn-secondary" @click="deleteInvoice(form.id)">
                                <font-awesome-icon :icon="['fas', 'trash']" /> Delete
                            </a>
                        </div>
                        <!-- End Select Btn Option -->
                    </li>
                    
                </ul>
            </div>

            <div class="invoice__header--item">

                <div>
                        <div class="invoice__header--item1">
                            <p>Customer:</p>
                            <span  v-if="form.customer">{{form.customer.firstname}}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Invoice No:</p>
                            <span>#{{ form.number }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Date:</p>
                            <span>{{ form.date }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Due Date:</p>
                            <span>{{form.due_date}}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Reference:</p>
                            <span>{{form.reference}}</span>
                        </div>
                    
                </div>
            </div>

            <div class="table py1">

                <div class="table--heading3">
                    <p>#</p>
                    <p>Item Description</p>
                    <p>Price</p>
                    <p>Qty</p>
                    <p>Total</p>
                </div>
    
                <!-- item 1 -->
                <div class="table--items3" v-for="(item, i) in form.invoice_items" :key="item.id">
                    <span>{{ i + 1 }}</span>
                    <span>{{ item.product.description }}</span>
                    <span>₱ {{item.price}}</span>
                    <span>{{ item.quantity }}x</span>
                    <span>₱ {{item.price * item.quantity}}</span>
                </div>
            </div>

            <div  class="invoice__subtotal">
                <div>
                    <!-- <h2>Thank you for your business</h2>    -->
                </div>
                <div>
                    <div class="invoice__subtotal--item1">
                        <p>Sub Total:</p>
                        <span>₱ {{form.sub_total}}</span>
                    </div>
                    <div class="invoice__subtotal--item2">
                        <p>Discount:</p>
                        <span>- ₱ {{form.discount}}</span>
                    </div>
                    
                </div>
            </div>

            <div class="invoice__total">
                <div>
                    <!-- <h2>Terms and Conditions</h2>
                    <p>{{form.terms_and_condition}}</p> -->
                </div>
                <div>
                    <div class="grand__total" >
                        <div class="grand__total--items">
                            <p>Total Amount: </p>
                            <span>₱ {{form.total}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
  </div>  
</template>