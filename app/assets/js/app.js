    /*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//import './styles/app.css';
import '../styles/app.css';

import { createApp } from 'vue';
// import App from './App';
// import router from './router/router';
// import store from './store/index';
import Price from './components/Price'

const app = createApp({});
app.component('price', Price);
app.mount('#app');

// createApp(App)
//     .use(router)
//     .use(store)
//     .mount('#app')

