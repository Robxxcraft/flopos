import { reactive } from '@vue/reactivity';
import api from "../axios";

const state = reactive({
    cart: {
        data: [],
        links: {},
        meta: {},
    }
})

const getters = reactive({
    cartItemsCount(){
        if (state.cart.meta) {
            return state.cart.meta.total;
        }
    },
    cartTotalPrice(){
        if (state.cart.data) {
            let total = 0;
            state.cart.data.forEach(item => {
                total += item.price * item.quantity;
            })
            return total
        }
    },
    cartTotalQuantity(){
        if (state.cart.meta) {
            return state.cart.meta.total_quantity
        }
    }
})

const mutations = reactive({
    ADD_TO_CART(product, quantity){
        const cartExitst = state.cart.data.find(item => {
            return item.product_id === product.id;
        });
        if(cartExitst){
            if (cartExitst.quantity >= product.stock) {
                return
            }
            cartExitst.quantity += quantity
            return
        }

        return state.cart.data.unshift({
            product_id: product.id,
            title: product.title, 
            slug: product.slug,
            category: product.category,
            price: product.price,
            stock: product.stock,
            photo: product.photo,
            quantity
        })
    },
    UPDATE_QTY(id, quantity){
        const cartExitst = state.cart.data.find(item => {
            return item.id === id;
        });
        if(quantity >= cartExitst.stock){
            return cartExitst.quantity = quantity ;
        }
        cartExitst.quantity = quantity
    },
    SET_CART(data){
        state.cart = data;
    },
    REMOVE_CART(productId){
        let index = state.cart.data.findIndex(pro => pro.id == productId)
        state.cart.data.splice(index, 1)
    },
    CLEAR_CART(){
        state.cart = {
            data: [],
            links: {},
            meta: {},
        }
    }
})

const actions = reactive({
    addProductToCart({product, quantity}){
        const cartExitst = state.cart.data.find(item => {
            return item.product_id === product.id
        });
        if (getters.cartItemsCount() >= 100) {
            return
        }
        if (cartExitst) {
            if (cartExitst.quantity+quantity >= cartExitst.stock) {
                quantity = cartExitst.stock
                api.post(`/api/cart/update/${cartExitst.id}`, {quantity: quantity})
                mutations.UPDATE_QTY(cartExitst.id, quantity)
                return
            }
        }
        if (quantity >= product.stock) {
            quantity = product.stock
        }
        mutations.ADD_TO_CART(product, quantity);
        api.post('/api/cart', {
            product_id : product.id,
            quantity
        });
    },
    changeQuantity(id, quantity){
        const cartExitst = state.cart.data.find(item => {
            return item.id === id;
        });
        if (cartExitst) {
            if (quantity >= cartExitst.stock) {
                quantity = cartExitst.stock
            }
        }
      api.post(`/api/cart/update/${id}`, {quantity: quantity})
      mutations.UPDATE_QTY(id, quantity)
    },
    getCart(page=1){
        mutations.CLEAR_CART()
        return new Promise((resolve, reject)=>{
            api.get(`/api/cart?page=${page}`).then(res => {
                mutations.SET_CART(res.data);
                resolve(res.data);
            }).catch(err => {
                reject(err)            
            })
        })
    },
    removeCart(id){
        mutations.REMOVE_CART(id);
        api.delete(`/api/cart/${id}`)
    },
    clearCart(){
        mutations.CLEAR_CART();
        api.delete('/api/cart-clear/');
    }
})

export default { state, getters, mutations, actions }