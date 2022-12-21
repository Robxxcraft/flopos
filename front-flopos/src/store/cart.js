import { reactive } from '@vue/reactivity';
import api from "../axios";

const state = reactive({
    cart: [],
})

const getters = reactive({
    cartItemsCount(){
        return state.cart.length;
    },
    cartTotalPrice(){
        let total = 0;
        state.cart.forEach(item => {
            total += item.price * item.quantity;
        })
        return total
    },
    cartTotalQuantity(){
        let total = 0;
        state.cart.forEach(item => {
            total += item.quantity;
        })
        return total
    }
})

const mutations = reactive({
    ADD_TO_CART(product, quantity){
        const cartExitst = state.cart.find(item => {
            return item.product_id === product.id;
        });
        if(cartExitst){
            if (cartExitst.quantity >= product.stock) {
                return;
            }
            cartExitst.quantity += quantity;
            return;
        }

        return state.cart.unshift({
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
        const cartExitst = state.cart.find(item => {
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
        let index = state.cart.findIndex(pro => pro.id == productId)
        state.cart.splice(index, 1)
    },
    CLEAR_CART(){
        state.cart = [];
    }
})

const actions = reactive({
    addProductToCart({product, quantity}){
        if (getters.cartItemsCount() >= 100) {
            return;
        }
        const cartExitst = state.cart.find(item => {
            return item.product_id === product.id;
        });
        if (cartExitst) {
            if (cartExitst.quantity >= product.stock) {
                return;
            }
        }
        mutations.ADD_TO_CART(product, quantity);
        api.post('/api/cart', {
            product_id : product.id,
            quantity
        });
    },
    changeQuantity(id, quantity){
        const cartExitst = state.cart.find(item => {
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
    getCart(){
        api.get('/api/cart').then(res => {
            mutations.SET_CART(res.data);
        })
        return Promise.resolve('');
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