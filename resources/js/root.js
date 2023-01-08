import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Landing from './components/layout/Landing';
import Navbar from './components/layout/Navbar';

// Redux
import { Provider } from 'react-redux';
import store from './store';

const Root = () => {
    return (
        <Provider store={store}>
            <Router basename='/projects/bookflight-app/public/'>
                <Navbar />
                <Routes>
                    <Route path='/' element={<Landing />}/>
                </Routes>
            </Router>
        </Provider>
    );
}

export default Root;

if (document.getElementById('root')) {

    const root = ReactDOM.createRoot(
        document.getElementById('root')
    );
    
    root.render(<Root />);
}