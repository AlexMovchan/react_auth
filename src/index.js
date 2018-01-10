import React from 'react';
import ReactDOM from 'react-dom';
import registerServiceWorker from './registerServiceWorker';

import 'bootstrap/dist/css/bootstrap.css';
import './index.css';

import Header from './header/header';
import Home from './home/home';

ReactDOM.render(
    <main>
        <Home />
    </main>,
    document.getElementById('root')
);
registerServiceWorker();
