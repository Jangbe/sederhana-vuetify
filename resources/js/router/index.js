//For the main page components
import Home from '../views/Home';
import About from '../views/About';
import notFound from '../views/404';

//For admin's components
import Admin from '../views/admin/Index';
import Struct from '../views/admin/Struct';
import Category from '../views/admin/Category';
import Create from '../views/admin/Create';
import Edit from '../views/admin/Edit';
import Stok from '../views/admin/Stok';

//For user's components
import Index from '../views/products/Index';
import Cart from '../views/carts/Cart';

//For auth's components
import Register from '../views/auth/Register';
import Login from '../views/auth/Login';
import Profile from '../views/auth/Profile';

import {store} from '../store/store';

export default{
    mode: "history",
    linkActiveClass: 'active',
    routes: [
        //For the begining page
        {
            path: "/",
            component: Home
        },
        {
            path: "/about",
            component: About
        },

        //For admin's page
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
            path: "/admin/edit-product/:id_product?",
            name: 'admin.edit',
            component: Edit,
            props: true
        },
        {
            path: "/admin/add-stok/:id_product?",
            name: 'admin.stok',
            component: Stok,
            props: true
        },

        //For authenticated or not
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

        //For user logged in and not yet
        {
            path: "/belanja/:category?/:id?",
            name: 'product',
            component: Index,
            props: true
        },
        {
            path: "/keranjang",
            name: 'cart',
            component: Cart
        },

        //For page 404 not found
        {
            path: '*',
            component: notFound
        }
    ]
}
