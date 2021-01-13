import Home from '../views/Home';
import About from '../views/About';
import notFound from '../views/404';
import Admin from '../views/admin/Index';
import Struct from '../views/admin/Struct';
import Category from '../views/admin/Category';
import Create from '../views/admin/Create';
import Index from '../views/products/Index';
import Show from '../views/products/Show';
import Cart from '../views/carts/Cart';
import Register from '../views/auth/Register';
import Login from '../views/auth/Login';
import Profile from '../views/auth/Profile';

import {store} from '../store/store';

export default{
    mode: "history",
    linkActiveClass: 'active',
    routes: [
        {
            path: "/",
            component: Home
        },
        {
            path: "/about",
            component: About
        },
        {
            path: "/admin/pesanan/:id_buyer?",
            name: 'admin',
            props: true,
            component: Admin,
        },
        {
            path: "/admin/category",
            name: "category",
            component: Category
        },
        {
            path: "/admin/struct/:page?",
            name: 'admin.struct',
            component: Struct,
            props: true,
        },
        {
            path: "/admin/add-product",
            name: 'admin.product',
            component: Create
        },
        {
            path: "/auth/signup",
            component: Register
        },
        {
            path: "/auth/signin",
            component: Login
        },
        {
            path: "/profile",
            component: Profile,
            beforeEnter: (to, from, next) => {
                if(store.state.isLogin){
                    next();
                }else{
                    next('/auth/signin');
                }
            }
        },
        {
            path: "/belanja/:category?",
            name: 'product',
            component: Index,
            props: true
        },
        {
            path: "/belanja/:category/:id",
            name: 'product.detail',
            component: Show
        },
        {
            path: "/keranjang",
            name: 'cart',
            component: Cart
        },
        {
            path: '*',
            component: notFound
        }
    ]
}
